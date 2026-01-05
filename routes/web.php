<?php

use Illuminate\Support\Facades\Route;
use App\Services\ImageKitService;
use Illuminate\Http\Request;

// Homepage
Route::get('/', function () {
    $products = \App\Models\Product::with(['tagsList', 'category'])
        ->where('status', 'active')
        ->where('show_in_homepage', true)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    // Get Bestsellers tag
    $bestsellersTag = \App\Models\Tag::where('slug', 'bestsellers')->first();
    $bestSellers = collect();
    if ($bestsellersTag) {
        $bestSellers = \App\Models\Product::with(['genders', 'tagsList'])
            ->where('status', 'active')
            ->whereHas('tagsList', function($q) use ($bestsellersTag) {
                $q->where('tags.id', $bestsellersTag->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    // Get New Arrivals tag (check both spellings for compatibility)
    $newArrivalsTag = \App\Models\Tag::whereIn('slug', ['new-arrivals', 'new-arrivels'])->first();
    $newArrivals = collect();
    if ($newArrivalsTag) {
        $newArrivals = \App\Models\Product::with(['genders', 'tagsList'])
            ->where('status', 'active')
            ->whereHas('tagsList', function($q) use ($newArrivalsTag) {
                $q->where('tags.id', $newArrivalsTag->id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
    }

    $banners = \App\Models\Banner::active()
        ->orderBy('order', 'asc')
        ->get();

    $testimonials = \App\Models\Testimonial::active()
        ->orderBy('sort_order', 'asc')
        ->get();

    $genders = \App\Models\Gender::where('is_active', true)
        ->orderBy('sort_order', 'asc')
        ->get();

    return view('home', compact('products', 'bestSellers', 'newArrivals', 'banners', 'testimonials', 'genders'));
})->name('home');

// About Us Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Privacy Policy Page
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy-policy');

// Return & Refund Policy Page
Route::get('/return-refund', function () {
    return view('return-refund');
})->name('return-refund');

// Shipping Policy Page
Route::get('/shipping-policy', function () {
    return view('shipping-policy');
})->name('shipping-policy');

// Terms & Conditions Page
Route::get('/terms-conditions', function () {
    return view('terms-conditions');
})->name('terms-conditions');

// Contact Us Page
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'store'])->name('contact.store');

// FAQ Page
Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Bundle Page
Route::get('/bundle', [App\Http\Controllers\BundleController::class, 'index'])->name('bundle.index');
Route::post('/bundle/save', [App\Http\Controllers\BundleController::class, 'save'])->name('bundle.save');
Route::get('/bundle/get', [App\Http\Controllers\BundleController::class, 'get'])->name('bundle.get');
Route::delete('/bundle/clear', [App\Http\Controllers\BundleController::class, 'clear'])->name('bundle.clear');
Route::get('/bundles/pre-built', [App\Http\Controllers\BundleController::class, 'preBuilt'])->name('bundles.prebuilt');

// Product Details Page (Dynamic)
Route::get('/product/{slug}', function ($slug) {
    $product = \App\Models\Product::with(['category', 'brand', 'genders', 'sizes', 'tagsList', 'highlightNotes'])
        ->where('slug', $slug)
        ->where('status', 'active')
        ->firstOrFail();
    
    // Get related products from same category or gender
    $relatedProducts = \App\Models\Product::with(['genders', 'tagsList'])
        ->where('status', 'active')
        ->where('id', '!=', $product->id)
        ->where(function($query) use ($product) {
            if ($product->category_id) {
                $query->where('category_id', $product->category_id);
            }
        })
        ->limit(4)
        ->get();
    
    return view('product.show', compact('product', 'relatedProducts'));
})->name('product.show');

// Product Review Routes (API-style for AJAX)
Route::get('/api/products/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
Route::get('/api/products/{product}/reviews/stats', [App\Http\Controllers\ReviewController::class, 'stats'])->name('reviews.stats');
Route::post('/api/products/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
Route::post('/api/reviews/upload-image', [App\Http\Controllers\ReviewController::class, 'uploadImage'])->name('reviews.upload-image');
Route::post('/api/reviews/{review}/helpful', [App\Http\Controllers\ReviewController::class, 'markHelpful'])->name('reviews.helpful');

// Keep old demo route for backward compatibility
Route::get('/product/floral-marshmallow', function () {
    return redirect()->route('home');
})->name('product.demo');

// Cart Routes (No login required - works for guests)
Route::get('/cart', [App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::get('/cart/count', [App\Http\Controllers\CartController::class, 'count'])->name('cart.count');
Route::post('/cart/add', [App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');

// Checkout Routes (Login required - handled in controller)
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::post('/checkout/razorpay/create-order', [App\Http\Controllers\CheckoutController::class, 'createRazorpayOrder'])->name('checkout.razorpay.create');
Route::post('/checkout/razorpay/verify', [App\Http\Controllers\CheckoutController::class, 'verifyRazorpayPayment'])->name('checkout.razorpay.verify');
Route::get('/checkout/success/{orderNumber}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');

// Order Tracking
Route::get('/track-order', [App\Http\Controllers\TrackingController::class, 'index'])->name('tracking.index');
Route::get('/api/track/{awbCode}', [App\Http\Controllers\TrackingController::class, 'trackByAwb'])->name('tracking.awb');
Route::get('/api/track/order/{orderNumber}', [App\Http\Controllers\TrackingController::class, 'trackByOrder'])->name('tracking.order');

// Search Page
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

// Scent Notes Filter (Professional URL)
Route::get('/scent-notes/{slug}', [App\Http\Controllers\SearchController::class, 'byNote'])->name('scent-notes.show');

// Newsletter Subscription
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Collections Page - Single unified page for all (gender, tag, collection)
Route::get('/collections', [App\Http\Controllers\CollectionController::class, 'index'])->name('collections');
Route::get('/collections/{slug}', [App\Http\Controllers\CollectionController::class, 'show'])->name('collections.show');
Route::post('/collections/filter', [App\Http\Controllers\CollectionController::class, 'filterProducts'])->name('collections.filter');

// Categories Page
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');


// User Authentication Routes
Route::get('/login', [App\Http\Controllers\UserAuthController::class, 'showLogin'])->name('user.login');
Route::post('/login', [App\Http\Controllers\UserAuthController::class, 'login'])->name('user.login.post');
Route::get('/register', [App\Http\Controllers\UserAuthController::class, 'showRegister'])->name('user.register');
Route::post('/register', [App\Http\Controllers\UserAuthController::class, 'register'])->name('user.register.post');
Route::post('/logout', [App\Http\Controllers\UserAuthController::class, 'logout'])->name('user.logout');

// Protected User Routes
Route::middleware(['auth:web'])->group(function () {
    Route::get('/account', [App\Http\Controllers\UserAuthController::class, 'account'])->name('user.account');
    Route::post('/account/profile', [App\Http\Controllers\UserAuthController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/account/password', [App\Http\Controllers\UserAuthController::class, 'updatePassword'])->name('user.password.update');

    // Address Management
    Route::post('/account/addresses', [App\Http\Controllers\UserAuthController::class, 'storeAddress'])->name('user.address.store');
    Route::get('/account/addresses/{id}/edit', [App\Http\Controllers\UserAuthController::class, 'editAddress'])->name('user.address.edit');
    Route::put('/account/addresses/{id}', [App\Http\Controllers\UserAuthController::class, 'updateAddress'])->name('user.address.update');
    Route::delete('/account/addresses/{id}', [App\Http\Controllers\UserAuthController::class, 'deleteAddress'])->name('user.address.delete');
    Route::post('/account/addresses/{id}/default', [App\Http\Controllers\UserAuthController::class, 'setDefaultAddress'])->name('user.address.default');

    // User Orders
    Route::get('/my-orders', [App\Http\Controllers\UserAuthController::class, 'orders'])->name('user.orders');
    Route::get('/my-orders/{orderNumber}', [App\Http\Controllers\UserAuthController::class, 'orderDetail'])->name('user.order.detail');
});

// Cart, Wishlist, and Checkout routes removed - frontend disabled

Route::prefix('admin')->group(function () {
    // Handle both /admin and /admin/ - both redirect to login page
    Route::get('/', [App\Http\Controllers\Admin\LoginController::class, 'showLogin'])->name('admin.login.page');
    Route::get('/login', [App\Http\Controllers\Admin\LoginController::class, 'showLogin'])->name('admin.login.form');
    Route::post('/login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login');

    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/products', [App\Http\Controllers\Admin\ProductsController::class, 'index'])->name('admin.products');

        Route::get('/products/create/step-1', [App\Http\Controllers\Admin\ProductsController::class, 'createStep1'])->name('admin.products.create.step1');
        Route::post('/products/create/step-1', [App\Http\Controllers\Admin\ProductsController::class, 'processStep1'])->name('admin.products.create.step1.process');

        Route::get('/products/create/step-2', [App\Http\Controllers\Admin\ProductsController::class, 'createStep2'])->name('admin.products.create.step2');
        Route::post('/products/create/step-2', [App\Http\Controllers\Admin\ProductsController::class, 'processStep2'])->name('admin.products.create.step2.process');

        Route::get('/products/create/step-3', [App\Http\Controllers\Admin\ProductsController::class, 'createStep3'])->name('admin.products.create.step3');
        Route::post('/products/create/step-3', [App\Http\Controllers\Admin\ProductsController::class, 'processStep3'])->name('admin.products.create.step3.process');

        Route::get('/products/create/step-4', [App\Http\Controllers\Admin\ProductsController::class, 'createStep4'])->name('admin.products.create.step4');
        Route::post('/products/create/step-4', [App\Http\Controllers\Admin\ProductsController::class, 'processStep4'])->name('admin.products.create.step4.process');

        Route::get('/products/create/step-5', [App\Http\Controllers\Admin\ProductsController::class, 'createStep5'])->name('admin.products.create.step5');
        Route::post('/products/create/step-5', [App\Http\Controllers\Admin\ProductsController::class, 'processStep5'])->name('admin.products.create.step5.process');

        Route::get('/products/create/step-6', [App\Http\Controllers\Admin\ProductsController::class, 'createStep6'])->name('admin.products.create.step6');
        Route::post('/products/create/step-6', [App\Http\Controllers\Admin\ProductsController::class, 'processStep6'])->name('admin.products.create.step6.process');

        Route::get('/products/create/step-7', [App\Http\Controllers\Admin\ProductsController::class, 'createStep7'])->name('admin.products.create.step7');
        Route::post('/products/create/step-7', [App\Http\Controllers\Admin\ProductsController::class, 'processStep7'])->name('admin.products.create.step7.process');

        Route::post('/products/create/clear-session', [App\Http\Controllers\Admin\ProductsController::class, 'clearSession'])->name('admin.products.create.clear-session');

        Route::get('/products/{product}/edit/step1', [App\Http\Controllers\Admin\ProductsController::class, 'editStep1'])->name('admin.products.edit.step1');
        Route::post('/products/{product}/edit/step1', [App\Http\Controllers\Admin\ProductsController::class, 'processEditStep1'])->name('admin.products.edit.step1.process');

        Route::get('/products/{product}/edit/step2', [App\Http\Controllers\Admin\ProductsController::class, 'editStep2'])->name('admin.products.edit.step2');
        Route::post('/products/{product}/edit/step2', [App\Http\Controllers\Admin\ProductsController::class, 'processEditStep2'])->name('admin.products.edit.step2.process');

        Route::get('/products/{product}/edit/step3', [App\Http\Controllers\Admin\ProductsController::class, 'editStep3'])->name('admin.products.edit.step3');
        Route::post('/products/{product}/edit/step3', [App\Http\Controllers\Admin\ProductsController::class, 'processEditStep3'])->name('admin.products.edit.step3.process');

        Route::get('/products/{product}/edit/step4', [App\Http\Controllers\Admin\ProductsController::class, 'editStep4'])->name('admin.products.edit.step4');
        Route::post('/products/{product}/edit/step4', [App\Http\Controllers\Admin\ProductsController::class, 'processEditStep4'])->name('admin.products.edit.step4.process');

        Route::get('/products/{product}/edit/step5', [App\Http\Controllers\Admin\ProductsController::class, 'editStep5'])->name('admin.products.edit.step5');
        Route::post('/products/{product}/edit/step5', [App\Http\Controllers\Admin\ProductsController::class, 'processEditStep5'])->name('admin.products.edit.step5.process');

        Route::get('/products/{product}/edit/step6', [App\Http\Controllers\Admin\ProductsController::class, 'editStep6'])->name('admin.products.edit.step6');
        Route::post('/products/{product}/edit/step6', [App\Http\Controllers\Admin\ProductsController::class, 'processEditStep6'])->name('admin.products.edit.step6.process');

        Route::get('/products/{product}/edit/step7', [App\Http\Controllers\Admin\ProductsController::class, 'editStep7'])->name('admin.products.edit.step7');
        Route::post('/products/{product}/edit/step7', [App\Http\Controllers\Admin\ProductsController::class, 'processEditStep7'])->name('admin.products.edit.step7.process');

        Route::get('/products/create', function () {
            return redirect()->route('admin.products.create.step1');
        })->name('admin.products.create');
        Route::post('/products', [App\Http\Controllers\Admin\ProductsController::class, 'store'])->name('admin.products.store');

        Route::post('/upload-image', function (Request $request, ImageKitService $imageKit) {
            try {
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240',
                    'folder' => 'nullable|string'
                ]);

                $folder = $request->input('folder', 'products');

                if (in_array($folder, ['categories', 'genders'])) {
                    $result = $imageKit->uploadCategoryImage($request->file('image'), $folder);
                } else {

                    $result = $imageKit->uploadProductImage($request->file('image'), $folder);
                }

                if ($result && $result['success']) {
                    return response()->json([
                        'success' => true,
                        'url' => $result['url'],
                        'file_id' => $result['file_id'],
                        'fileId' => $result['file_id'],
                        'width' => $result['width'],
                        'height' => $result['height'],
                        'size' => $result['size'],
                        'original_size' => $result['original_size'],
                        'originalSize' => $result['original_size'],
                        'name' => $result['name'] ?? 'image',
                    ]);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to upload image'
                ], 500);

            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        })->name('admin.upload.image');

        Route::get('/products/{product}', [App\Http\Controllers\Admin\ProductsController::class, 'show'])->name('admin.products.show');
        Route::get('/products/{product}/edit', function ($product) {
            return redirect()->route('admin.products.edit.step1', $product);
        })->name('admin.products.edit');
        Route::put('/products/{product}', [App\Http\Controllers\Admin\ProductsController::class, 'update'])->name('admin.products.update');
        Route::delete('/products/{product}', [App\Http\Controllers\Admin\ProductsController::class, 'destroy'])->name('admin.products.destroy');

        Route::post('/products/{product}/toggle', [App\Http\Controllers\Admin\ProductsController::class, 'toggle'])->name('admin.products.toggle');

        Route::post('/products/{product}/duplicate', [App\Http\Controllers\Admin\ProductsController::class, 'duplicate'])->name('admin.products.duplicate');

        Route::post('/products/bulk-action', [App\Http\Controllers\Admin\ProductsController::class, 'bulkAction'])->name('admin.products.bulk-action');

        Route::get('/products/export', [App\Http\Controllers\Admin\ProductsController::class, 'export'])->name('admin.products.export');

        Route::post('/products/{product}/status', [App\Http\Controllers\Admin\ProductsController::class, 'updateStatus'])->name('admin.products.status');
        Route::post('/products/{product}/toggle-featured', [App\Http\Controllers\Admin\ProductsController::class, 'toggleFeatured'])->name('admin.products.toggle-featured');
        Route::post('/products/bulk-delete', [App\Http\Controllers\Admin\ProductsController::class, 'bulkDelete'])->name('admin.products.bulk-delete');

        Route::resource('/categories', App\Http\Controllers\Admin\CategoryController::class, [
            'as' => 'admin'
        ]);
        Route::post('/categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('admin.categories.toggle-status');
        Route::post('/categories/{category}/toggle-featured', [App\Http\Controllers\Admin\CategoryController::class, 'toggleFeatured'])->name('admin.categories.toggle-featured');
        Route::post('/categories/{category}/toggle', [App\Http\Controllers\Admin\CategoryController::class, 'toggle'])->name('admin.categories.toggle');
        Route::post('/categories/bulk-action', [App\Http\Controllers\Admin\CategoryController::class, 'bulkAction'])->name('admin.categories.bulk-action');
        Route::get('/categories/export', [App\Http\Controllers\Admin\CategoryController::class, 'export'])->name('admin.categories.export');
        Route::post('/categories/bulk-delete', [App\Http\Controllers\Admin\CategoryController::class, 'bulkDelete'])->name('admin.categories.bulk-delete');

        Route::resource('/sizes', App\Http\Controllers\Admin\SizeController::class, [
            'as' => 'admin'
        ]);
        Route::post('/sizes/{size}/toggle', [App\Http\Controllers\Admin\SizeController::class, 'toggle'])->name('admin.sizes.toggle');
        Route::post('/sizes/bulk-action', [App\Http\Controllers\Admin\SizeController::class, 'bulkAction'])->name('admin.sizes.bulk-action');
        Route::get('/sizes/export', [App\Http\Controllers\Admin\SizeController::class, 'export'])->name('admin.sizes.export');

        Route::post('/genders/upload-image', [App\Http\Controllers\Admin\GenderController::class, 'uploadImage'])->name('admin.genders.upload-image');
        Route::resource('/genders', App\Http\Controllers\Admin\GenderController::class, [
            'as' => 'admin'
        ]);
        Route::post('/genders/{gender}/toggle', [App\Http\Controllers\Admin\GenderController::class, 'toggle'])->name('admin.genders.toggle');
        Route::post('/genders/bulk-action', [App\Http\Controllers\Admin\GenderController::class, 'bulkAction'])->name('admin.genders.bulk-action');
        Route::get('/genders/export', [App\Http\Controllers\Admin\GenderController::class, 'export'])->name('admin.genders.export');

        // User Management Routes
        Route::resource('/users', App\Http\Controllers\Admin\UserController::class, [
            'as' => 'admin'
        ]);
        Route::post('/users/{user}/ban', [App\Http\Controllers\Admin\UserController::class, 'ban'])->name('admin.users.ban');
        Route::post('/users/{user}/unban', [App\Http\Controllers\Admin\UserController::class, 'unban'])->name('admin.users.unban');
        Route::post('/users/{user}/toggle', [App\Http\Controllers\Admin\UserController::class, 'toggle'])->name('admin.users.toggle');
        Route::post('/users/bulk-action', [App\Http\Controllers\Admin\UserController::class, 'bulkAction'])->name('admin.users.bulk-action');
        Route::get('/users/export', [App\Http\Controllers\Admin\UserController::class, 'export'])->name('admin.users.export');

        Route::post('/lookbooks/upload-image', [App\Http\Controllers\Admin\LookbookController::class, 'uploadImage'])->name('admin.lookbooks.uploadImage');

        Route::resource('/lookbooks', App\Http\Controllers\Admin\LookbookController::class, [
            'as' => 'admin'
        ]);
        Route::post('/lookbooks/{lookbook}/toggle', [App\Http\Controllers\Admin\LookbookController::class, 'toggle'])->name('admin.lookbooks.toggle');
        Route::post('/lookbooks/bulk-action', [App\Http\Controllers\Admin\LookbookController::class, 'bulkAction'])->name('admin.lookbooks.bulk-action');
        Route::get('/lookbooks/export', [App\Http\Controllers\Admin\LookbookController::class, 'export'])->name('admin.lookbooks.export');

        // Blog Routes
        Route::post('/blogs/upload-image', [App\Http\Controllers\Admin\BlogController::class, 'uploadImage'])->name('admin.blogs.upload-image');
        Route::post('/blogs/{blog}/save-gallery', [App\Http\Controllers\Admin\BlogController::class, 'saveGalleryImages'])->name('admin.blogs.save-gallery');
        Route::post('/blogs/bulk-action', [App\Http\Controllers\Admin\BlogController::class, 'bulkAction'])->name('admin.blogs.bulk-action');
        Route::post('/blogs/{blog}/toggle', [App\Http\Controllers\Admin\BlogController::class, 'toggle'])->name('admin.blogs.toggle');
        Route::resource('/blogs', App\Http\Controllers\Admin\BlogController::class, [
            'as' => 'admin'
        ]);

        Route::resource('/brands', App\Http\Controllers\Admin\BrandController::class, [
            'as' => 'admin'
        ]);
        Route::post('/brands/{brand}/toggle', [App\Http\Controllers\Admin\BrandController::class, 'toggle'])->name('admin.brands.toggle');
        Route::post('/brands/bulk-action', [App\Http\Controllers\Admin\BrandController::class, 'bulkAction'])->name('admin.brands.bulk-action');
        Route::get('/brands/export', [App\Http\Controllers\Admin\BrandController::class, 'export'])->name('admin.brands.export');

        Route::post('/collections/upload-image', [App\Http\Controllers\Admin\CollectionController::class, 'uploadImage'])->name('admin.collections.upload-image');

        Route::resource('/collections', App\Http\Controllers\Admin\CollectionController::class, [
            'as' => 'admin'
        ]);
        Route::post('/collections/{collection}/toggle', [App\Http\Controllers\Admin\CollectionController::class, 'toggle'])->name('admin.collections.toggle');
        Route::post('/collections/bulk-action', [App\Http\Controllers\Admin\CollectionController::class, 'bulkAction'])->name('admin.collections.bulk-action');
        Route::get('/collections/export', [App\Http\Controllers\Admin\CollectionController::class, 'export'])->name('admin.collections.export');

        Route::post('/tags/upload-image', [App\Http\Controllers\Admin\TagController::class, 'uploadImage'])->name('admin.tags.upload-image');
        Route::resource('/tags', App\Http\Controllers\Admin\TagController::class, [
            'as' => 'admin'
        ]);
        Route::post('/tags/{tag}/toggle', [App\Http\Controllers\Admin\TagController::class, 'toggle'])->name('admin.tags.toggle');
        Route::post('/tags/bulk-action', [App\Http\Controllers\Admin\TagController::class, 'bulkAction'])->name('admin.tags.bulk-action');
        Route::get('/tags/export', [App\Http\Controllers\Admin\TagController::class, 'export'])->name('admin.tags.export');

        // Highlight Notes Management
        Route::post('/highlight-notes/upload-image', [App\Http\Controllers\Admin\HighlightNoteController::class, 'uploadImage'])->name('admin.highlight-notes.upload-image');
        Route::resource('/highlight-notes', App\Http\Controllers\Admin\HighlightNoteController::class, [
            'as' => 'admin'
        ]);
        Route::post('/highlight-notes/{highlightNote}/toggle', [App\Http\Controllers\Admin\HighlightNoteController::class, 'toggle'])->name('admin.highlight-notes.toggle');
        Route::post('/highlight-notes/bulk-action', [App\Http\Controllers\Admin\HighlightNoteController::class, 'bulkAction'])->name('admin.highlight-notes.bulk-action');
        Route::get('/highlight-notes/export', [App\Http\Controllers\Admin\HighlightNoteController::class, 'export'])->name('admin.highlight-notes.export');

        // Scent Families Management
        Route::post('/scent-families/upload-image', [App\Http\Controllers\Admin\ScentFamilyController::class, 'uploadImage'])->name('admin.scent-families.upload-image');
        Route::resource('/scent-families', App\Http\Controllers\Admin\ScentFamilyController::class, [
            'as' => 'admin'
        ]);
        Route::post('/scent-families/{scentFamily}/toggle', [App\Http\Controllers\Admin\ScentFamilyController::class, 'toggle'])->name('admin.scent-families.toggle');
        Route::post('/scent-families/bulk-action', [App\Http\Controllers\Admin\ScentFamilyController::class, 'bulkAction'])->name('admin.scent-families.bulk-action');
        Route::get('/scent-families/export', [App\Http\Controllers\Admin\ScentFamilyController::class, 'export'])->name('admin.scent-families.export');

        Route::resource('/coupons', App\Http\Controllers\Admin\CouponController::class, [
            'as' => 'admin'
        ]);
        Route::post('/coupons/{coupon}/toggle', [App\Http\Controllers\Admin\CouponController::class, 'toggle'])->name('admin.coupons.toggle');
        Route::post('/coupons/bulk-action', [App\Http\Controllers\Admin\CouponController::class, 'bulkAction'])->name('admin.coupons.bulk-action');
        Route::get('/coupons/export', [App\Http\Controllers\Admin\CouponController::class, 'export'])->name('admin.coupons.export');

        // Orders Management
        Route::resource('/orders', App\Http\Controllers\Admin\OrderController::class, [
            'as' => 'admin'
        ]);
        Route::patch('/orders/{order}/update-status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.update-status');
        Route::post('/orders/{order}/payment-status', [App\Http\Controllers\Admin\OrderController::class, 'updatePaymentStatus'])->name('admin.orders.updatePaymentStatus');
        Route::post('/orders/bulk-action', [App\Http\Controllers\Admin\OrderController::class, 'bulkAction'])->name('admin.orders.bulk-action');
        Route::get('/orders/export', [App\Http\Controllers\Admin\OrderController::class, 'export'])->name('admin.orders.export');

        // Admin Users Management
        Route::resource('admin-users', App\Http\Controllers\Admin\AdminUserController::class);
        Route::post('/admin-users/{adminUser}/toggle-status', [App\Http\Controllers\Admin\AdminUserController::class, 'toggleStatus']);

        // Activity Logs & Login History
        Route::get('/activity-logs', [App\Http\Controllers\Admin\AdminUserController::class, 'activityLogs']);
        Route::get('/login-history', [App\Http\Controllers\Admin\AdminUserController::class, 'loginHistory']);

        Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
        Route::post('/settings/imagekit', [App\Http\Controllers\Admin\SettingsController::class, 'updateImageKit'])->name('admin.settings.imagekit');
        Route::post('/settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'updateGeneral'])->name('admin.settings.general');
        Route::post('/settings/payment', [App\Http\Controllers\Admin\SettingsController::class, 'updatePaymentGateway'])->name('admin.settings.payment');
        Route::post('/settings/upload-logo', [App\Http\Controllers\Admin\SettingsController::class, 'uploadLogo'])->name('admin.settings.uploadLogo');
        Route::post('/settings/social', [App\Http\Controllers\Admin\SettingsController::class, 'updateSocialMedia'])->name('admin.settings.social');
        Route::post('/settings/maintenance', [App\Http\Controllers\Admin\SettingsController::class, 'updateMaintenance'])->name('admin.settings.maintenance');
        Route::post('/settings/seo', [App\Http\Controllers\Admin\SettingsController::class, 'updateSEO'])->name('admin.settings.seo');
        Route::post('/settings/upload-og-image', [App\Http\Controllers\Admin\SettingsController::class, 'uploadOGImage'])->name('admin.settings.uploadOGImage');
        Route::post('/settings/generate-sitemap', [App\Http\Controllers\Admin\SettingsController::class, 'generateSitemap'])->name('admin.settings.generateSitemap');
        Route::post('/settings/shiprocket', [App\Http\Controllers\Admin\SettingsController::class, 'updateShiprocket'])->name('admin.settings.shiprocket');

        // Newsletter Subscribers Management
        Route::get('/newsletter', [App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('admin.newsletter.index');
        Route::post('/newsletter/{id}/toggle', [App\Http\Controllers\Admin\NewsletterController::class, 'toggle'])->name('admin.newsletter.toggle');
        Route::delete('/newsletter/{id}', [App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('admin.newsletter.destroy');
        Route::get('/newsletter/export', [App\Http\Controllers\Admin\NewsletterController::class, 'export'])->name('admin.newsletter.export');
        Route::post('/newsletter/bulk-delete', [App\Http\Controllers\Admin\NewsletterController::class, 'bulkDelete'])->name('admin.newsletter.bulk-delete');

        // Contact Messages Management
        Route::get('/contact-messages', [App\Http\Controllers\Admin\ContactMessageController::class, 'index'])->name('admin.contact-messages.index');
        Route::get('/contact-messages/{id}', [App\Http\Controllers\Admin\ContactMessageController::class, 'show'])->name('admin.contact-messages.show');
        Route::post('/contact-messages/{id}/status', [App\Http\Controllers\Admin\ContactMessageController::class, 'updateStatus'])->name('admin.contact-messages.update-status');
        Route::post('/contact-messages/{id}/notes', [App\Http\Controllers\Admin\ContactMessageController::class, 'addNotes'])->name('admin.contact-messages.add-notes');
        Route::delete('/contact-messages/{id}', [App\Http\Controllers\Admin\ContactMessageController::class, 'destroy'])->name('admin.contact-messages.destroy');
        Route::post('/contact-messages/bulk-delete', [App\Http\Controllers\Admin\ContactMessageController::class, 'bulkDelete'])->name('admin.contact-messages.bulk-delete');

        // Shiprocket API Routes
        Route::prefix('shiprocket')->name('admin.shiprocket.')->group(function () {
            Route::post('/test', [App\Http\Controllers\Admin\ShiprocketController::class, 'testConnection'])->name('test');
            Route::get('/pickup-locations', [App\Http\Controllers\Admin\ShiprocketController::class, 'getPickupLocations'])->name('pickup-locations');
            Route::post('/orders/{order}/create', [App\Http\Controllers\Admin\ShiprocketController::class, 'createOrder'])->name('orders.create');
            Route::get('/orders/{order}/couriers', [App\Http\Controllers\Admin\ShiprocketController::class, 'getCouriers'])->name('orders.couriers');
            Route::post('/orders/{order}/awb', [App\Http\Controllers\Admin\ShiprocketController::class, 'generateAWB'])->name('orders.awb');
            Route::post('/orders/{order}/pickup', [App\Http\Controllers\Admin\ShiprocketController::class, 'schedulePickup'])->name('orders.pickup');
            Route::post('/orders/{order}/label', [App\Http\Controllers\Admin\ShiprocketController::class, 'generateLabel'])->name('orders.label');
            Route::post('/orders/{order}/manifest', [App\Http\Controllers\Admin\ShiprocketController::class, 'generateManifest'])->name('orders.manifest');
            Route::post('/orders/{order}/invoice', [App\Http\Controllers\Admin\ShiprocketController::class, 'generateInvoice'])->name('orders.invoice');
            Route::get('/orders/{order}/track', [App\Http\Controllers\Admin\ShiprocketController::class, 'trackShipment'])->name('orders.track');
            Route::post('/orders/{order}/cancel', [App\Http\Controllers\Admin\ShiprocketController::class, 'cancelShipment'])->name('orders.cancel');
        });

        // Banner Management
        Route::resource('/banners', App\Http\Controllers\Admin\BannerController::class, [
            'as' => 'admin'
        ]);
        Route::post('/banners/upload-image', [App\Http\Controllers\Admin\BannerController::class, 'uploadImage'])->name('admin.banners.uploadImage');
        Route::post('/banners/{banner}/toggle', [App\Http\Controllers\Admin\BannerController::class, 'toggle'])->name('admin.banners.toggle');
        Route::post('/banners/update-order', [App\Http\Controllers\Admin\BannerController::class, 'updateOrder'])->name('admin.banners.updateOrder');
        Route::post('/banners/fill-demo', [App\Http\Controllers\Admin\BannerController::class, 'fillDemo'])->name('admin.banners.fillDemo');

        // Testimonials Management
        Route::resource('/testimonials', App\Http\Controllers\Admin\TestimonialController::class, [
            'as' => 'admin'
        ]);
        Route::post('/testimonials/{testimonial}/toggle', [App\Http\Controllers\Admin\TestimonialController::class, 'toggle'])->name('admin.testimonials.toggle');
        Route::post('/testimonials/bulk-action', [App\Http\Controllers\Admin\TestimonialController::class, 'bulkAction'])->name('admin.testimonials.bulk-action');
        Route::get('/testimonials/export', [App\Http\Controllers\Admin\TestimonialController::class, 'export'])->name('admin.testimonials.export');

        // Promotions Management
        Route::resource('/promotions', App\Http\Controllers\Admin\PromotionController::class, [
            'as' => 'admin'
        ]);
        Route::post('/promotions/{promotion}/toggle', [App\Http\Controllers\Admin\PromotionController::class, 'toggle'])->name('admin.promotions.toggle');

        Route::get('/logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');
    });
});


