<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\booking;
use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\User;
use App\Notifications\OrderStatusNotification;

class BookingController extends Controller
{
    public function create(Product $product){

    $quantity = request('quantity', 1);
        return view('booking.create', compact('product', 'quantity'));
    }

     public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity_ordered' => 'required|integer|min:1',
            'name' => 'required',
            'mobile' => 'required',
            'pincode' => 'required',
            'house_no' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'city' => 'required',
            'state' => 'required',
            'address_type' => 'required',

        ]);

        booking::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'selected_size' => $product->size,
            'quantity_ordered' => $request->quantity_ordered,

            'name' => $request->name,
            'mobile' => $request->mobile,
            'pincode' => $request->pincode,
            'house_no' => $request->house_no,
            'address' => $request->address,
            'locality' => $request->locality,
            'city' => $request->city,
            'state' => $request->state,
            'address_type' => $request->address_type,

            'status' => 'Pending',
        ]);
        return redirect()->route('booking.address', $product->id);
    }

    public function address(Product $product)
{
    $booking = booking::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->latest()
        ->first();

    return view('booking.address', compact('product', 'booking'));
}

    public function payment(Product $product){
        $bookings = booking::where('user_id', auth()->id())
            ->where('status', 'Pending')
            ->latest()
            ->get();

        return view('booking.payment', compact('bookings'));

    }

    public function placeOrder()
{
    $bookings = booking::where('user_id', auth()->id())
        ->where('status', 'Pending')
        ->get();

    if ($bookings->isEmpty()) {
        return redirect()->route('cart.index');
    }

    // Order ko Confirmed karo
    booking::where('user_id', auth()->id())
        ->where('status', 'Pending')
        ->update([
            'status' => 'Confirmed',
        ]);

    // Cart empty karo
    \App\Models\Cart::where('user_id', auth()->id())->delete();

    // Success page par wahi orders bhejo
    $bookings->each(function ($booking) {
        $booking->status = 'Confirmed';
    });

    return view('booking.success', compact('bookings'));
}

    // CART..

    public function storeCart(Request $request)
{
    $user = auth()->user();

    // Agar saved address select kiya hai
    if ($request->address_id) {

        $address = Address::where('id', $request->address_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

    } else {

        // New address ke liye validation
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'pincode' => 'required',
            'house_no' => 'required',
            'address' => 'required',
            'locality' => 'required',
            'city' => 'required',
            'state' => 'required',
            'address_type' => 'required',
        ]);

        // New address addresses table mein save hoga
        $address = Address::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'mobile' => $request->mobile,
            'pincode' => $request->pincode,
            'house_no' => $request->house_no,
            'address' => $request->address,
            'locality' => $request->locality,
            'city' => $request->city,
            'state' => $request->state,
            'address_type' => $request->address_type,
        ]);
    }

    // Cart ke saare products
    $carts = \App\Models\Cart::where('user_id', auth()->id())
        ->with('product')
        ->get();

    if ($carts->isEmpty()) {
        return redirect()->route('cart.index');
    }

     // Har cart product ke liye booking create hogi
    foreach ($carts as $cart) {

    $booking = booking::where('user_id', auth()->id())
        ->where('product_id', $cart->product_id)
        ->where('selected_size', $cart->size)
        ->where('status', 'Pending')
        ->first();

    if (!$booking) {

        booking::create([
            'user_id' => auth()->id(),
            'product_id' => $cart->product_id,
            'selected_size' => $cart->size,
            'quantity_ordered' => $cart->quantity,

            'name' => $address->name,
            'mobile' => $address->mobile,
            'pincode' => $address->pincode,
            'house_no' => $address->house_no,
            'address' => $address->address,
            'locality' => $address->locality,
            'city' => $address->city,
            'state' => $address->state,
            'address_type' => $address->address_type,

            'status' => 'Pending',
        ]);
    }
}
    return redirect()->route('booking.payment', $carts->first()->product_id);
}

// admin orders filter status.
public function orders(Request $request){
    $status = $request->status;
    $deliveryBoys = User::where('role', 'delivery_boy')
    ->orderBy('name')
    ->get();

    $orders = booking::with(['product', 'deliveryBoy'])
    ->when($status && $status != 'All', function ($query) use ($status){
        $query->where('status', $status);
    })
    ->latest()
    ->get();

    return view('admin.orders', compact('orders','status', 'deliveryBoys'));
}

// Admin Assign Orders page
public function assignOrders()
{
    abort_unless(auth()->user()?->role === 'admin', 403);

    $orders = booking::with(['product', 'deliveryBoy'])
        ->latest()
        ->get();

    $deliveryBoys = User::where('role', 'delivery_boy')
        ->orderBy('name')
        ->get();

    return view('admin.assign-orders', compact('orders', 'deliveryBoys'));
}

// Admin assigns delivery boy to an order
public function assignDeliveryBoy(Request $request, $id)
{
    abort_unless(auth()->user()?->role === 'admin', 403);

    $request->validate([
        'delivery_boy_id' => 'required|exists:users,id',
    ]);

    $order = booking::findOrFail($id);

    $deliveryBoy = User::where('id', $request->delivery_boy_id)
        ->where('role', 'delivery_boy')
        ->firstOrFail();

    // Customer aur delivery boy ka state match hona chahiye
    if (strcasecmp(trim($order->state), trim($deliveryBoy->state)) !== 0) {
        return back()->withErrors([
            'delivery_boy_id' => 'Delivery Boy customer ke state se match nahi karta.',
        ]);
    }

    $order->delivery_boy_id = $deliveryBoy->id;
    $order->save();

    return redirect()
        ->route('admin.assign-orders')
        ->with('success', 'Delivery Boy assigned successfully!');
}


  // admin status.====



public function updateStatus(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:Pending,Confirmed,Packed,Shipped,Out for Delivery,Delivered,Rejected,Out of Stock',
    ]);

    $order = booking::findOrFail($id);

    $oldStatus = $order->status;
    $newStatus = $request->status;

    // Agar status same hai toh notification nahi bhejna
    if ($oldStatus === $newStatus) {
        return redirect()
            ->route('admin.orders')
            ->with('success', 'Order status is already ' . $newStatus);
    }

    // Status ke according timestamp column
    $timestampColumn = match ($newStatus) {
        'Confirmed' => 'confirmed_at',
        'Packed' => 'packed_at',
        'Shipped' => 'shipped_at',
        'Out for Delivery' => 'out_for_delivery_at',
        'Delivered' => 'delivered_at',
        'Rejected' => 'rejected_at',
        'Out of Stock' => 'out_of_stock_at',
        default => null,
    };

    if ($timestampColumn && is_null($order->{$timestampColumn})) {
        $order->{$timestampColumn} = now();
    }

    // Order status update
    $order->status = $newStatus;
    $order->save();

    // Customer find karo
    $customer = User::find($order->user_id);

    if ($customer) {

        // Notification object banao
        $notification = new OrderStatusNotification(
            $order->id,
            $newStatus
        );

        // Check karo ki is order ki notification pehle se hai ya nahi
        $existingNotification = $customer->notifications()
            ->where('type', OrderStatusNotification::class)
            ->where('data->booking_id', $order->id)
            ->first();

        if ($existingNotification) {

            // Purani notification ko update karo
            $existingNotification->update([
                'data' => $notification->toDatabase($customer),
                'read_at' => null,
                'updated_at' => now(),
            ]);

        } else {

            // Notification nahi hai toh nayi create karo
            $customer->notify($notification);
        }
    }

    return redirect()
        ->route('admin.orders')
        ->with('success', 'Order status updated successfully!');
}

// MY ACCOUNT SECTION KA MYORDER BUTTON>===

public function myOrders()
{
    $orders = booking::where('user_id', auth()->id())
        ->with('product')
        ->latest()
        ->get();

    return view('my-orders', compact('orders'));
}

// track orders.===
public function trackOrder($id)
{
    $order = booking::where('id', $id)
        ->where('user_id', auth()->id())
        ->with('product')
        ->firstOrFail();

    return view('track-order', compact('order'));
}
}
