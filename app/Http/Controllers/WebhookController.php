<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;

class WebhookController extends Controller
{
    /**
     * Handle payment webhook from NestJS Gateway
     * This endpoint is called when NestJS receives payment confirmation from Razorpay/other providers
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function handlePaymentWebhook(Request $request): JsonResponse
    {
        // Verify webhook authenticity using shared secret
        $webhookSecret = env('NESTJS_WEBHOOK_SECRET');
        // In local/dev/test environments, allow a known default secret to ease testing
        if (!$webhookSecret && app()->environment(['local', 'development', 'testing'])) {
            $webhookSecret = 'mangwale_secure_webhook_secret_2025';
        }
        // In other environments, the secret must be configured
        if (!$webhookSecret) {
            Log::error('Webhook secret not configured');
            return response()->json([
                'success' => false,
                'message' => 'Server misconfiguration'
            ], 500);
        }
    $providedSecret = $request->header('X-Webhook-Secret');
    $correlationId = $request->header('X-Correlation-Id');

        if (!$webhookSecret || $providedSecret !== $webhookSecret) {
            Log::warning('Webhook authentication failed', [
                'ip' => $request->ip(),
                'provided_secret_length' => strlen($providedSecret ?? ''),
                'correlation_id' => $correlationId,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Validate required fields
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string',
            'status' => 'required|string|in:paid,failed',
        ]);

        if ($validator->fails()) {
            Log::error('Webhook validation failed', [
                'errors' => $validator->errors()->toArray(),
                'payload' => $request->all(),
                'correlation_id' => $correlationId,
            ]);
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $orderId = $request->input('order_id');
        $paymentMethod = $request->input('payment_method');
        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');

        // Normalize payment method to match PHP's expected format
        // Convert external provider names to internal format
        // "razorpay" → "razor_pay" (displays as "RazorPay Headless" in UI)
        $normalizedPaymentMethod = strtolower($paymentMethod);
        if ($normalizedPaymentMethod === 'razorpay') {
            $normalizedPaymentMethod = 'razor_pay';
        }

        // Ensure the order exists to avoid fatal errors inside helper functions
        $order = Order::find($orderId);
        if (!$order) {
            Log::warning('Webhook referenced non-existent order', [
                'order_id' => $orderId,
                'correlation_id' => $correlationId,
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ], 404);
        }

        // Idempotency: if already processed, treat as success no-op
        if ($status === 'paid' && $order->payment_status === 'paid') {
            Log::info('Webhook idempotent: order already paid', [
                'order_id' => $orderId,
                'correlation_id' => $correlationId,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Order already paid (idempotent)',
                'order_id' => $orderId,
            ], 200);
        }
        if ($status === 'failed' && $order->order_status === 'failed') {
            Log::info('Webhook idempotent: order already failed', [
                'order_id' => $orderId,
                'correlation_id' => $correlationId,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Order already failed (idempotent)',
                'order_id' => $orderId,
            ], 200);
        }

        try {
            // Create a mock PaymentRequest object to pass to existing helper functions
            $data = (object)[
                'attribute' => 'order',
                'attribute_id' => $orderId,
                'payment_method' => $normalizedPaymentMethod,
                'transaction_ref' => $transactionId,
            ];

            // Handle based on status
            if ($status === 'paid') {
                // Call existing order_place helper function
                if (function_exists('order_place')) {
                    order_place($data);
                    
                    Log::info('Order payment confirmed via webhook', [
                        'order_id' => $orderId,
                        'payment_method' => $normalizedPaymentMethod,
                        'payment_method_original' => $paymentMethod,
                        'transaction_id' => $transactionId,
                        'correlation_id' => $correlationId,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Order payment confirmed',
                        'order_id' => $orderId,
                    ], 200);
                } else {
                    Log::error('order_place function not found');
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment processing function not available'
                    ], 500);
                }
            } elseif ($status === 'failed') {
                // Call existing order_failed helper function
                if (function_exists('order_failed')) {
                    // Use normalized method for consistency with existing helpers
                    $data->payment_method = $normalizedPaymentMethod;
                    order_failed($data);
                    
                    Log::info('Order payment failed via webhook', [
                        'order_id' => $orderId,
                        'payment_method' => $paymentMethod,
                        'correlation_id' => $correlationId,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Order payment failure recorded',
                        'order_id' => $orderId,
                    ], 200);
                } else {
                    Log::error('order_failed function not found');
                    return response()->json([
                        'success' => false,
                        'message' => 'Payment failure processing function not available'
                    ], 500);
                }
            }

            return response()->json([
                'success' => false,
                'message' => 'Unknown status'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Webhook processing error', [
                'order_id' => $orderId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'correlation_id' => $correlationId,
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }
}
