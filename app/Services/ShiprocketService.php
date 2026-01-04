<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ShiprocketService
{
    protected string $baseUrl = 'https://apiv2.shiprocket.in/v1/external';
    protected ?string $token = null;

    public function __construct()
    {
        $this->token = $this->getToken();
    }

    /**
     * Check if Shiprocket is enabled
     */
    public function isEnabled(): bool
    {
        return filter_var(Setting::get('shiprocket_enabled', false), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * Get valid token (auto-refresh if expired)
     */
    public function getToken(): ?string
    {
        $token = Setting::get('shiprocket_token');
        $expiresAt = Setting::get('shiprocket_token_expires_at');

        // Check if token is valid
        if ($token && $expiresAt && Carbon::parse($expiresAt)->isFuture()) {
            return $token;
        }

        // Token expired or not exists, authenticate
        return $this->authenticate();
    }

    /**
     * Authenticate with Shiprocket
     */
    public function authenticate(): ?string
    {
        $email = Setting::get('shiprocket_email');
        $password = Setting::get('shiprocket_password');

        if (!$email || !$password) {
            Log::error('Shiprocket: Email or password not configured');
            return null;
        }

        try {
            $response = Http::post("{$this->baseUrl}/auth/login", [
                'email' => $email,
                'password' => $password,
            ]);

            if ($response->successful() && isset($response['token'])) {
                $token = $response['token'];
                
                // Save token (valid for 10 days)
                Setting::set('shiprocket_token', $token);
                Setting::set('shiprocket_token_expires_at', now()->addDays(9)->toDateTimeString());
                
                $this->token = $token;
                return $token;
            }

            Log::error('Shiprocket Auth Failed', ['response' => $response->json()]);
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket Auth Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Make authenticated API request
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        if (!$this->token) {
            return ['success' => false, 'message' => 'Not authenticated'];
        }

        try {
            $http = Http::withToken($this->token);

            $response = match(strtoupper($method)) {
                'GET' => $http->get("{$this->baseUrl}{$endpoint}", $data),
                'POST' => $http->post("{$this->baseUrl}{$endpoint}", $data),
                'PUT' => $http->put("{$this->baseUrl}{$endpoint}", $data),
                'DELETE' => $http->delete("{$this->baseUrl}{$endpoint}"),
                default => throw new \Exception("Invalid HTTP method: {$method}"),
            };

            $result = $response->json();

            if ($response->successful()) {
                return array_merge(['success' => true], $result ?? []);
            }

            Log::error("Shiprocket API Error: {$endpoint}", ['response' => $result]);
            
            // Extract meaningful error message
            $errorMessage = $result['message'] ?? 'API request failed';
            
            // Check for specific error patterns
            if (isset($result['errors']) && is_array($result['errors'])) {
                $errorDetails = [];
                foreach ($result['errors'] as $field => $messages) {
                    if (is_array($messages)) {
                        $errorDetails[] = implode(', ', $messages);
                    } else {
                        $errorDetails[] = $messages;
                    }
                }
                if (!empty($errorDetails)) {
                    $errorMessage = implode('. ', $errorDetails);
                }
            }
            
            // Check for validation errors in different format
            if (isset($result['payload']['errors']) && is_array($result['payload']['errors'])) {
                $errorMessage = implode('. ', $result['payload']['errors']);
            }
            
            return [
                'success' => false,
                'message' => $errorMessage,
                'errors' => $result['errors'] ?? [],
            ];

        } catch (\Exception $e) {
            Log::error("Shiprocket Exception: {$endpoint}", ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Create order on Shiprocket
     */
    public function createOrder(Order $order): array
    {
        // Validate required fields
        if (empty($order->first_name) || empty($order->address) || empty($order->city) || 
            empty($order->state) || empty($order->zipcode) || empty($order->phone)) {
            
            $missing = [];
            if (empty($order->first_name)) $missing[] = 'First Name';
            if (empty($order->address)) $missing[] = 'Address';
            if (empty($order->city)) $missing[] = 'City';
            if (empty($order->state)) $missing[] = 'State';
            if (empty($order->zipcode)) $missing[] = 'PIN Code';
            if (empty($order->phone)) $missing[] = 'Phone';
            
            return [
                'success' => false,
                'message' => 'Missing required fields: ' . implode(', ', $missing)
            ];
        }

        // Prepare order items
        $orderItems = [];
        foreach ($order->items as $item) {
            $orderItems[] = [
                'name' => $item->product_name ?? 'Product',
                'sku' => $item->product ? ($item->product->sku ?? 'SKU-' . $item->product_id) : 'SKU-' . $item->id,
                'units' => (int) $item->quantity,
                'selling_price' => (float) $item->price,
                'discount' => 0,
                'tax' => 0,
                'hsn' => $item->product ? ($item->product->hsn_code ?? '') : '',
            ];
        }

        if (empty($orderItems)) {
            return [
                'success' => false,
                'message' => 'Order has no items'
            ];
        }

        // Get package dimensions
        $dimensions = $order->package_dimensions;

        // Clean phone number (remove +91 or any prefix)
        $phone = preg_replace('/[^0-9]/', '', $order->phone);
        if (strlen($phone) > 10) {
            $phone = substr($phone, -10);
        }

        // Format state name properly for Shiprocket
        $state = $this->formatStateName($order->state);

        $data = [
            'order_id' => $order->order_number,
            'order_date' => $order->created_at->format('Y-m-d H:i'),
            // Billing Address
            'billing_customer_name' => $order->first_name,
            'billing_last_name' => $order->last_name ?? '',
            'billing_address' => $order->address,
            'billing_address_2' => $order->address_line_2 ?? '',
            'billing_city' => ucwords(strtolower($order->city)),
            'billing_pincode' => (string) $order->zipcode,
            'billing_state' => $state,
            'billing_country' => $order->country ?? 'India',
            'billing_email' => $order->email ?? 'noemail@example.com',
            'billing_phone' => $phone,
            // Shipping Address (same as billing)
            'shipping_is_billing' => true,
            'shipping_customer_name' => $order->first_name,
            'shipping_last_name' => $order->last_name ?? '',
            'shipping_address' => $order->address,
            'shipping_address_2' => $order->address_line_2 ?? '',
            'shipping_city' => ucwords(strtolower($order->city)),
            'shipping_pincode' => (string) $order->zipcode,
            'shipping_state' => $state,
            'shipping_country' => $order->country ?? 'India',
            'shipping_email' => $order->email ?? 'noemail@example.com',
            'shipping_phone' => $phone,
            // Order details
            'order_items' => $orderItems,
            'payment_method' => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
            'sub_total' => (float) $order->subtotal,
            'length' => (float) $dimensions['length'],
            'breadth' => (float) $dimensions['breadth'],
            'height' => (float) $dimensions['height'],
            'weight' => (float) $order->total_weight,
        ];

        Log::info('Shiprocket Create Order Request', ['data' => $data]);

        $response = $this->request('POST', '/orders/create/adhoc', $data);

        Log::info('Shiprocket Create Order Response', ['response' => $response]);

        if ($response['success'] && isset($response['order_id'])) {
            // Update order with Shiprocket details
            $order->update([
                'shiprocket_order_id' => $response['order_id'],
                'shiprocket_shipment_id' => $response['shipment_id'] ?? null,
                'shiprocket_status' => 'NEW',
            ]);
        }

        return $response;
    }

    /**
     * Cancel order on Shiprocket
     */
    public function cancelOrder(string $orderId): array
    {
        return $this->request('POST', '/orders/cancel', [
            'ids' => [$orderId],
        ]);
    }

    /**
     * Get available couriers for shipment
     */
    public function getAvailableCouriers(int $pickupPostcode, int $deliveryPostcode, float $weight, bool $cod = false): array
    {
        return $this->request('GET', '/courier/serviceability/', [
            'pickup_postcode' => $pickupPostcode,
            'delivery_postcode' => $deliveryPostcode,
            'weight' => $weight,
            'cod' => $cod ? 1 : 0,
        ]);
    }

    /**
     * Generate AWB for shipment
     */
    public function generateAWB(int $shipmentId, int $courierId): array
    {
        $response = $this->request('POST', '/courier/assign/awb', [
            'shipment_id' => $shipmentId,
            'courier_id' => $courierId,
        ]);

        if ($response['success'] && isset($response['response']['data']['awb_code'])) {
            // Find order by shipment ID and update
            $order = Order::where('shiprocket_shipment_id', $shipmentId)->first();
            if ($order) {
                $order->update([
                    'shiprocket_awb_code' => $response['response']['data']['awb_code'],
                    'shiprocket_courier_id' => $courierId,
                    'shiprocket_courier_name' => $response['response']['data']['courier_name'] ?? null,
                    'shiprocket_status' => 'AWB_ASSIGNED',
                ]);
            }
        }

        return $response;
    }

    /**
     * Schedule pickup for shipment
     */
    public function schedulePickup(int $shipmentId): array
    {
        $response = $this->request('POST', '/courier/generate/pickup', [
            'shipment_id' => [$shipmentId],
        ]);

        if ($response['success']) {
            $order = Order::where('shiprocket_shipment_id', $shipmentId)->first();
            if ($order) {
                $order->update([
                    'shiprocket_status' => 'PICKUP_SCHEDULED',
                    'shiprocket_pickup_scheduled_date' => $response['response']['pickup_scheduled_date'] ?? now()->addDay(),
                ]);
            }
        }

        return $response;
    }

    /**
     * Track shipment by AWB code
     */
    public function trackShipment(string $awbCode): array
    {
        return $this->request('GET', "/courier/track/awb/{$awbCode}");
    }

    /**
     * Track shipment by order ID
     */
    public function trackByOrderId(string $orderId): array
    {
        return $this->request('GET', "/courier/track", [
            'order_id' => $orderId,
        ]);
    }

    /**
     * Generate shipping label
     */
    public function generateLabel(int $shipmentId): array
    {
        $response = $this->request('POST', '/courier/generate/label', [
            'shipment_id' => [$shipmentId],
        ]);

        if ($response['success'] && isset($response['label_url'])) {
            $order = Order::where('shiprocket_shipment_id', $shipmentId)->first();
            if ($order) {
                $order->update([
                    'shiprocket_label_url' => $response['label_url'],
                ]);
            }
        }

        return $response;
    }

    /**
     * Generate manifest for shipments
     */
    public function generateManifest(array $shipmentIds): array
    {
        $response = $this->request('POST', '/manifests/generate', [
            'shipment_id' => $shipmentIds,
        ]);

        if ($response['success'] && isset($response['manifest_url'])) {
            // Update all orders with manifest URL
            Order::whereIn('shiprocket_shipment_id', $shipmentIds)->update([
                'shiprocket_manifest_url' => $response['manifest_url'],
            ]);
        }

        return $response;
    }

    /**
     * Generate invoice for orders
     */
    public function generateInvoice(array $orderIds): array
    {
        $response = $this->request('POST', '/orders/print/invoice', [
            'ids' => $orderIds,
        ]);

        if ($response['success'] && isset($response['invoice_url'])) {
            Order::whereIn('shiprocket_order_id', $orderIds)->update([
                'shiprocket_invoice_url' => $response['invoice_url'],
            ]);
        }

        return $response;
    }

    /**
     * Check serviceability for pincode
     */
    public function checkServiceability(int $pickupPostcode, int $deliveryPostcode, float $weight = 0.5, string $paymentMode = 'prepaid'): array
    {
        return $this->request('GET', '/courier/serviceability/', [
            'pickup_postcode' => $pickupPostcode,
            'delivery_postcode' => $deliveryPostcode,
            'weight' => $weight,
            'cod' => $paymentMode === 'cod' ? 1 : 0,
        ]);
    }

    /**
     * Get all pickup locations
     */
    public function getPickupLocations(): array
    {
        return $this->request('GET', '/settings/company/pickup');
    }

    /**
     * Add new pickup location
     */
    public function addPickupLocation(array $data): array
    {
        return $this->request('POST', '/settings/company/addpickup', $data);
    }

    /**
     * Get order details from Shiprocket
     */
    public function getOrderDetails(string $orderId): array
    {
        return $this->request('GET', "/orders/show/{$orderId}");
    }

    /**
     * Get NDR (Non-Delivery Report) shipments
     */
    public function getNDRShipments(): array
    {
        return $this->request('GET', '/ndr/all');
    }

    /**
     * Update NDR action
     */
    public function updateNDRAction(string $awbCode, string $action, array $data = []): array
    {
        return $this->request('POST', '/ndr/update', array_merge([
            'awb' => $awbCode,
            'action' => $action, // re-attempt, return, fake-attempt
        ], $data));
    }

    /**
     * Create return order
     */
    public function createReturnOrder(Order $order): array
    {
        $pickupLocation = Setting::get('shiprocket_pickup_location', 'Primary');

        $orderItems = [];
        foreach ($order->items as $item) {
            $orderItems[] = [
                'name' => $item->product_name,
                'sku' => $item->product ? $item->product->sku : 'SKU-' . $item->id,
                'units' => $item->quantity,
                'selling_price' => $item->price,
                'qc_enable' => false,
            ];
        }

        $dimensions = $order->package_dimensions;

        return $this->request('POST', '/orders/create/return', [
            'order_id' => $order->order_number . '-RET',
            'order_date' => now()->format('Y-m-d'),
            'pickup_customer_name' => $order->first_name . ' ' . $order->last_name,
            'pickup_address' => $order->address,
            'pickup_address_2' => $order->address_line_2 ?? '',
            'pickup_city' => $order->city,
            'pickup_state' => $order->state,
            'pickup_country' => $order->country ?? 'India',
            'pickup_pincode' => $order->zipcode,
            'pickup_email' => $order->email,
            'pickup_phone' => $order->phone,
            'shipping_customer_name' => Setting::get('site_name', 'Store'),
            'shipping_address' => Setting::get('site_address', ''),
            'shipping_city' => Setting::get('shiprocket_return_city', ''),
            'shipping_state' => Setting::get('shiprocket_return_state', ''),
            'shipping_country' => 'India',
            'shipping_pincode' => Setting::get('shiprocket_return_pincode', ''),
            'shipping_phone' => Setting::get('site_phone', ''),
            'order_items' => $orderItems,
            'payment_method' => 'Prepaid',
            'sub_total' => $order->subtotal,
            'length' => $dimensions['length'],
            'breadth' => $dimensions['breadth'],
            'height' => $dimensions['height'],
            'weight' => $order->total_weight,
        ]);
    }

    /**
     * Sync tracking status for an order
     */
    public function syncTrackingStatus(Order $order): array
    {
        if (!$order->shiprocket_awb_code) {
            return ['success' => false, 'message' => 'No AWB code found'];
        }

        $response = $this->trackShipment($order->shiprocket_awb_code);

        if ($response['success'] && isset($response['tracking_data'])) {
            $trackingData = $response['tracking_data'];
            $currentStatus = $trackingData['shipment_status'] ?? null;

            if ($currentStatus) {
                $order->update([
                    'shiprocket_status' => $currentStatus,
                    'shiprocket_tracking_url' => $trackingData['track_url'] ?? null,
                    'shiprocket_expected_delivery_date' => $trackingData['etd'] ?? null,
                ]);

                // Update order status based on Shiprocket status
                $this->updateOrderStatusFromShiprocket($order, $currentStatus);
            }
        }

        return $response;
    }

    /**
     * Update order status based on Shiprocket status
     */
    protected function updateOrderStatusFromShiprocket(Order $order, string $shiprocketStatus): void
    {
        $statusMap = [
            'PICKED_UP' => 'shipped',
            'IN_TRANSIT' => 'shipped',
            'OUT_FOR_DELIVERY' => 'shipped',
            'DELIVERED' => 'delivered',
            'CANCELLED' => 'cancelled',
            'RTO_INITIATED' => 'cancelled',
            'RTO_DELIVERED' => 'cancelled',
        ];

        if (isset($statusMap[$shiprocketStatus])) {
            $newStatus = $statusMap[$shiprocketStatus];
            
            if ($order->status !== $newStatus) {
                $order->update(['status' => $newStatus]);

                if ($newStatus === 'shipped' && !$order->shipped_at) {
                    $order->update(['shipped_at' => now()]);
                } elseif ($newStatus === 'delivered' && !$order->delivered_at) {
                    $order->update(['delivered_at' => now()]);
                }
            }
        }
    }

    /**
     * Test connection with Shiprocket
     */
    public function testConnection(): array
    {
        $token = $this->authenticate();
        
        if ($token) {
            return [
                'success' => true,
                'message' => 'Connection successful! Token generated.',
            ];
        }

        return [
            'success' => false,
            'message' => 'Connection failed. Please check your credentials.',
        ];
    }

    /**
     * Format state name for Shiprocket API
     */
    protected function formatStateName(string $state): string
    {
        // Map of common variations to proper state names
        $stateMap = [
            'westbengal' => 'West Bengal',
            'west bengal' => 'West Bengal',
            'wb' => 'West Bengal',
            'maharashtra' => 'Maharashtra',
            'mh' => 'Maharashtra',
            'delhi' => 'Delhi',
            'newdelhi' => 'Delhi',
            'new delhi' => 'Delhi',
            'dl' => 'Delhi',
            'karnataka' => 'Karnataka',
            'ka' => 'Karnataka',
            'tamilnadu' => 'Tamil Nadu',
            'tamil nadu' => 'Tamil Nadu',
            'tn' => 'Tamil Nadu',
            'telangana' => 'Telangana',
            'ts' => 'Telangana',
            'andhrapradesh' => 'Andhra Pradesh',
            'andhra pradesh' => 'Andhra Pradesh',
            'ap' => 'Andhra Pradesh',
            'kerala' => 'Kerala',
            'kl' => 'Kerala',
            'gujarat' => 'Gujarat',
            'gj' => 'Gujarat',
            'rajasthan' => 'Rajasthan',
            'rj' => 'Rajasthan',
            'madhyapradesh' => 'Madhya Pradesh',
            'madhya pradesh' => 'Madhya Pradesh',
            'mp' => 'Madhya Pradesh',
            'uttarpradesh' => 'Uttar Pradesh',
            'uttar pradesh' => 'Uttar Pradesh',
            'up' => 'Uttar Pradesh',
            'bihar' => 'Bihar',
            'br' => 'Bihar',
            'punjab' => 'Punjab',
            'pb' => 'Punjab',
            'haryana' => 'Haryana',
            'hr' => 'Haryana',
            'jharkhand' => 'Jharkhand',
            'jh' => 'Jharkhand',
            'odisha' => 'Odisha',
            'orissa' => 'Odisha',
            'or' => 'Odisha',
            'chhattisgarh' => 'Chhattisgarh',
            'chattisgarh' => 'Chhattisgarh',
            'cg' => 'Chhattisgarh',
            'assam' => 'Assam',
            'as' => 'Assam',
            'uttarakhand' => 'Uttarakhand',
            'uk' => 'Uttarakhand',
            'himachalpradesh' => 'Himachal Pradesh',
            'himachal pradesh' => 'Himachal Pradesh',
            'hp' => 'Himachal Pradesh',
            'goa' => 'Goa',
            'ga' => 'Goa',
            'tripura' => 'Tripura',
            'tr' => 'Tripura',
            'meghalaya' => 'Meghalaya',
            'ml' => 'Meghalaya',
            'manipur' => 'Manipur',
            'mn' => 'Manipur',
            'nagaland' => 'Nagaland',
            'nl' => 'Nagaland',
            'arunachalpradesh' => 'Arunachal Pradesh',
            'arunachal pradesh' => 'Arunachal Pradesh',
            'ar' => 'Arunachal Pradesh',
            'mizoram' => 'Mizoram',
            'mz' => 'Mizoram',
            'sikkim' => 'Sikkim',
            'sk' => 'Sikkim',
            'jammukashmir' => 'Jammu and Kashmir',
            'jammu kashmir' => 'Jammu and Kashmir',
            'jammu and kashmir' => 'Jammu and Kashmir',
            'jk' => 'Jammu and Kashmir',
            'ladakh' => 'Ladakh',
            'la' => 'Ladakh',
            'chandigarh' => 'Chandigarh',
            'ch' => 'Chandigarh',
            'puducherry' => 'Puducherry',
            'pondicherry' => 'Puducherry',
            'py' => 'Puducherry',
            'andamannicobar' => 'Andaman and Nicobar Islands',
            'andaman nicobar' => 'Andaman and Nicobar Islands',
            'andaman and nicobar' => 'Andaman and Nicobar Islands',
            'an' => 'Andaman and Nicobar Islands',
            'dadranagarhaveli' => 'Dadra and Nagar Haveli and Daman and Diu',
            'damandiu' => 'Dadra and Nagar Haveli and Daman and Diu',
            'lakshadweep' => 'Lakshadweep',
            'ld' => 'Lakshadweep',
        ];

        $normalized = strtolower(trim(preg_replace('/\s+/', '', $state)));
        
        if (isset($stateMap[$normalized])) {
            return $stateMap[$normalized];
        }

        // Also check with spaces
        $normalizedWithSpaces = strtolower(trim($state));
        if (isset($stateMap[$normalizedWithSpaces])) {
            return $stateMap[$normalizedWithSpaces];
        }

        // If not found in map, return title case version
        return ucwords(strtolower($state));
    }
}
