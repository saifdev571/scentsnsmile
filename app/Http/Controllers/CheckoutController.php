<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promotion;
use App\Models\Setting;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Calculate cart totals with active promotion
     */
    protected function calculateTotals($cartItems)
    {
        $subtotal = $cartItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $itemCount = $cartItems->sum('quantity');
        
        // Get active promotion
        $promotion = Promotion::active()->orderBy('sort_order')->first();
        
        // Get shipping settings from database
        $defaultShipping = (float) Setting::get('shipping_charge', 99);
        $freeShippingThreshold = (float) Setting::get('free_shipping_threshold', 999);
        
        // Calculate shipping
        $shipping = $defaultShipping;
        
        // Check promotion free shipping first
        if ($promotion && $promotion->hasFreeShipping($itemCount)) {
            $shipping = 0;
        } 
        // Check free shipping threshold
        elseif ($freeShippingThreshold > 0 && $subtotal >= $freeShippingThreshold) {
            $shipping = 0;
        }
        
        // Calculate discount
        $discount = 0;
        if ($promotion) {
            $discount = $promotion->calculateDiscount($subtotal, $itemCount);
        }
        
        // Calculate total
        $total = $subtotal - $discount + $shipping;

        return [
            'subtotal' => $subtotal,
            'itemCount' => $itemCount,
            'shipping' => $shipping,
            'discount' => $discount,
            'total' => $total,
            'promotion' => $promotion,
            'freeShippingThreshold' => $freeShippingThreshold,
        ];
    }

    /**
     * Show checkout page - Login required
     */
    public function index()
    {
        // Check if user is logged in
        if (!Auth::check()) {
            session()->put('checkout_redirect', route('checkout.index'));
            return redirect()->route('user.login')
                ->with('info', 'Please login to continue with checkout');
        }

        $cartItems = $this->cartService->getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', 'Your cart is empty');
        }

        // Calculate totals with promotion
        $totals = $this->calculateTotals($cartItems);
        $subtotal = $totals['subtotal'];
        $itemCount = $totals['itemCount'];
        $shipping = $totals['shipping'];
        $discount = $totals['discount'];
        $total = $totals['total'];
        $activePromotion = $totals['promotion'];

        // Get user addresses for quick selection
        $user = Auth::user();
        $addresses = $user->addresses()->orderBy('is_default', 'desc')->latest()->get();
        
        // Get default address for pre-filling
        $defaultAddress = $addresses->where('is_default', true)->first() ?? $addresses->first();

        // Get Razorpay settings
        $razorpayEnabled = Setting::get('razorpay_enabled', false);
        $razorpayKeyId = Setting::get('razorpay_key_id', '');

        return view('checkout', compact(
            'cartItems', 'subtotal', 'shipping', 'discount', 'total', 
            'itemCount', 'user', 'addresses', 'defaultAddress', 'razorpayEnabled', 'razorpayKeyId', 'activePromotion'
        ));
    }

    /**
     * Create Razorpay Order
     */
    public function createRazorpayOrder(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to continue'
            ], 401);
        }

        // Validate request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'order_notes' => 'nullable|string|max:1000',
        ]);

        $cartItems = $this->cartService->getCartItems();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Calculate totals with promotion
        $totals = $this->calculateTotals($cartItems);
        $subtotal = $totals['subtotal'];
        $itemCount = $totals['itemCount'];
        $shipping = $totals['shipping'];
        $discount = $totals['discount'];
        $total = $totals['total'];

        // Get Razorpay credentials
        $keyId = Setting::get('razorpay_key_id', '');
        $keySecret = Setting::get('razorpay_key_secret', '');

        if (empty($keyId) || empty($keySecret)) {
            return response()->json([
                'success' => false,
                'message' => 'Payment gateway not configured'
            ], 500);
        }

        try {
            // Create Razorpay Order using cURL
            $orderData = [
                'amount' => (int)($total * 100), // Amount in paise
                'currency' => 'INR',
                'receipt' => 'SNS-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'notes' => [
                    'customer_name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'customer_email' => $validated['email'],
                    'customer_phone' => $validated['phone'],
                ]
            ];

            $ch = curl_init('https://api.razorpay.com/v1/orders');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($orderData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_USERPWD, $keyId . ':' . $keySecret);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $razorpayOrder = json_decode($response, true);

            if ($httpCode !== 200 || !isset($razorpayOrder['id'])) {
                Log::error('Razorpay Order Creation Failed', [
                    'response' => $razorpayOrder,
                    'http_code' => $httpCode
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create payment order'
                ], 500);
            }

            // Store order details in session for later use
            session()->put('checkout_data', [
                'razorpay_order_id' => $razorpayOrder['id'],
                'form_data' => $validated,
                'totals' => [
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'discount' => $discount,
                    'total' => $total,
                ]
            ]);

            return response()->json([
                'success' => true,
                'razorpay_order_id' => $razorpayOrder['id'],
                'razorpay_key_id' => $keyId,
                'amount' => (int)($total * 100),
                'currency' => 'INR',
                'name' => Setting::get('site_name', 'Scents N Smile'),
                'description' => 'Order Payment',
                'prefill' => [
                    'name' => $validated['first_name'] . ' ' . $validated['last_name'],
                    'email' => $validated['email'],
                    'contact' => '+91' . $validated['phone'],
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay Order Creation Error', [
                'error' => $e->getMessage()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Payment initialization failed'
            ], 500);
        }
    }

    /**
     * Verify Razorpay Payment
     */
    public function verifyRazorpayPayment(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to continue'
            ], 401);
        }

        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $checkoutData = session()->get('checkout_data');

        if (!$checkoutData || $checkoutData['razorpay_order_id'] !== $request->razorpay_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid payment session'
            ], 400);
        }

        // Verify signature
        $keySecret = Setting::get('razorpay_key_secret', '');
        $generatedSignature = hash_hmac(
            'sha256',
            $request->razorpay_order_id . '|' . $request->razorpay_payment_id,
            $keySecret
        );

        if ($generatedSignature !== $request->razorpay_signature) {
            Log::error('Razorpay Signature Verification Failed', [
                'expected' => $generatedSignature,
                'received' => $request->razorpay_signature
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed'
            ], 400);
        }

        // Payment verified, create order
        $userId = Auth::id();
        $cartItems = $this->cartService->getCartItems();
        $formData = $checkoutData['form_data'];
        $totals = $checkoutData['totals'];

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = 'SNS-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $userId,
                'first_name' => $formData['first_name'],
                'last_name' => $formData['last_name'],
                'email' => $formData['email'],
                'phone' => $formData['phone'],
                'address' => $formData['address'],
                'address_line_2' => $formData['address_line_2'] ?? null,
                'city' => $formData['city'],
                'state' => $formData['state'],
                'zipcode' => $formData['zipcode'],
                'country' => 'India',
                'subtotal' => $totals['subtotal'],
                'shipping' => $totals['shipping'],
                'discount' => $totals['discount'],
                'total' => $totals['total'],
                'payment_method' => 'online',
                'payment_status' => 'paid',
                'status' => 'processing',
                'transaction_id' => $request->razorpay_payment_id,
                'order_notes' => $formData['order_notes'] ?? null,
                'paid_at' => now(),
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product->name ?? 'Product',
                    'product_image' => $item->product->image_url ?? null,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);

                // Reduce stock
                if ($item->product && $item->product->stock > 0) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Clear cart and session
            $this->cartService->clearCart();
            session()->forget('checkout_data');

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment successful! Order placed.',
                'order_number' => $order->order_number,
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Creation After Payment Failed', [
                'error' => $e->getMessage(),
                'payment_id' => $request->razorpay_payment_id
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed. Please contact support with payment ID: ' . $request->razorpay_payment_id
            ], 500);
        }
    }

    /**
     * Process checkout - AJAX based (COD)
     */
    public function process(Request $request)
    {
        // Check login
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to place your order',
                'redirect_url' => route('user.login')
            ], 401);
        }

        // Validate request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'address_line_2' => 'nullable|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zipcode' => 'required|string|max:10',
            'payment_method' => 'required|in:cod,online',
            'order_notes' => 'nullable|string|max:1000',
        ]);

        // If online payment, redirect to Razorpay flow
        if ($validated['payment_method'] === 'online') {
            return response()->json([
                'success' => false,
                'message' => 'Please use online payment flow',
                'use_razorpay' => true
            ], 400);
        }

        $userId = Auth::id();
        $cartItems = $this->cartService->getCartItems();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        // Calculate totals with promotion
        $totals = $this->calculateTotals($cartItems);
        $subtotal = $totals['subtotal'];
        $itemCount = $totals['itemCount'];
        $shipping = $totals['shipping'];
        $discount = $totals['discount'];
        $total = $totals['total'];

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = 'SNS-' . date('Ymd') . '-' . strtoupper(Str::random(6));

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $userId,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'address_line_2' => $validated['address_line_2'] ?? null,
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zipcode' => $validated['zipcode'],
                'country' => 'India',
                'subtotal' => $subtotal,
                'shipping' => $shipping,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => 'cod',
                'payment_status' => 'pending',
                'status' => 'pending',
                'order_notes' => $validated['order_notes'] ?? null,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'product_name' => $item->product->name ?? 'Product',
                    'product_image' => $item->product->image_url ?? null,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->price * $item->quantity,
                ]);

                // Reduce stock
                if ($item->product && $item->product->stock > 0) {
                    $item->product->decrement('stock', $item->quantity);
                }
            }

            // Clear cart after successful order
            $this->cartService->clearCart();

            DB::commit();

            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
                'redirect_url' => route('checkout.success', $order->order_number)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to place order. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show order success page
     */
    public function success($orderNumber)
    {
        $order = Order::with('items.product')
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Only allow viewing own orders
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }
            
        return view('checkout-success', compact('order'));
    }
}
