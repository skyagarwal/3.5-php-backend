<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'bring_change_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->integer('bring_change_amount')->default(0)->nullable()->after('payment_method');
            });
        }
        
        if (!Schema::hasColumn('orders', 'cancellation_note')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->text('cancellation_note')->nullable()->after('order_status');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('orders', 'bring_change_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('bring_change_amount');
            });
        }
        
        if (Schema::hasColumn('orders', 'cancellation_note')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('cancellation_note');
            });
        }
    }
};
