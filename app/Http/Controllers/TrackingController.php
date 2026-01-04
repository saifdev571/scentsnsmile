<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\ShiprocketService;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    protected ShiprocketService $shiprocket;

    public function __construct(ShiprocketService $shiprocket)
    {
        $this->shiprocket = $shiprocket;
    }

    /**
     * Show tracking page
     */
    public function index(Request $request)
    {
        $order = null;
        $orderNumber = $request->get('order');

        if ($orderNumber) {
            // Try to find by order number
            $order = Order::where('order_number', $orderNumber)
                ->with('items.product', 'items.variant')
                ->first();

            // If not found, try by AWB code
            if (!$order) {
                $order = Order::where('shiprocket_awb_code', $orderNumber)
                    ->with('items.product', 'items.variant')
                    ->first();
            }
        }

        return view('tracking', compact('order'));
    }

    /**
     * API endpoint to track by AWB
     */
    public function trackByAwb(string $awbCode)
    {
        if (!$this->shiprocket->isEnabled()) {
            return response()->json([
                'success' => false,
                'message' => 'Tracking service not available',
            ]);
        }

        $result = $this->shiprocket->trackShipment($awbCode);

        if ($result['success']) {
            return response()->json([
                'success' => true,
                'tracking' => $result['tracking_data'] ?? [],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $result['message'] ?? 'Unable to fetch tracking info',
        ]);
    }

    /**
     * API endpoint to track by order number
     */
    public function trackByOrder(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found',
            ]);
        }

        if (!$order->shiprocket_awb_code) {
            return response()->json([
                'success' => false,
                'message' => 'Shipment not yet dispatched',
                'order_status' => $order->status,
            ]);
        }

        return $this->trackByAwb($order->shiprocket_awb_code);
    }
}
