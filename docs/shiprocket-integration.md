# Shiprocket Integration - Complete Documentation

## Overview
Shiprocket integration for Scents N Smile e-commerce platform. This document covers all features needed for complete shipping management.

## Shiprocket API Details
- **Base URL**: `https://apiv2.shiprocket.in/v1/external`
- **Authentication**: Bearer Token (Email + Password based)
- **Token Validity**: 10 days

---

## Phase 1: Admin Settings & Configuration

### 1.1 Settings Tab in Admin Panel
Add "Shiprocket" tab in Admin > Settings with following fields:

| Field | Type | Description |
|-------|------|-------------|
| shiprocket_email | text | Shiprocket account email |
| shiprocket_password | password | Shiprocket account password |
| shiprocket_enabled | toggle | Enable/Disable Shiprocket |
| shiprocket_pickup_location | text | Default pickup location name |
| shiprocket_channel_id | text | Sales channel ID (optional) |

### 1.2 Database Settings
Store in `settings` table:
- `shiprocket_email`
- `shiprocket_password`
- `shiprocket_token`
- `shiprocket_token_expires_at`
- `shiprocket_enabled`
- `shiprocket_pickup_location`
- `shiprocket_channel_id`

---

## Phase 2: Database Schema Updates

### 2.1 Orders Table - Add Shiprocket Fields
```sql
ALTER TABLE orders ADD COLUMN shiprocket_order_id VARCHAR(50) NULL;
ALTER TABLE orders ADD COLUMN shiprocket_shipment_id VARCHAR(50) NULL;
ALTER TABLE orders ADD COLUMN shiprocket_awb_code VARCHAR(50) NULL;
ALTER TABLE orders ADD COLUMN shiprocket_courier_id INT NULL;
ALTER TABLE orders ADD COLUMN shiprocket_courier_name VARCHAR(100) NULL;
ALTER TABLE orders ADD COLUMN shiprocket_label_url TEXT NULL;
ALTER TABLE orders ADD COLUMN shiprocket_manifest_url TEXT NULL;
ALTER TABLE orders ADD COLUMN shiprocket_pickup_scheduled_date DATE NULL;
ALTER TABLE orders ADD COLUMN shiprocket_status VARCHAR(50) NULL;
ALTER TABLE orders ADD COLUMN shiprocket_tracking_url TEXT NULL;
```

### 2.2 Products Table - Add Shipping Fields
```sql
ALTER TABLE products ADD COLUMN weight DECIMAL(10,2) DEFAULT 0.5 COMMENT 'Weight in KG';
ALTER TABLE products ADD COLUMN length DECIMAL(10,2) DEFAULT 10 COMMENT 'Length in CM';
ALTER TABLE products ADD COLUMN breadth DECIMAL(10,2) DEFAULT 10 COMMENT 'Breadth in CM';
ALTER TABLE products ADD COLUMN height DECIMAL(10,2) DEFAULT 10 COMMENT 'Height in CM';
ALTER TABLE products ADD COLUMN hsn_code VARCHAR(20) NULL;
```

---

## Phase 3: ShiprocketService Class

### 3.1 Core Methods

```php
class ShiprocketService
{
    // Authentication
    public function authenticate(): ?string
    public function getToken(): ?string
    public function isTokenValid(): bool
    
    // Orders
    public function createOrder(Order $order): array
    public function cancelOrder(string $orderId): array
    public function getOrderDetails(string $orderId): array
    
    // Shipments
    public function generateAWB(int $shipmentId, int $courierId): array
    public function getAvailableCouriers(int $pickupPostcode, int $deliveryPostcode, float $weight): array
    public function schedulePickup(int $shipmentId): array
    
    // Tracking
    public function trackShipment(string $awbCode): array
    public function trackByOrderId(string $orderId): array
    
    // Labels & Manifests
    public function generateLabel(int $shipmentId): array
    public function generateManifest(array $shipmentIds): array
    public function generateInvoice(array $orderIds): array
    
    // Pickup Locations
    public function getPickupLocations(): array
    public function addPickupLocation(array $data): array
    
    // NDR (Non-Delivery Reports)
    public function getNDRShipments(): array
    public function updateNDRAction(int $awbCode, string $action, array $data): array
    
    // Returns
    public function createReturnOrder(Order $order): array
    
    // Serviceability
    public function checkServiceability(int $pickupPostcode, int $deliveryPostcode, float $weight, string $paymentMode = 'prepaid'): array
}
```

---

## Phase 4: Admin Panel Features

### 4.1 Order Detail Page - Shiprocket Section
Add new card in order detail page:

**Shiprocket Shipping**
- Ship with Shiprocket (button) - if not shipped
- Select Courier dropdown
- Generate AWB button
- Schedule Pickup button
- Print Label button
- Print Manifest button
- Print Invoice button
- Track Shipment button
- Cancel Shipment button

**Tracking Info Display**
- AWB Number
- Courier Name
- Current Status
- Tracking URL (link)
- Estimated Delivery Date

### 4.2 Orders List Page - Bulk Actions
- Bulk Ship Selected Orders
- Bulk Generate Labels
- Bulk Generate Manifest
- Bulk Schedule Pickup

### 4.3 New Admin Pages

#### Shiprocket Dashboard (`/admin/shiprocket`)
- Today's Shipments
- Pending Pickups
- In Transit
- Delivered
- RTO (Return to Origin)
- NDR Pending

#### Pickup Locations (`/admin/shiprocket/pickup-locations`)
- List all pickup locations
- Add new pickup location
- Edit/Delete locations

#### NDR Management (`/admin/shiprocket/ndr`)
- List NDR shipments
- Take action (Reattempt, RTO, etc.)

---

## Phase 5: Website Features

### 5.1 Order Tracking Page (`/track-order`)
- Enter Order Number or AWB
- Show tracking timeline
- Current status
- Estimated delivery

### 5.2 User Account - Order Detail
- Show tracking info
- Track button linking to tracking page
- Courier name and AWB

### 5.3 Checkout Page
- Check serviceability by pincode
- Show estimated delivery date
- Show available couriers (optional)

---

## Phase 6: Webhooks & Automation

### 6.1 Shiprocket Webhooks
Create webhook endpoint: `POST /api/shiprocket/webhook`

Handle events:
- `shipment_status_update` - Update order status
- `pickup_scheduled` - Update pickup date
- `pickup_completed` - Mark as picked up
- `in_transit` - Update tracking
- `delivered` - Mark order delivered
- `rto_initiated` - Handle returns
- `ndr_action_required` - Notify admin

### 6.2 Auto-sync Cron Job
- Sync tracking status every 2 hours
- Update order statuses
- Send customer notifications

---

## Phase 7: Notifications

### 7.1 Email Notifications
- Order Shipped (with tracking link)
- Out for Delivery
- Delivered
- Delivery Failed (NDR)
- Return Initiated

### 7.2 SMS Notifications (Optional)
- Shipped notification
- Out for delivery
- Delivered

---

## API Endpoints Reference

### Authentication
```
POST /auth/login
Body: { email, password }
Response: { token }
```

### Create Order
```
POST /orders/create/adhoc
Body: {
    order_id, order_date, pickup_location,
    billing_customer_name, billing_address, billing_city, billing_pincode, billing_state, billing_country, billing_email, billing_phone,
    shipping_is_billing, shipping_customer_name, shipping_address, shipping_city, shipping_pincode, shipping_state, shipping_country, shipping_email, shipping_phone,
    order_items: [{ name, sku, units, selling_price, discount, tax, hsn }],
    payment_method, sub_total, length, breadth, height, weight
}
```

### Generate AWB
```
POST /courier/assign/awb
Body: { shipment_id, courier_id }
```

### Track Shipment
```
GET /courier/track/awb/{awb_code}
```

### Get Couriers
```
GET /courier/serviceability
Params: pickup_postcode, delivery_postcode, weight, cod (0/1)
```

---

## Implementation Order

1. **Phase 1**: Admin Settings Tab (Shiprocket credentials)
2. **Phase 2**: Database migrations (orders + products)
3. **Phase 3**: ShiprocketService class
4. **Phase 4.1**: Order detail page - Ship button & tracking
5. **Phase 4.2**: Bulk actions in orders list
6. **Phase 5.1**: Order tracking page (website)
7. **Phase 5.2**: User account tracking
8. **Phase 6**: Webhooks
9. **Phase 7**: Notifications

---

## Files to Create/Modify

### New Files
- `app/Services/ShiprocketService.php`
- `app/Http/Controllers/Admin/ShiprocketController.php`
- `app/Http/Controllers/TrackingController.php`
- `resources/views/admin/orders/shiprocket-card.blade.php`
- `resources/views/admin/shiprocket/dashboard.blade.php`
- `resources/views/admin/shiprocket/pickup-locations.blade.php`
- `resources/views/admin/shiprocket/ndr.blade.php`
- `resources/views/tracking.blade.php`
- `database/migrations/xxxx_add_shiprocket_fields_to_orders.php`
- `database/migrations/xxxx_add_shipping_fields_to_products.php`

### Modify Files
- `app/Models/Order.php` - Add shiprocket fields
- `app/Models/Product.php` - Add shipping dimensions
- `resources/views/admin/settings/index.blade.php` - Add Shiprocket tab
- `app/Http/Controllers/Admin/SettingsController.php` - Handle Shiprocket settings
- `resources/views/admin/orders/show.blade.php` - Add Shiprocket card
- `resources/views/admin/orders/index.blade.php` - Add bulk actions
- `resources/views/website/auth/order-detail.blade.php` - Add tracking
- `routes/web.php` - Add routes
- `routes/api.php` - Add webhook route

---

## Status Mapping

| Shiprocket Status | Order Status |
|-------------------|--------------|
| NEW | processing |
| AWB_ASSIGNED | processing |
| PICKUP_SCHEDULED | processing |
| PICKED_UP | shipped |
| IN_TRANSIT | shipped |
| OUT_FOR_DELIVERY | shipped |
| DELIVERED | delivered |
| CANCELLED | cancelled |
| RTO_INITIATED | cancelled |
| RTO_DELIVERED | cancelled |

---

## Error Handling

- Token expired → Auto re-authenticate
- API rate limit → Queue requests
- Invalid pincode → Show error to user
- Courier unavailable → Show alternatives
- Order creation failed → Log and notify admin

---

## Testing Checklist

- [ ] Shiprocket credentials save/load
- [ ] Token generation and refresh
- [ ] Create order on Shiprocket
- [ ] Get available couriers
- [ ] Generate AWB
- [ ] Schedule pickup
- [ ] Generate label PDF
- [ ] Track shipment
- [ ] Webhook status updates
- [ ] Cancel shipment
- [ ] Bulk operations
- [ ] Customer tracking page
- [ ] Email notifications
