# API Endpoints Quick Reference

## Base URL: `http://your-domain.com/api/v1`

## Authentication Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/auth/sign-up` | POST | No | Register new customer |
| `/auth/login` | POST | No | Customer login |
| `/auth/verify-phone` | POST | No | Verify phone/email with OTP |
| `/auth/forgot-password` | POST | No | Request password reset |
| `/auth/verify-token` | POST | No | Verify reset token |
| `/auth/reset-password` | PUT | Yes | Reset password |
| `/auth/delivery-man/login` | POST | No | Delivery man login |
| `/auth/vendor/login` | POST | No | Vendor login |
| `/auth/social-login` | POST | No | Social media login |

## Configuration Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/config` | GET | No | Get system configuration |
| `/zone/list` | GET | No | Get zones list |
| `/zone/check` | GET | No | Check zones by location |
| `/config/get-zone-id` | GET | No | Get zone ID by location |
| `/config/get-PaymentMethods` | GET | No | Get payment methods |
| `/module` | GET | No | Get module list |
| `/terms-and-conditions` | GET | No | Get terms |
| `/privacy-policy` | GET | No | Get privacy policy |
| `/refund-policy` | GET | No | Get refund policy |
| `/shipping-policy` | GET | No | Get shipping policy |
| `/cancelation` | GET | No | Get cancellation policy |
| `/offline_payment_method_list` | GET | No | Get offline payment methods |

## Customer Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/customer/get-data` | POST | Yes | Get customer data |
| `/customer/notifications` | GET | Yes | Get notifications |
| `/customer/info` | GET | Yes | Get customer info |
| `/customer/update-profile` | POST | Yes | Update profile |
| `/customer/update-zone` | GET | Yes | Update zone |
| `/customer/update-interest` | POST | Yes | Update interests |
| `/customer/suggested-items` | GET | Yes | Get suggested items |
| `/customer/remove-account` | DELETE | Yes | Remove account |

### Address Management
| `/customer/address/list` | GET | Yes | Get address list |
| `/customer/address/add` | POST | Yes | Add address |
| `/customer/address/update/{id}` | PUT | Yes | Update address |
| `/customer/address/delete` | DELETE | Yes | Delete address |

### Wishlist
| `/customer/wish-list` | GET | Yes | Get wishlist |
| `/customer/wish-list/add` | POST | Yes | Add to wishlist |
| `/customer/wish-list/remove` | DELETE | Yes | Remove from wishlist |

### Wallet
| `/customer/wallet/transactions` | GET | Yes | Wallet transactions |
| `/customer/wallet/add-fund` | POST | Yes | Add fund to wallet |
| `/customer/wallet/bonuses` | GET | Yes | Get wallet bonuses |

### Loyalty Points
| `/customer/loyalty-point/transactions` | GET | Yes | Loyalty transactions |
| `/customer/loyalty-point/point-transfer` | POST | Yes | Transfer points |

## Cart Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/customer/cart/list` | GET | Yes | Get cart list |
| `/customer/cart/add` | POST | Yes | Add to cart |
| `/customer/cart/update` | POST | Yes | Update cart |
| `/customer/cart/remove-item` | DELETE | Yes | Remove item |
| `/customer/cart/remove` | DELETE | Yes | Clear cart |

## Order Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/customer/order/place` | POST | Yes | Place order |
| `/customer/order/list` | GET | Yes | Get order list |
| `/customer/order/running-orders` | GET | Yes | Get running orders |
| `/customer/order/details` | GET | Yes | Get order details |
| `/customer/order/track` | PUT | No | Track order |
| `/customer/order/cancel` | PUT | Yes | Cancel order |
| `/customer/order/payment-method` | PUT | Yes | Update payment method |
| `/customer/order/cancellation-reasons` | GET | No | Get cancel reasons |
| `/customer/order/refund-request` | POST | Yes | Request refund |
| `/customer/order/refund-reasons` | GET | No | Get refund reasons |
| `/customer/order/parcel-instructions` | GET | No | Get parcel instructions |
| `/customer/visit-again` | GET | Yes | Order again |
| `/customer/order/parcel-return` | POST | Yes | Return parcel |

## Store Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/stores/get-stores/{filter}` | GET | No | Get stores |
| `/stores/latest` | GET | No | Get latest stores |
| `/stores/popular` | GET | No | Get popular stores |
| `/stores/recommended` | GET | No | Get recommended stores |
| `/stores/discounted` | GET | No | Get discounted stores |
| `/stores/top-rated` | GET | No | Get top rated stores |
| `/stores/details/{id}` | GET | No | Get store details |
| `/stores/popular-items/{id}` | GET | No | Get popular items |
| `/stores/search` | GET | No | Search stores |
| `/stores/get-data` | GET | No | Get combined data |
| `/stores/top-offer-near-me` | GET | No | Get offers near me |
| `/stores/reviews` | GET | No | Get store reviews |
| `/stores/details/{id}` | GET | No | Get store details |

## Item/Product Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/items/latest` | GET | No | Get latest items |
| `/items/new-arrival` | GET | No | Get new arrivals |
| `/items/popular` | GET | No | Get popular items |
| `/items/most-reviewed` | GET | No | Get most reviewed |
| `/items/discounted` | GET | No | Get discounted items |
| `/items/set-menu` | GET | No | Get set menus |
| `/items/search` | GET | No | Search items |
| `/items/search-suggestion` | GET | No | Get search suggestions |
| `/items/details/{id}` | GET | No | Get item details |
| `/items/related-items/{id}` | GET | No | Get related items |
| `/items/related-store-items/{id}` | GET | No | Get related store items |
| `/items/reviews/{id}` | GET | No | Get item reviews |
| `/items/rating/{id}` | GET | No | Get item rating |
| `/items/reviews/submit` | POST | Yes | Submit review |
| `/items/recommended` | GET | No | Get recommended items |
| `/items/basic` | GET | No | Get basic items |
| `/items/suggested` | GET | No | Get suggested items |
| `/item/get-generic-name-list` | GET | No | Get generic names |
| `/item/get-allergy-name-list` | GET | No | Get allergy names |
| `/item/get-nutrition-name-list` | GET | No | Get nutrition names |

## Category Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/categories` | GET | No | Get categories |
| `/categories/childes/{id}` | GET | No | Get child categories |
| `/categories/items/{id}` | GET | No | Get category items |
| `/categories/items/{id}/all` | GET | No | Get all category items |
| `/categories/stores/{id}` | GET | No | Get category stores |
| `/categories/featured/items` | GET | No | Get featured items |
| `/categories/popular` | GET | No | Get popular categories |
| `/categories/items/list` | GET | No | Get items list |

## Campaign Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/campaigns/basic` | GET | No | Get basic campaigns |
| `/campaigns/basic-campaign-details` | GET | No | Get campaign details |
| `/campaigns/item` | GET | No | Get item campaigns |

## Flash Sale Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/flash-sales` | GET | No | Get flash sales |
| `/flash-sales/items` | GET | No | Get flash sale items |

## Banner Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/banners` | GET | No | Get banners |
| `/banners/{store_id}` | GET | No | Get store banners |
| `/other-banners` | GET | No | Get other banners |
| `/other-banners/video-content` | GET | No | Get video content |
| `/other-banners/why-choose` | GET | No | Get why choose |

## Coupon Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/coupon/list/all` | GET | No | Get all coupons |
| `/coupon/list` | GET | Yes | Get customer coupons |
| `/coupon/apply` | GET | Yes | Apply coupon |

## Cashback Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/cashback/list` | GET | Yes | Get cashback list |
| `/cashback/getCashback` | GET | Yes | Get cashback |

## Delivery Man Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/delivery-man/profile` | GET | Yes | Get profile |
| `/delivery-man/notifications` | GET | Yes | Get notifications |
| `/delivery-man/update-profile` | PUT | Yes | Update profile |
| `/delivery-man/update-active-status` | POST | Yes | Update active status |
| `/delivery-man/current-orders` | GET | Yes | Get current orders |
| `/delivery-man/latest-orders` | GET | Yes | Get latest orders |
| `/delivery-man/record-location-data` | POST | Yes | Record location |
| `/delivery-man/all-orders` | GET | Yes | Get all orders |
| `/delivery-man/order-delivery-history` | GET | Yes | Get order history |
| `/delivery-man/accept-order` | PUT | Yes | Accept order |
| `/delivery-man/update-order-status` | PUT | Yes | Update order status |
| `/delivery-man/update-payment-status` | PUT | Yes | Update payment status |
| `/delivery-man/order-details` | GET | Yes | Get order details |
| `/delivery-man/order` | GET | Yes | Get order |
| `/delivery-man/send-order-otp` | PUT | Yes | Send order OTP |
| `/delivery-man/update-fcm-token` | PUT | Yes | Update FCM token |
| `/delivery-man/parcel-return` | POST | Yes | Parcel return |
| `/delivery-man/earning-report` | GET | Yes | Get earning report |
| `/delivery-man/get-withdraw-list` | GET | Yes | Get withdraw list |
| `/delivery-man/request-withdraw` | POST | Yes | Request withdraw |
| `/delivery-man/get-withdraw-method-list` | GET | Yes | Get withdraw methods |
| `/delivery-man/last-location` | GET | No | Get last location |

### Delivery Man Withdraw Methods
| `/delivery-man/withdraw-method/list` | GET | Yes | Get methods |
| `/delivery-man/withdraw-method/store` | POST | Yes | Store method |
| `/delivery-man/withdraw-method/make-default` | POST | Yes | Make default |
| `/delivery-man/withdraw-method/delete` | DELETE | Yes | Delete method |

### Delivery Man Reviews
| `/delivery-man/reviews/{dm_id}` | GET | No | Get reviews |
| `/delivery-man/reviews/rating/{dm_id}` | GET | No | Get rating |
| `/delivery-man/reviews/submit` | POST | Yes | Submit review |

## Vendor Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/vendor/profile` | GET | Yes | Get profile |
| `/vendor/notifications` | GET | Yes | Get notifications |
| `/vendor/update-active-status` | POST | Yes | Update active status |
| `/vendor/earning-info` | GET | Yes | Get earning info |
| `/vendor/update-profile` | PUT | Yes | Update profile |
| `/vendor/update-announcment` | PUT | Yes | Update announcement |
| `/vendor/current-orders` | GET | Yes | Get current orders |
| `/vendor/completed-orders` | GET | Yes | Get completed orders |
| `/vendor/canceled-orders` | GET | Yes | Get canceled orders |
| `/vendor/all-orders` | GET | Yes | Get all orders |
| `/vendor/update-order-status` | PUT | Yes | Update order status |
| `/vendor/update-order-amount` | PUT | Yes | Update order amount |
| `/vendor/order-details` | GET | Yes | Get order details |
| `/vendor/order` | GET | Yes | Get order |
| `/vendor/update-fcm-token` | PUT | Yes | Update FCM token |
| `/vendor/get-basic-campaigns` | GET | Yes | Get campaigns |
| `/vendor/campaign-leave` | PUT | Yes | Leave campaign |
| `/vendor/campaign-join` | PUT | Yes | Join campaign |
| `/vendor/get-items-list` | GET | Yes | Get items list |
| `/vendor/update-bank-info` | PUT | Yes | Update bank info |
| `/vendor/request-withdraw` | POST | Yes | Request withdraw |
| `/vendor/get-withdraw-list` | GET | Yes | Get withdraw list |
| `/vendor/remove-account` | DELETE | Yes | Remove account |

### Vendor Item Management
| `/vendor/item/store` | POST | Yes | Store item |
| `/vendor/item/update` | PUT | Yes | Update item |
| `/vendor/item/delete` | DELETE | Yes | Delete item |
| `/vendor/item/status` | GET | Yes | Update status |
| `/vendor/item/details/{id}` | GET | Yes | Get details |
| `/vendor/item/search` | POST | Yes | Search items |
| `/vendor/item/reviews` | GET | Yes | Get reviews |
| `/vendor/item/stock-update` | PUT | Yes | Update stock |

### Vendor Banner Management
| `/vendor/banner` | GET | Yes | Get banners |
| `/vendor/banner/store` | POST | Yes | Store banner |
| `/vendor/banner/update` | PUT | Yes | Update banner |
| `/vendor/banner/status` | GET | Yes | Update status |

### Vendor Category Management
| `/vendor/categories` | GET | Yes | Get categories |
| `/vendor/categories/childes/{id}` | GET | Yes | Get child categories |

### Vendor Coupon Management
| `/vendor/coupon/list` | GET | Yes | Get coupon list |
| `/vendor/coupon/view` | GET | Yes | View coupon |
| `/vendor/coupon/store` | POST | Yes | Store coupon |
| `/vendor/coupon/update` | POST | Yes | Update coupon |
| `/vendor/coupon/status` | POST | Yes | Update status |
| `/vendor/coupon/delete` | POST | Yes | Delete coupon |
| `/vendor/coupon/search` | POST | Yes | Search coupons |

### Vendor Addon Management
| `/vendor/addon` | GET | Yes | Get addons |
| `/vendor/addon/store` | POST | Yes | Store addon |
| `/vendor/addon/update` | PUT | Yes | Update addon |
| `/vendor/addon/status` | GET | Yes | Update status |
| `/vendor/addon/delete` | DELETE | Yes | Delete addon |

### Vendor POS Management
| `/vendor/pos/orders` | GET | Yes | Get POS orders |
| `/vendor/pos/place-order` | POST | Yes | Place POS order |
| `/vendor/pos/customers` | GET | Yes | Get customers |

## Testimonial Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/testimonial` | GET | No | Get testimonials |

## Parcel Category Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/parcel-category` | GET | No | Get parcel categories |

## Advertisement Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/advertisement/list` | GET | No | Get advertisements |

## Common Condition Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/common-condition` | GET | No | Get common conditions |
| `/common-condition/list` | GET | No | Get conditions list |
| `/common-condition/items/{id}` | GET | No | Get condition items |

## Brand Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/brand` | GET | No | Get brands |
| `/brand/items/{id}` | GET | No | Get brand items |

## Vehicle Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/vehicle/extra_charge` | GET | No | Get extra charges |
| `/get-vehicles` | GET | No | Get vehicles |
| `/get-parcel-cancellation-reasons` | GET | No | Get cancellation reasons |

## Message/Chat Endpoints

### Customer Chat
| `/customer/message/list` | GET | Yes | Get conversations |
| `/customer/message/search-list` | GET | Yes | Search conversations |
| `/customer/message/details` | GET | Yes | Get messages |
| `/customer/message/send` | POST | Yes | Send message |

### Vendor Chat
| `/vendor/message/list` | GET | Yes | Get conversations |
| `/vendor/message/search-list` | GET | Yes | Search conversations |
| `/vendor/message/details` | GET | Yes | Get messages |
| `/vendor/message/send` | POST | Yes | Send message |

### Delivery Man Chat
| `/delivery-man/message/list` | GET | Yes | Get conversations |
| `/delivery-man/message/search-list` | GET | Yes | Search conversations |
| `/delivery-man/message/details` | GET | Yes | Get messages |
| `/delivery-man/message/send` | POST | Yes | Send message |

## Newsletter Endpoint

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/newsletter/subscribe` | POST | No | Subscribe to newsletter |

## Landing Page Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/landing-page` | GET | No | Get landing page |
| `/react-landing-page` | GET | No | Get React landing page |
| `/flutter-landing-page` | GET | No | Get Flutter landing page |

## Search Endpoint

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/get-combined-data` | GET | No | Get combined search data |

## Map & Location APIs

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/config/place-api-autocomplete` | GET | No | Place autocomplete |
| `/config/distance-api` | GET | No | Distance calculation |
| `/config/direction-api` | GET | No | Get directions |
| `/config/place-api-details` | GET | No | Place details |
| `/config/geocode-api` | GET | No | Geocode API |

## Subscription Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/vendor/package-view` | GET | No | View packages |
| `/vendor/business_plan` | POST | No | Select business plan |
| `/vendor/subscription/payment/api` | POST | No | Payment API |
| `/vendor/package-renew` | POST | No | Renew package |
| `/vendor/cancel-subscription` | POST | Yes | Cancel subscription |
| `/vendor/check-product-limits` | GET | Yes | Check product limits |
| `/vendor/subscription-transaction` | GET | Yes | Get transactions |

## External Configuration Endpoints

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/configurations` | GET | No | Get configuration |
| `/configurations/get-external` | GET | No | Get external config |
| `/configurations/store` | POST | No | Store configuration |

## Merchandise & ROI Analytics

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/config/get-analytic-scripts` | GET | No | Get analytics scripts |

## Automated Messages

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/customer/order/automated-message` | GET | No | Get automated messages |

## Most Tips

| Endpoint | Method | Auth Required | Description |
|----------|--------|---------------|-------------|
| `/most-tips` | GET | No | Get most tips |

## WebSocket Endpoint

| Endpoint | Protocol | Description |
|----------|----------|-------------|
| `/delivery-man/live-location` | WebSocket | Real-time location tracking |

---

## Request Headers

### Standard Headers
```
Content-Type: application/json
Accept: application/json
```

### Authenticated Requests
```
Authorization: Bearer {token}
```

### Localization
```
localization: en
X-localization: en
```

---

## Response Codes

| Code | Description |
|------|-------------|
| 200 | Success |
| 201 | Created |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 422 | Validation Error |
| 500 | Server Error |

---

## Testing Tips

1. **Use Postman Collection:** Import the provided JSON file
2. **Set Environment Variables:** Configure base_url and tokens
3. **Sequential Testing:** Login first to get token
4. **Token Management:** Store token for authenticated requests
5. **Test Data:** Use provided example data structures

---

## Important Notes

- Replace `your-domain.com` with actual domain
- Use HTTPS in production
- All timestamps are in server timezone
- Images returned as URLs
- Pagination available for list endpoints
- Filter parameters vary by endpoint
