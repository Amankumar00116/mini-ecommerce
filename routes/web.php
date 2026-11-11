<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Admin\DeliveryBoyController;
use App\Http\Controllers\DeliveryBoyDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HOME / FRONTEND
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/',[ProductController::class,'index']);

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

// Login Page
Route::get('/login',[AuthenticatedSessionController::class,'create'])->name('login');

// Login Submit
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

/*
|--------------------------------------------------------------------------
| SEARCH BAR
|--------------------------------------------------------------------------
*/
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// search-suggestions.....

Route::get('/search-suggestions', [ProductController::class, 'suggestions'])
    ->name('products.suggestions');

/*

|--------------------------------------------------------------------------
| PRODUCTS
|--------------------------------------------------------------------------
*/

// Product List
Route::get('/products', [ProductController::class,'products']);

// Create Product Page
Route::get('/products/create',[ProductController::class,'create']);

// Store New Product
Route::post('/products/create', [ProductController::class, 'store']);

// Edit Product Page
Route::get('/products/{id}/edit', [ProductController::class, 'edit'])
    ->name('products.edit');

// Update Product
Route::put('/products/{id}', [ProductController::class, 'update'])
    ->name('products.update');

// Delete Product
Route::delete('/products/{id}', [ProductController::class, 'destroy'])
    ->name('products.destroy');

/*
|--------------------------------------------------------------------------
| CATEGORY - FRONTEND
|--------------------------------------------------------------------------
|
| Category products public hain.
| Login ki zarurat nahi hai.
|
*/

// Shop by Category

Route::get('/category/{category}', [CategoryController::class, 'show'])
    ->name('category.show');

Route::get('/category-group/{type}', [CategoryController::class, 'group'])
    ->name('category.group');

/*
|--------------------------------------------------------------------------
| ADD TO CART
|--------------------------------------------------------------------------
|
| Route public hai, lekin CartController ke andar
| login check hoga.
|
*/

// Add Product to Cart.========
Route::post('/cart/add/{product}', [CartController::class, 'addToCart'])
    ->name('cart.add');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
|
| Neeche wale routes ke liye user ka login hona zaroori hai.
|
*/

Route::middleware('auth')->group(function () {

 /*
    |--------------------------------------------------------------------------
    |ADMIN DASHBOARD
    |--------------------------------------------------------------------------
    */
Route::get('/dashboard', function () {

    $totalOrders = \App\Models\booking::count();

    $totalCustomers = \App\Models\User::where('role', 'customer')->count();

    $totalDeliveryBoys = \App\Models\User::where('role', 'delivery_boy')->count();

    $totalProducts = \App\Models\Product::count();

    $recentOrders = \App\Models\booking::with('product')
        ->latest()
        ->take(5)
        ->get();

    $orderStatuses = \App\Models\booking::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

    $recentDeliveryBoys = \App\Models\User::where('role', 'delivery_boy')
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'totalOrders',
        'totalCustomers',
        'totalDeliveryBoys',
        'totalProducts',
        'recentOrders',
        'orderStatuses',
        'recentDeliveryBoys'
    ));

})->middleware('verified')->name('dashboard');
 /*
    |--------------------------------------------------------------------------
    | MY ACCOUNT
    |--------------------------------------------------------------------------
    */
// MY ACCOUNT.=====
Route::get('/my-account', function () {
    return view('my-account');
})
->name('my.account');

  /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */
    // Profile Edit
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    // Profile Update.
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Proile Delete.
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 /*
    |--------------------------------------------------------------------------
    | EDIT PROFILE
    |--------------------------------------------------------------------------
    */

    // Edit Profile Page
    Route::get('/edit-profile', [ProfileController::class, 'edit'])
        ->name('edit.profile');

    // Update Profile.=
    Route::patch('/edit-profile', [ProfileController::class, 'update'])
        ->name('edit.profile.update');


     /*
    |--------------------------------------------------------------------------
    | BOOKING / ORDER
    |--------------------------------------------------------------------------
    */

    // Booking Page
    Route::get('/booking/{product}', [BookingController::class, 'create'])
        ->name('booking.create');

    // PLACEORDER..
    Route::post('/booking/place-order', [BookingController::class, 'placeOrder'])
    ->name('booking.placeOrder');

    // Save Booking..
    Route::post('/booking/{product}', [BookingController::class, 'store'])
    ->name('booking.store');

    // Address Page..
    Route::get('/booking/{product}/address', [BookingController::class, 'address'])
    ->name('booking.address');
    // PAYMENT Page...
    Route::get('/booking/{product}/payment', [BookingController::class, 'payment'])
    ->name('booking.payment');

    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */

    // Cart Page
    Route::get('/cart', [CartController::class, 'index'])
    ->name('cart.index');

    // Update Cart Quantity
    Route::post('/cart/update/{cart}', [CartController::class, 'updateQuantity'])
    ->name('cart.update');

    // Remove Product from Cart
    Route::delete('/cart/remove/{cart}', [CartController::class, 'remove'])
    ->name('cart.remove');

    // Cart Checkout Page
    Route::get('/cart/checkout', [CartController::class, 'checkout'])
    ->name('cart.checkout');

    // Store Cart Order
    Route::post('/cart/checkout/store', [BookingController::class, 'storeCart'])
    ->name('cart.checkout.store');


    // notification frontend.....
    Route::get('/notifications', function () {
    $notifications = auth()->user()
        ->notifications()
        ->latest()
        ->get();

    return view('notifications.index', compact('notifications'));
    })->middleware('auth')->name('notifications.index');


    Route::post('/notifications/{id}/read', function ($id) {

    $notification = auth()->user()
        ->notifications()
        ->findOrFail($id);

    $notification->markAsRead();

    return redirect()->route('notifications.index');

    })->middleware('auth')->name('notifications.read');

    /*
    |--------------------------------------------------------------------------
    | MY ORDERS
    |--------------------------------------------------------------------------
    */

    // MY ACCOUNT SECTION KA MY ORDERS BUTTON===
    Route::get('/my-orders', [BookingController::class, 'myOrders'])
    ->name('my.orders');

    // Trace Orders.====
    Route::get('/my-orders/{id}/track', [BookingController::class, 'trackOrder'])
    ->name('order.track');

    // HELP-CENTER.========
    Route::get('/help-center', function(){
        return view('help-center');
    })->name('help.center');

      /*
    |--------------------------------------------------------------------------
    | SAVED ADDRESSES
    |--------------------------------------------------------------------------
    */

    // ADDRESS IN MY ACCOUNT.=====

    Route::get('/saved-addresses', function () {
    $addresses = auth()->user()->addresses;
    return view('saved-addresses', compact('addresses'));
    })->name('saved.addresses');

    // Save New Address...
    Route::post('/saved-addresses', [CartController::class, 'storeAddress'])
    ->name('saved.addresses.store');

    // DELETE ADDRESSES in ADDRESSES SECTION IN MY ACCOUNT
    Route::delete('/address/{address}', [CartController::class, 'deleteAddress'])
    ->name('address.delete');

// EDIT ADDRESS BUTTON IN BOOKING.CREATE
    Route::get('/address/{address}/edit', [CartController::class, 'editAddress'])
    ->name('address.edit');

    // Update Address..
    Route::put('/address/{address}', [CartController::class, 'updateAddress'])
    ->name('address.update');
     /*
    |--------------------------------------------------------------------------
    | ADMIN ORDERS
    |--------------------------------------------------------------------------
    */

    // admin check order list...
    Route::get('/admin/orders',[BookingController::class,'orders'])
    ->name('admin.orders');

    // Admin Update Order Status..
    Route::post('/admin/orders/{id}/status', [BookingController::class, 'updateStatus'])
    ->name('admin.orders.status');
    /*
|--------------------------------------------------------------------------
| ADMIN - DELIVERY BOY MANAGEMENT
|--------------------------------------------------------------------------
*/

    // Delivery Boy Dashboard
    Route::get('/delivery-boy/dashboard', function () {
    abort_unless(auth()->user()?->role === 'delivery_boy', 403);

    return app(\App\Http\Controllers\DeliveryBoyDashboardController::class)->index();
    })->middleware('auth')->name('delivery-boy.dashboard');

    // Delivery Boy My Orders
    Route::get('/delivery-boy/my-orders',
    [\App\Http\Controllers\DeliveryBoyDashboardController::class, 'myOrders'])
    ->name('delivery-boy.my-orders');

    // Delivery Boy Assigned Deliveries
    Route::get('/delivery-boy/assigned-deliveries', [
    \App\Http\Controllers\DeliveryBoyDashboardController::class,
    'assignedDeliveries'
    ])->name('delivery-boy.assigned-deliveries');


    Route::post('/delivery-boy/orders/{id}/delivered', [
    \App\Http\Controllers\DeliveryBoyDashboardController::class,
    'markDelivered'
    ])->name('delivery-boy.mark-delivered');

    // Delivery Boy Completed Delivery orders.

    Route::get('/delivery-boy/completed-orders', [DeliveryBoyDashboardController::class,'completedOrders'])
    ->name('delivery-boy.completed-orders');



    // Admin Delivery Boys
    Route::get('/admin/delivery-boys', [DeliveryBoyController::class, 'index'])
        ->name('admin.delivery-boys.index');

    Route::post('/admin/delivery-boys', [DeliveryBoyController::class, 'store'])
        ->name('admin.delivery-boys.store');


    // All Delivery Boys table me Edit, Delete, Update.===

    Route::get('/admin/delivery-boys/{user}/edit', [DeliveryBoyController::class, 'edit'])
        ->name('admin.delivery-boys.edit');

    Route::put('/admin/delivery-boys/{user}', [DeliveryBoyController::class, 'update'])
        ->name('admin.delivery-boys.update');

    Route::delete('/admin/delivery-boys/{user}', [DeliveryBoyController::class, 'destroy'])
        ->name('admin.delivery-boys.destroy');

    // Delivery Boy Profile
    Route::get('/delivery-boy/profile', [
    \App\Http\Controllers\DeliveryBoyDashboardController::class,
    'profile'
    ])->middleware('auth')->name('delivery-boy.profile');

    Route::put('/delivery-boy/profile', [
    \App\Http\Controllers\DeliveryBoyDashboardController::class,
    'updateProfile'
    ])->middleware('auth')->name('delivery-boy.profile.update');

    // Delivery Boy Change Password
    Route::put('/delivery-boy/change-password', [
    \App\Http\Controllers\DeliveryBoyDashboardController::class,
    'updatePassword'
    ])->middleware('auth')->name('delivery-boy.password.update');


        //  Assign Orders in admin.==
        Route::get('/admin/assign-orders', [BookingController::class, 'assignOrders'])
        ->name('admin.assign-orders');

        Route::post('/admin/assign-orders/{id}', [BookingController::class, 'assignDeliveryBoy'])
        ->name('admin.assign-orders.store');



        Route::middleware('auth')->post('/save-fcm-token', function (Illuminate\Http\Request $request) {

    $request->validate([
        'token' => 'required|string',
    ]);

    $request->user()->update([
        'fcm_token' => $request->token,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'FCM token saved successfully',
    ]);
})->name('save.fcm-token');
 /*
    |--------------------------------------------------------------------------
    | AUTH ROUTES END
    |--------------------------------------------------------------------------
    */

});


require __DIR__.'/auth.php';
