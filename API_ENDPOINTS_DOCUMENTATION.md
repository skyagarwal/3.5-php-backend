# Mangwale API Endpoints Documentation

## Overview
This document provides a comprehensive list of all API endpoints available in the Mangwale delivery management system.

**Base URL:** `http://your-domain.com/api/v1`  
**Admin URL:** `http://your-domain.com/admin`

---

## Table of Contents
1. [Authentication APIs](#authentication-apis)
2. [Configuration APIs](#configuration-apis)
3. [Customer APIs](#customer-apis)
4. [Cart APIs](#cart-apis)
5. [Order APIs](#order-apis)
6. [Store APIs](#store-apis)
7. [Item/Product APIs](#itemproduct-apis)
8. [Category APIs](#category-apis)
9. [Campaign APIs](#campaign-apis)
10. [Banner APIs](#banner-apis)
11. [Coupon APIs](#coupon-apis)
12. [Delivery Man APIs](#delivery-man-apis)
13. [Vendor APIs](#vendor-apis)
14. [Admin APIs](#admin-apis)

---

## Authentication APIs

### 1. Customer Sign Up
**Endpoint:** `POST /auth/sign-up`  
**Description:** Register a new customer account

**Request Body:**
```json
{
  "f_name": "John",
  "l_name": "Doe",
  "email": "john@example.com",
  "phone": "+1234567890",
  "password": "password123"
}
```

**Response:** Returns customer data with authentication token

---

### 2. Customer Login
**Endpoint:** `POST /auth/login`  
**Description:** Login for existing customers

**Request Body:**
```json
{
  "phone": "+1234567890",
  "password": "password123"
}
```

---

### 3. Verify Phone or Email
**Endpoint:** `POST /auth/verify-phone`  
**Description:** Verify phone number or email with OTP

**Request Body:**
```json
{
  "phone": "+1234567890",
  "otp": "1234"
}
```

---

### 4. Forgot Password
**Endpoint:** `POST /auth/forgot-password`  
**Description:** Request password reset

**Request Body:**
```json
{
  "email": "john@example.com"
}
```

---

### 5. Verify Reset Token
**Endpoint:** `POST /auth/verify-token`  
**Description:** Verify password reset token

**Request Body:**
```json
{
  "token": "reset_token_here"
}
```

---

### 6. Reset Password
**Endpoint:** `PUT /auth/reset-password`  
**Description:** Reset user password

**Headers:** 
- `Authorization: Bearer {token}`

**Request Body:**
```json
{
  "password": "newpassword123",
  "confirm_password": "newpassword123"
}
```

---

### 7. Delivery Man Login
**Endpoint:** `POST /auth/delivery-man/login`  
**Description:** Login for delivery men

**Request Body:**
```json
{
  "email": "delivery@example.com",
  "password": "password123"
}
```

---

### 8. Vendor Login
**Endpoint:** `POST /auth/vendor/login`  
**Description:** Login for vendors

**Request Body:**
```json
{
  "email": "vendor@example.com",
  "password": "password123"
}
```

---

### 9. Social Login
**Endpoint:** `POST /auth/social-login`  
**Description:** Login using social media platforms (Google, Facebook, Apple)

**Request Body:**
```json
{
  "token": "social_token",
  "unique_id": "unique_id",
  "email": "email@example.com",
  "medium": "google"
}
```

---

## Configuration APIs

### 1. Get Configuration
**Endpoint:** `GET /config`  
**Description:** Get general system configuration

---

### 2. Get Zone List
**Endpoint:** `GET /zone/list`  
**Description:** Get list of all delivery zones

---

### 3. Check Zones
**Endpoint:** `GET /zone/check?lat={latitude}&lng={longitude}`  
**Description:** Check available zones at specific coordinates

---

### 4. Get Zone ID
**Endpoint:** `GET /config/get-zone-id?lat={latitude}&lng={longitude}`  
**Description:** Get zone ID for specific coordinates

---

### 5. Get Payment Methods
**Endpoint:** `GET /config/get-PaymentMethods`  
**Description:** Get available payment methods

---

### 6. Get Module List
**Endpoint:** `GET /module`  
**Description:** Get list of active system modules

---

### 7. Get Terms and Conditions
**Endpoint:** `GET /terms-and-conditions`

---

### 8. Get Privacy Policy
**Endpoint:** `GET /privacy-policy`

---

### 9. Get Refund Policy
**Endpoint:** `GET /refund-policy`

---

### 10. Get Shipping Policy
**Endpoint:** `GET /shipping-policy`

---

### 11. Get Cancellation Policy
**Endpoint:** `GET /cancelation`

---

### 12. Offline Payment Methods
**Endpoint:** `GET /offline_payment_method_list`  
**Description:** Get list of offline payment methods

---

## Customer APIs

### 1. Get Customer Data
**Endpoint:** `POST /customer/get-data`  
**Authentication:** Required

---

### 2. Get Notifications
**Endpoint:** `GET /customer/notifications`  
**Authentication:** Required

---

### 3. Update Profile
**Endpoint:** `POST /customer/update-profile`  
**Authentication:** Required

**Request Body:**
```json
{
  "f_name": "John",
  "l_name": "Doe",
  "email": "john@example.com",
  "phone": "+1234567890"
}
```

---

### 4. Get Info
**Endpoint:** `GET /customer/info`  
**Authentication:** Required

---

### 5. Update Zone
**Endpoint:** `GET /customer/update-zone`  
**Authentication:** Required

---

### 6. Update Interest
**Endpoint:** `POST /customer/update-interest`  
**Authentication:** Required

---

### 7. Update Firebase Token
**Endpoint:** `PUT /customer/cm-firebase-token`  
**Authentication:** Required

---

### 8. Get Suggested Items
**Endpoint:** `GET /customer/suggested-items`  
**Authentication:** Required

---

### 9. Remove Account
**Endpoint:** `DELETE /customer/remove-account`  
**Authentication:** Required

---

### Address Management

#### Get Address List
**Endpoint:** `GET /customer/address/list`  
**Authentication:** Required

#### Add New Address
**Endpoint:** `POST /customer/address/add`  
**Authentication:** Required

**Request Body:**
```json
{
  "address": "123 Main St",
  "address_type": "home",
  "contact_person_name": "John Doe",
  "contact_person_number": "+1234567890",
  "latitude": 23.8103,
  "longitude": 90.4125
}
```

#### Update Address
**Endpoint:** `PUT /customer/address/update/{id}`  
**Authentication:** Required

#### Delete Address
**Endpoint:** `DELETE /customer/address/delete?id={address_id}`  
**Authentication:** Required

---

### Wishlist Management

#### Get Wishlist
**Endpoint:** `GET /customer/wish-list`  
**Authentication:** Required

#### Add to Wishlist
**Endpoint:** `POST /customer/wish-list/add`  
**Authentication:** Required

**Request Body:**
```json
{
  "item_id": 1
}
```

#### Remove from Wishlist
**Endpoint:** `DELETE /customer/wish-list/remove?item_id={item_id}`  
**Authentication:** Required

---

### Wallet Management

#### Get Wallet Transactions
**Endpoint:** `GET /customer/wallet/transactions`  
**Authentication:** Required

#### Add Fund to Wallet
**Endpoint:** `POST /customer/wallet/add-fund`  
**Authentication:** Required

**Request Body:**
```json
{
  "amount": 100,
  "payment_method": "stripe"
}
```

#### Get Wallet Bonuses
**Endpoint:** `GET /customer/wallet/bonuses`  
**Authentication:** Required

---

### Loyalty Points

#### Get Loyalty Transactions
**Endpoint:** `GET /customer/loyalty-point/transactions`  
**Authentication:** Required

#### Transfer Points
**Endpoint:** `POST /customer/loyalty-point/point-transfer`  
**Authentication:** Required

**Request Body:**
```json
{
  "points": 100
}
```

---

## Cart APIs

### 1. Get Cart List
**Endpoint:** `GET /customer/cart/list`  
**Authentication:** Required

---

### 2. Add to Cart
**Endpoint:** `POST /customer/cart/add`  
**Authentication:** Required

**Request Body:**
```json
{
  "item_id": 1,
  "quantity": 2,
  "variant": [],
  "addon_ids": [],
  "addon_quantities": []
}
```

---

### 3. Update Cart
**Endpoint:** `POST /customer/cart/update`  
**Authentication:** Required

**Request Body:**
```json
{
  "cart_id": 1,
  "quantity": 3
}
```

---

### 4. Remove Cart Item
**Endpoint:** `DELETE /customer/cart/remove-item?cart_id={cart_id}`  
**Authentication:** Required

---

### 5. Clear Cart
**Endpoint:** `DELETE /customer/cart/remove`  
**Authentication:** Required

---

## Order APIs

### 1. Place Order
**Endpoint:** `POST /customer/order/place`  
**Authentication:** Required

**Request Body:**
```json
{
  "store_id": 1,
  "delivery_address_id": 1,
  "payment_method": "cash_on_delivery",
  "delivery_instruction": "Please ring the doorbell"
}
```

---

### 2. Get Order List
**Endpoint:** `GET /customer/order/list`  
**Authentication:** Required

---

### 3. Get Running Orders
**Endpoint:** `GET /customer/order/running-orders`  
**Authentication:** Required

---

### 4. Get Order Details
**Endpoint:** `GET /customer/order/details?order_id={order_id}`  
**Authentication:** Required

---

### 5. Track Order
**Endpoint:** `PUT /customer/order/track?order_id={order_id}`  
**Authentication:** Not Required

---

### 6. Cancel Order
**Endpoint:** `PUT /customer/order/cancel`  
**Authentication:** Required

**Request Body:**
```json
{
  "order_id": 1,
  "reason": "Changed my mind"
}
```

---

### 7. Update Payment Method
**Endpoint:** `PUT /customer/order/payment-method`  
**Authentication:** Required

**Request Body:**
```json
{
  "order_id": 1,
  "payment_method": "stripe"
}
```

---

### 8. Get Cancellation Reasons
**Endpoint:** `GET /customer/order/cancellation-reasons`

---

### 9. Refund Request
**Endpoint:** `POST /customer/order/refund-request`  
**Authentication:** Required

**Request Body:**
```json
{
  "order_id": 1,
  "refund_reason_id": 1,
  "description": "Item damaged"
}
```

---

### 10. Get Refund Reasons
**Endpoint:** `GET /customer/order/refund-reasons`

---

### 11. Order Again
**Endpoint:** `GET /customer/visit-again`  
**Authentication:** Required

---

### 12. Get Parcel Instructions
**Endpoint:** `GET /customer/order/parcel-instructions`

---

### 13. Parcel Return
**Endpoint:** `POST /customer/order/parcel-return`  
**Authentication:** Required

---

## Store APIs

### 1. Get Stores
**Endpoint:** `GET /stores/get-stores/{filter_data}`  
**Parameters:**
- `{filter_data}`: `all`, `latest`, `popular`, `recent` etc.

---

### 2. Get Latest Stores
**Endpoint:** `GET /stores/latest`

---

### 3. Get Popular Stores
**Endpoint:** `GET /stores/popular`

---

### 4. Get Recommended Stores
**Endpoint:** `GET /stores/recommended`

---

### 5. Get Discounted Stores
**Endpoint:** `GET /stores/discounted`

---

### 6. Get Top Rated Stores
**Endpoint:** `GET /stores/top-rated`

---

### 7. Get Store Details
**Endpoint:** `GET /stores/details/{store_id}`

---

### 8. Get Popular Store Items
**Endpoint:** `GET /stores/popular-items/{store_id}`

---

### 9. Search Stores
**Endpoint:** `GET /stores/search?name={search_term}`

---

### 10. Get Combined Store Data
**Endpoint:** `GET /stores/get-data`  
**Description:** Get stores with items in one response

---

### 11. Get Top Offers Near Me
**Endpoint:** `GET /stores/top-offer-near-me?lat={latitude}&lng={longitude}`

---

### 12. Get Store Reviews
**Endpoint:** `GET /stores/reviews?store_id={store_id}`

---

## Item/Product APIs

### 1. Get Latest Items
**Endpoint:** `GET /items/latest`

---

### 2. Get New Arrival Items
**Endpoint:** `GET /items/new-arrival`

---

### 3. Get Popular Items
**Endpoint:** `GET /items/popular`

---

### 4. Get Most Reviewed Items
**Endpoint:** `GET /items/most-reviewed`

---

### 5. Get Discounted Items
**Endpoint:** `GET /items/discounted`

---

### 6. Get Set Menus
**Endpoint:** `GET /items/set-menu`

---

### 7. Search Items
**Endpoint:** `GET /items/search?name={search_term}`

---

### 8. Get Search Suggestions
**Endpoint:** `GET /items/search-suggestion?name={search_term}`

---

### 9. Get Item Details
**Endpoint:** `GET /items/details/{item_id}`

---

### 10. Get Related Items
**Endpoint:** `GET /items/related-items/{item_id}`

---

### 11. Get Related Store Items
**Endpoint:** `GET /items/related-store-items/{item_id}`

---

### 12. Get Item Reviews
**Endpoint:** `GET /items/reviews/{item_id}`

---

### 13. Get Item Rating
**Endpoint:** `GET /items/rating/{item_id}`

---

### 14. Submit Item Review
**Endpoint:** `POST /items/reviews/submit`  
**Authentication:** Required

**Request Body:**
```json
{
  "item_id": 1,
  "order_id": 1,
  "rating": 5,
  "comment": "Great product!"
}
```

---

### 15. Get Recommended Items
**Endpoint:** `GET /items/recommended`

---

### 16. Get Basic Items
**Endpoint:** `GET /items/basic`

---

### 17. Get Suggested Items
**Endpoint:** `GET /items/suggested?store_id={store_id}`

---

### 18. Get Generic Name List
**Endpoint:** `GET /item/get-generic-name-list`

---

### 19. Get Allergy Name List
**Endpoint:** `GET /item/get-allergy-name-list`

---

### 20. Get Nutrition Name List
**Endpoint:** `GET /item/get-nutrition-name-list`

---

## Category APIs

### 1. Get Categories
**Endpoint:** `GET /categories`

---

### 2. Get Child Categories
**Endpoint:** `GET /categories/childes/{category_id}`

---

### 3. Get Category Products
**Endpoint:** `GET /categories/items/{category_id}`

---

### 4. Get All Category Products
**Endpoint:** `GET /categories/items/{category_id}/all`

---

### 5. Get Category Stores
**Endpoint:** `GET /categories/stores/{category_id}`

---

### 6. Get Featured Category Products
**Endpoint:** `GET /categories/featured/items`

---

### 7. Get Popular Categories
**Endpoint:** `GET /categories/popular`

---

### 8. Get Category Products List
**Endpoint:** `GET /categories/items/list?category_id={category_id}`

---

## Campaign APIs

### 1. Get Basic Campaigns
**Endpoint:** `GET /campaigns/basic`

---

### 2. Get Campaign Details
**Endpoint:** `GET /campaigns/basic-campaign-details?id={campaign_id}`

---

### 3. Get Item Campaigns
**Endpoint:** `GET /campaigns/item`

---

## Flash Sales

### 1. Get Flash Sales
**Endpoint:** `GET /flash-sales`

---

### 2. Get Flash Sale Items
**Endpoint:** `GET /flash-sales/items?flash_sale_id={id}`

---

## Banner APIs

### 1. Get Banners
**Endpoint:** `GET /banners`

---

### 2. Get Store Banners
**Endpoint:** `GET /banners/{store_id}`

---

### 3. Get Other Banners
**Endpoint:** `GET /other-banners`

---

### 4. Get Video Content
**Endpoint:** `GET /other-banners/video-content`

---

### 5. Get Why Choose Section
**Endpoint:** `GET /other-banners/why-choose`

---

## Coupon APIs

### 1. Get All Coupons
**Endpoint:** `GET /coupon/list/all`

---

### 2. Get Customer Coupons
**Endpoint:** `GET /coupon/list`  
**Authentication:** Required

---

### 3. Apply Coupon
**Endpoint:** `GET /coupon/apply?coupon_code={code}`  
**Authentication:** Required

---

## Cashback APIs

### 1. Get Cashback List
**Endpoint:** `GET /cashback/list`  
**Authentication:** Required

---

### 2. Get Cashback
**Endpoint:** `GET /cashback/getCashback?order_id={order_id}`  
**Authentication:** Required

---

## Delivery Man APIs

### 1. Get Profile
**Endpoint:** `GET /delivery-man/profile`  
**Authentication:** Required

---

### 2. Get Notifications
**Endpoint:** `GET /delivery-man/notifications`  
**Authentication:** Required

---

### 3. Update Profile
**Endpoint:** `PUT /delivery-man/update-profile`  
**Authentication:** Required

---

### 4. Update Active Status
**Endpoint:** `POST /delivery-man/update-active-status`  
**Authentication:** Required

**Request Body:**
```json
{
  "is_active": 1
}
```

---

### 5. Get Current Orders
**Endpoint:** `GET /delivery-man/current-orders`  
**Authentication:** Required

---

### 6. Get Latest Orders
**Endpoint:** `GET /delivery-man/latest-orders`  
**Authentication:** Required

---

### 7. Record Location Data
**Endpoint:** `POST /delivery-man/record-location-data`  
**Authentication:** Required

**Request Body:**
```json
{
  "latitude": 23.8103,
  "longitude": 90.4125,
  "order_id": 1
}
```

---

### 8. Get All Orders
**Endpoint:** `GET /delivery-man/all-orders`  
**Authentication:** Required

---

### 9. Get Order History
**Endpoint:** `GET /delivery-man/order-delivery-history`  
**Authentication:** Required

---

### 10. Accept Order
**Endpoint:** `PUT /delivery-man/accept-order`  
**Authentication:** Required

**Request Body:**
```json
{
  "order_id": 1
}
```

---

### 11. Update Order Status
**Endpoint:** `PUT /delivery-man/update-order-status`  
**Authentication:** Required

**Request Body:**
```json
{
  "order_id": 1,
  "status": "delivered"
}
```

---

### 12. Update Payment Status
**Endpoint:** `PUT /delivery-man/update-payment-status`  
**Authentication:** Required

---

### 13. Get Order Details
**Endpoint:** `GET /delivery-man/order-details?order_id={order_id}`  
**Authentication:** Required

---

### 14. Send Order OTP
**Endpoint:** `PUT /delivery-man/send-order-otp`  
**Authentication:** Required

**Request Body:**
```json
{
  "order_id": 1
}
```

---

### 15. Update FCM Token
**Endpoint:** `PUT /delivery-man/update-fcm-token`  
**Authentication:** Required

---

### 16. Parcel Return
**Endpoint:** `POST /delivery-man/parcel-return`  
**Authentication:** Required

---

### 17. Get Earning Report
**Endpoint:** `GET /delivery-man/earning-report`  
**Authentication:** Required

---

### 18. Get Withdraw List
**Endpoint:** `GET /delivery-man/get-withdraw-list`  
**Authentication:** Required

---

### 19. Request Withdraw
**Endpoint:** `POST /delivery-man/request-withdraw`  
**Authentication:** Required

---

### 20. Get Withdraw Method List
**Endpoint:** `GET /delivery-man/get-withdraw-method-list`  
**Authentication:** Required

---

### Withdraw Method Management

#### Get Disbursement Withdrawal Methods
**Endpoint:** `GET /delivery-man/withdraw-method/list`  
**Authentication:** Required

#### Store Withdraw Method
**Endpoint:** `POST /delivery-man/withdraw-method/store`  
**Authentication:** Required

#### Make Default Method
**Endpoint:** `POST /delivery-man/withdraw-method/make-default`  
**Authentication:** Required

#### Delete Withdraw Method
**Endpoint:** `DELETE /delivery-man/withdraw-method/delete?method_id={id}`  
**Authentication:** Required

---

## Vendor APIs

### 1. Get Profile
**Endpoint:** `GET /vendor/profile`  
**Authentication:** Required

---

### 2. Get Notifications
**Endpoint:** `GET /vendor/notifications`  
**Authentication:** Required

---

### 3. Update Active Status
**Endpoint:** `POST /vendor/update-active-status`  
**Authentication:** Required

---

### 4. Get Earning Info
**Endpoint:** `GET /vendor/earning-info`  
**Authentication:** Required

---

### 5. Update Profile
**Endpoint:** `PUT /vendor/update-profile`  
**Authentication:** Required

---

### 6. Update Announcement
**Endpoint:** `PUT /vendor/update-announcment`  
**Authentication:** Required

---

### 7. Get Current Orders
**Endpoint:** `GET /vendor/current-orders`  
**Authentication:** Required

---

### 8. Get Completed Orders
**Endpoint:** `GET /vendor/completed-orders`  
**Authentication:** Required

---

### 9. Get Canceled Orders
**Endpoint:** `GET /vendor/canceled-orders`  
**Authentication:** Required

---

### 10. Get All Orders
**Endpoint:** `GET /vendor/all-orders`  
**Authentication:** Required

---

### 11. Update Order Status
**Endpoint:** `PUT /vendor/update-order-status`  
**Authentication:** Required

---

### 12. Update Order Amount
**Endpoint:** `PUT /vendor/update-order-amount`  
**Authentication:** Required

---

### 13. Get Order Details
**Endpoint:** `GET /vendor/order-details?order_id={order_id}`  
**Authentication:** Required

---

### 14. Update FCM Token
**Endpoint:** `PUT /vendor/update-fcm-token`  
**Authentication:** Required

---

### 15. Get Basic Campaigns
**Endpoint:** `GET /vendor/get-basic-campaigns`  
**Authentication:** Required

---

### 16. Leave Campaign
**Endpoint:** `PUT /vendor/campaign-leave?campaign_id={id}`  
**Authentication:** Required

---

### 17. Join Campaign
**Endpoint:** `PUT /vendor/campaign-join?campaign_id={id}`  
**Authentication:** Required

---

### 18. Get Items List
**Endpoint:** `GET /vendor/get-items-list`  
**Authentication:** Required

---

### 19. Update Bank Info
**Endpoint:** `PUT /vendor/update-bank-info`  
**Authentication:** Required

---

### 20. Request Withdraw
**Endpoint:** `POST /vendor/request-withdraw`  
**Authentication:** Required

---

### Item Management

#### Store Item
**Endpoint:** `POST /vendor/item/store`  
**Authentication:** Required

#### Update Item
**Endpoint:** `PUT /vendor/item/update`  
**Authentication:** Required

#### Delete Item
**Endpoint:** `DELETE /vendor/item/delete?item_id={id}`  
**Authentication:** Required

#### Update Item Status
**Endpoint:** `GET /vendor/item/status?item_id={id}&status={status}`  
**Authentication:** Required

#### Get Item Details
**Endpoint:** `GET /vendor/item/details/{item_id}`  
**Authentication:** Required

#### Search Items
**Endpoint:** `POST /vendor/item/search`  
**Authentication:** Required

#### Get Item Reviews
**Endpoint:** `GET /vendor/item/reviews`  
**Authentication:** Required

---

### Banner Management

#### Get Banners
**Endpoint:** `GET /vendor/banner`  
**Authentication:** Required

#### Store Banner
**Endpoint:** `POST /vendor/banner/store`  
**Authentication:** Required

#### Update Banner
**Endpoint:** `PUT /vendor/banner/update`  
**Authentication:** Required

#### Update Banner Status
**Endpoint:** `GET /vendor/banner/status?banner_id={id}&status={status}`  
**Authentication:** Required

---

### Category Management

#### Get Categories
**Endpoint:** `GET /vendor/categories`  
**Authentication:** Required

#### Get Child Categories
**Endpoint:** `GET /vendor/categories/childes/{category_id}`  
**Authentication:** Required

---

## Admin APIs

Note: Admin APIs are accessed through the web admin panel and require admin authentication.

### Key Admin Endpoints Include:

1. **Dashboard:** `/admin/dashboard`
2. **Store Management:** `/admin/store/...`
3. **Order Management:** `/admin/order/...`
4. **Customer Management:** `/admin/customer/...`
5. **Delivery Man Management:** `/admin/delivery-man/...`
6. **Item Management:** `/admin/item/...`
7. **Category Management:** `/admin/category/...`
8. **Campaign Management:** `/admin/campaign/...`
9. **Report Management:** `/admin/report/...`
10. **Business Settings:** `/admin/business-settings/...`

For complete admin routes, refer to the `routes/admin.php` file in the project.

---

## Helper Functions and Important Notes

### Authentication
Most endpoints require authentication. Include the authorization header:
```
Authorization: Bearer {your_token}
```

### Common Response Format
```json
{
  "response_code": 200,
  "message": "Success message",
  "data": {...}
}
```

### Error Response Format
```json
{
  "errors": [
    {
      "code": "error_code",
      "message": "Error message"
    }
  ]
}
```

### Key Functions in the Codebase
- **Helpers:** `app/helpers.php`, `app/CentralLogics/helpers.php`
- **Customer Logic:** `app/CentralLogics/customer.php`
- **Order Logic:** `app/CentralLogics/order.php`
- **Store Logic:** `app/CentralLogics/store.php`
- **Item Logic:** `app/CentralLogics/item.php`
- **Campaign Logic:** `app/CentralLogics/campaign.php`
- **Coupon Logic:** `app/CentralLogics/coupon.php`
- **Banner Logic:** `app/CentralLogics/banner.php`

---

## Testing in Postman

1. **Import Collection:** Import the `POSTMAN_API_ENDPOINTS.json` file into Postman
2. **Set Variables:** Update the `base_url` variable with your actual domain
3. **Get Token:** First login to get an authentication token
4. **Set Token:** Use the token in subsequent requests
5. **Test Endpoints:** Test each endpoint as needed

---

## Additional Resources

- **Laravel Passport:** Used for API authentication
- **Firebase:** Used for push notifications
- **Payment Gateways:** Stripe, Razorpay, PayPal, etc.
- **WebSockets:** For real-time location tracking
- **File Manager:** For handling file uploads

---

## Need Help?

For detailed implementation of any endpoint, refer to:
- Controllers in `app/Http/Controllers/Api/V1/` directory
- Middleware in `app/Http/Middleware/` directory
- Models in `app/Models/` directory
