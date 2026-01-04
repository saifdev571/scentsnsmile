<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;

class ShiprocketController extends Controller
{
    protected ShiprocketService $shiprocket;

    public function __construct(ShiprocketService $shiprocket)
    {
        $this->shiprocket = $shiprocket;
    }

    /**
     * Create order on Shiprocket
     */
    public function createOrder(Request $request, Order $order)
    {
        if (!$this->shiprocket->isEnabled()) {
            return response()->json([
                'success' => false,
                'message' => 'Shiprocket is not enabled. Please configure it in Settings.',
            ], 400);
        }

        if ($order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order already exists on Shiprocket.',
            ], 400);
        }

        // Validate order has required address fields
        $missingFields = [];
        if (empty($order->first_name)) $missingFields[] = 'First Name';
        if (empty($order->address)) $missingFields[] = 'Address';
        if (empty($order->city)) $missingFields[] = 'City';
        if (empty($order->state)) $missingFields[] = 'State';
        if (empty($order->zipcode)) $missingFields[] = 'PIN Code';
        if (empty($order->phone)) $missingFields[] = 'Phone';
        if (empty($order->email)) $missingFields[] = 'Email';

        if (!empty($missingFields)) {
            return response()->json([
                'success' => false,
                'message' => 'Missing required fields: ' . implode(', ', $missingFields),
            ], 400);
        }

        $result = $this->shiprocket->createOrder($order);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'message' => 'Order created on Shiprocket successfully!',
                'data' => [
                    'shiprocket_order_id' => $order->fresh()->shiprocket_order_id,
                    'shiprocket_shipment_id' => $order->fresh()->shiprocket_shipment_id,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to create order on Shiprocket.',
            'errors' => $result['errors'] ?? [],
        ], 400);
    }

    /**
     * Get available couriers for order
     */
    public function getCouriers(Request $request, Order $order)
    {
        if (!$order->shiprocket_shipment_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please create order on Shiprocket first.',
            ], 400);
        }

        $pickupPincode = (int) \App\Models\Setting::get('shiprocket_pickup_pincode', 110001);
        $deliveryPincode = (int) $order->zipcode;
        $weight = $order->total_weight;
        $cod = $order->payment_method === 'cod';

        $result = $this->shiprocket->getAvailableCouriers($pickupPincode, $deliveryPincode, $weight, $cod);

        if ($result['success'] && isset($result['data']['available_courier_companies'])) {
            return response()->json([
                'success' => true,
                'couriers' => $result['data']['available_courier_companies'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'No couriers available for this pincode.',
        ], 400);
    }

    /**
     * Generate AWB for shipment
     */
    public function generateAWB(Request $request, Order $order)
    {
        $request->validate([
            'courier_id' => 'required|integer',
        ]);

        if (!$order->shiprocket_shipment_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please create order on Shiprocket first.',
            ], 400);
        }

        if ($order->shiprocket_awb_code) {
            return response()->json([
                'success' => false,
                'message' => 'AWB already generated for this order.',
            ], 400);
        }

        $result = $this->shiprocket->generateAWB(
            (int) $order->shiprocket_shipment_id,
            (int) $request->courier_id
        );

        if ($result['success']) {
            $order->refresh();
            return response()->json([
                'success' => true,
                'message' => 'AWB generated successfully!',
                'data' => [
                    'awb_code' => $order->shiprocket_awb_code,
                    'courier_name' => $order->shiprocket_courier_name,
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to generate AWB.',
        ], 400);
    }

    /**
     * Schedule pickup
     */
    public function schedulePickup(Request $request, Order $order)
    {
        if (!$order->shiprocket_shipment_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please create order on Shiprocket first.',
            ], 400);
        }

        if (!$order->shiprocket_awb_code) {
            return response()->json([
                'success' => false,
                'message' => 'Please generate AWB first.',
            ], 400);
        }

        $result = $this->shiprocket->schedulePickup((int) $order->shiprocket_shipment_id);

        if ($result['success']) {
            $order->refresh();
            return response()->json([
                'success' => true,
                'message' => 'Pickup scheduled successfully!',
                'data' => [
                    'pickup_date' => $order->shiprocket_pickup_scheduled_date?->format('d M, Y'),
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to schedule pickup.',
        ], 400);
    }

    /**
     * Generate shipping label
     */
    public function generateLabel(Request $request, Order $order)
    {
        if (!$order->shiprocket_shipment_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please create order on Shiprocket first.',
            ], 400);
        }

        $result = $this->shiprocket->generateLabel((int) $order->shiprocket_shipment_id);

        if ($result['success'] && isset($result['label_url'])) {
            $order->refresh();
            return response()->json([
                'success' => true,
                'message' => 'Label generated successfully!',
                'label_url' => $result['label_url'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to generate label.',
        ], 400);
    }

    /**
     * Generate manifest
     */
    public function generateManifest(Request $request, Order $order)
    {
        if (!$order->shiprocket_shipment_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please create order on Shiprocket first.',
            ], 400);
        }

        $result = $this->shiprocket->generateManifest([(int) $order->shiprocket_shipment_id]);

        if ($result['success'] && isset($result['manifest_url'])) {
            $order->refresh();
            return response()->json([
                'success' => true,
                'message' => 'Manifest generated successfully!',
                'manifest_url' => $result['manifest_url'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to generate manifest.',
        ], 400);
    }

    /**
     * Generate invoice
     */
    public function generateInvoice(Request $request, Order $order)
    {
        if (!$order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Please create order on Shiprocket first.',
            ], 400);
        }

        $result = $this->shiprocket->generateInvoice([(int) $order->shiprocket_order_id]);

        if ($result['success'] && isset($result['invoice_url'])) {
            $order->refresh();
            return response()->json([
                'success' => true,
                'message' => 'Invoice generated successfully!',
                'invoice_url' => $result['invoice_url'],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to generate invoice.',
        ], 400);
    }

    /**
     * Track shipment
     */
    public function trackShipment(Request $request, Order $order)
    {
        if (!$order->shiprocket_awb_code) {
            return response()->json([
                'success' => false,
                'message' => 'No AWB code found for this order.',
            ], 400);
        }

        $result = $this->shiprocket->trackShipment($order->shiprocket_awb_code);

        if ($result['success']) {
            // Sync status
            $this->shiprocket->syncTrackingStatus($order);
            $order->refresh();

            return response()->json([
                'success' => true,
                'tracking' => $result['tracking_data'] ?? [],
                'order_status' => $order->shiprocket_status,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to get tracking info.',
        ], 400);
    }

    /**
     * Cancel shipment
     */
    public function cancelShipment(Request $request, Order $order)
    {
        if (!$order->shiprocket_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found on Shiprocket.',
            ], 400);
        }

        $result = $this->shiprocket->cancelOrder($order->shiprocket_order_id);

        if ($result['success']) {
            $order->update([
                'shiprocket_status' => 'CANCELLED',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Shipment cancelled successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to cancel shipment.',
        ], 400);
    }

    /**
     * Test Shiprocket connection
     */
    public function testConnection()
    {
        $result = $this->shiprocket->testConnection();
        return response()->json($result);
    }

    /**
     * Get pickup locations
     */
    public function getPickupLocations()
    {
        $result = $this->shiprocket->getPickupLocations();

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'locations' => $result['data']['shipping_address'] ?? [],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Failed to get pickup locations.',
        ], 400);
    }
}
