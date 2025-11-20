# Fix Google API Key for Distance Calculation

## Problem
The PHP backend's Google API key (`map_api_key_server`) is being blocked when calling Google Routes API.

Error: `PERMISSION_DENIED: API_KEY_SERVICE_BLOCKED`

## Root Cause
The Google Cloud API key stored in `business_settings` table has restrictions that are blocking server-side requests.

## Solution Steps

### 1. Check Current API Key Configuration

```sql
-- In MySQL database
SELECT * FROM business_settings WHERE `key` = 'map_api_key_server';
```

### 2. Google Cloud Console Configuration

Go to: https://console.cloud.google.com/apis/credentials

**For the API key used in `map_api_key_server`:**

1. **Enable Required APIs:**
   - Routes API (New)
   - Distance Matrix API
   - Directions API
   - Places API (New)
   - Geocoding API

2. **Set API Key Restrictions:**

   **Option A: IP Address Restriction (Recommended)**
   - Application restrictions → IP addresses
   - Add your PHP backend server's public IP address
   - If using Docker/localhost for dev: Add `127.0.0.1` and your server's public IP

   **Option B: HTTP Referrer (Not recommended for server-side)**
   - Only use for frontend apps
   - Server-side cURL calls don't send referrers

   **Option C: None (Development only)**
   - Unrestricted (use only for testing)
   - Switch to IP restriction for production

3. **API Restrictions:**
   - Restrict key → Select APIs:
     - Routes API ✓
     - Distance Matrix API ✓
     - Directions API ✓
     - Places API ✓
     - Geocoding API ✓

### 3. Update API Key in Database

If you have a new/different key:

```sql
UPDATE business_settings 
SET value = 'YOUR_NEW_GOOGLE_API_KEY_HERE'
WHERE `key` = 'map_api_key_server';
```

### 4. Clear Laravel Cache

```bash
cd /home/ubuntu/Devs/Php\ Mangwale\ Backend
php artisan cache:clear
php artisan config:clear
```

### 5. Test the Distance API Directly

```bash
# Test from PHP backend (replace with actual coords)
curl -X GET "https://testing.mangwale.com/api/v1/config/distance-api?origin_lat=23.7937&origin_lng=90.4066&destination_lat=23.8103&destination_lng=90.4125"
```

Expected response:
```json
{
  "distanceMeters": 2547,
  "duration": "8m 32s"
}
```

## Verification

After fixing:
1. Distance API call should return `distanceMeters` value
2. NestJS gateway will automatically pick it up and convert to km
3. Orders will show correct distance instead of 0

## Notes

- **Key Type:** Use a server-side API key (IP restricted)
- **Billing:** Ensure Google Cloud billing is enabled
- **Quotas:** Check you haven't hit API quotas
- **Migration:** Google deprecated old Distance Matrix API v1; PHP is using new Routes API v2 ✓

## Current PHP Backend API Endpoints

All these use `map_api_key_server`:
- `/api/v1/config/distance-api` - Calculate distance (Routes API v2)
- `/api/v1/config/direction-api` - Get directions (Routes API v2)
- `/api/v1/config/place-api-autocomplete` - Place autocomplete (Places API New)
- `/api/v1/config/place-api-details` - Place details (Places API New)
- `/api/v1/config/geocode-api` - Reverse geocoding (Geocoding API)

All must be enabled for the API key.
