<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Validation\ValidationException;

class UserAuthController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    // Show login form
    public function showLogin()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.account');
        }
        
        $pageTitle = 'Login - ' . config('app.name', 'Fashion Store');
        $pageDescription = 'Login to your account to access your orders, wishlist, and manage your profile.';
        
        return view('website.auth.login', compact('pageTitle', 'pageDescription'));
    }

    // Show register form
    public function showRegister()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('user.account');
        }
        
        $pageTitle = 'Register - ' . config('app.name', 'Fashion Store');
        $pageDescription = 'Create your account to start shopping and enjoy exclusive benefits and offers.';
        
        return view('website.auth.register', compact('pageTitle', 'pageDescription'));
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Merge guest cart into user cart
            $this->cartService->mergeGuestCartToUser(Auth::id());
            
            // Migrate session bundle to user
            $this->migrateBundleToUser($request->session()->getId(), Auth::id());
            
            // Check if user was trying to checkout
            $redirectTo = session()->pull('checkout_redirect', route('user.account'));
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'redirect' => $redirectTo
                ]);
            }
            
            return redirect()->intended($redirectTo)->with('success', 'Welcome back!');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Migrate session bundle to user account
     */
    protected function migrateBundleToUser($sessionId, $userId)
    {
        $sessionBundle = \App\Models\Bundle::where('session_id', $sessionId)
            ->whereNull('user_id')
            ->first();

        if ($sessionBundle) {
            // Check if user already has a bundle
            $userBundle = \App\Models\Bundle::where('user_id', $userId)->first();
            
            if ($userBundle) {
                // Merge session bundle items with user bundle
                $mergedItems = collect($userBundle->items)->merge($sessionBundle->items)->unique('id')->values()->all();
                $userBundle->update(['items' => $mergedItems]);
                $sessionBundle->delete();
            } else {
                // Just update session bundle to user
                $sessionBundle->update(['user_id' => $userId, 'session_id' => null]);
            }
        }
    }

    // Handle registration
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Auth::guard('web')->login($user);
        
        // Merge guest cart into user cart
        $this->cartService->mergeGuestCartToUser($user->id);
        
        // Migrate session bundle to user
        $this->migrateBundleToUser($request->session()->getId(), $user->id);
        
        // Check if user was trying to checkout
        $redirectTo = session()->pull('checkout_redirect', route('user.account'));

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'redirect' => $redirectTo
            ]);
        }

        return redirect($redirectTo)->with('success', 'Account created successfully!');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Logged out successfully!');
    }

    // Show user account page
    public function account()
    {
        $user = Auth::guard('web')->user();
        $addresses = $user->addresses()->latest()->get();
        
        $pageTitle = 'My Account - ' . config('app.name', 'Fashion Store');
        $pageDescription = 'Manage your account, view orders, update profile information, and manage addresses.';
        
        return view('website.auth.account', compact('user', 'addresses', 'pageTitle', 'pageDescription'));
    }

    // Store new address
    public function storeAddress(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'pincode' => 'required|string|max:10',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'type' => 'nullable|in:home,work',
            'is_default' => 'nullable|boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($request->is_default) {
            $user->addresses()->update(['is_default' => false]);
        }

        $address = $user->addresses()->create([
            'name' => $request->name,
            'phone' => $request->phone,
            'pincode' => $request->pincode,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'type' => $request->type ?? 'home',
            'is_default' => $request->is_default ? true : false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Address added successfully!',
                'address' => $address
            ]);
        }

        return back()->with('success', 'Address added successfully!');
    }

    // Get address for editing
    public function editAddress($id)
    {
        $user = Auth::guard('web')->user();
        $address = $user->addresses()->findOrFail($id);

        return response()->json([
            'success' => true,
            'address' => $address
        ]);
    }

    // Update address
    public function updateAddress(Request $request, $id)
    {
        $user = Auth::guard('web')->user();
        $address = $user->addresses()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'pincode' => 'required|string|max:10',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'type' => 'nullable|in:home,work',
            'is_default' => 'nullable|boolean',
        ]);

        // If this is set as default, unset other defaults
        if ($request->is_default) {
            $user->addresses()->where('id', '!=', $id)->update(['is_default' => false]);
        }

        $address->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'pincode' => $request->pincode,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'type' => $request->type ?? 'home',
            'is_default' => $request->is_default ? true : false,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Address updated successfully!',
                'address' => $address->fresh()
            ]);
        }

        return back()->with('success', 'Address updated successfully!');
    }

    // Delete address
    public function deleteAddress($id)
    {
        $user = Auth::guard('web')->user();
        $address = $user->addresses()->findOrFail($id);
        $address->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Address deleted successfully!'
            ]);
        }

        return back()->with('success', 'Address deleted successfully!');
    }

    // Set default address
    public function setDefaultAddress($id)
    {
        $user = Auth::guard('web')->user();
        
        // Unset all defaults
        $user->addresses()->update(['is_default' => false]);
        
        // Set this as default
        $address = $user->addresses()->findOrFail($id);
        $address->update(['is_default' => true]);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Default address updated!'
            ]);
        }

        return back()->with('success', 'Default address updated!');
    }

    // Update user profile
    public function updateProfile(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully!'
            ]);
        }

        return back()->with('success', 'Profile updated successfully!');
    }

    // Update password
    public function updatePassword(Request $request)
    {
        $user = Auth::guard('web')->user();

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Current password is incorrect',
                    'errors' => ['current_password' => ['Current password is incorrect']]
                ], 422);
            }
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password updated successfully!'
            ]);
        }

        return back()->with('success', 'Password updated successfully!');
    }

    // User Orders
    public function orders()
    {
        $orders = Auth::user()->orders()->with('items.product')->latest()->paginate(10);
        
        $pageTitle = 'My Orders - ' . config('app.name', 'Fashion Store');
        $pageDescription = 'View and track all your orders. Check order status, delivery information, and order history.';
        
        return view('website.auth.orders', compact('orders', 'pageTitle', 'pageDescription'));
    }

    public function orderDetail($orderNumber)
    {
        $order = Auth::user()->orders()
            ->where('order_number', $orderNumber)
            ->with(['items.product', 'items.variant'])
            ->firstOrFail();
        
        $pageTitle = 'Order #' . $order->order_number . ' - ' . config('app.name', 'Fashion Store');
        $pageDescription = 'View detailed information about your order including items, shipping address, and payment details.';
        
        return view('website.auth.order-detail', compact('order', 'pageTitle', 'pageDescription'));
    }
}
