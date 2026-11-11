<?php

namespace App\Http\Controllers;

use App\Models\booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeliveryBoyDashboardController extends Controller
{
    public function index()
{
    // Logged-in delivery boy ki ID
    $deliveryBoyId = auth()->id();

    // Dashboard par sirf latest 5 orders
    $orders = booking::with('product')
        ->where('delivery_boy_id', $deliveryBoyId)
        ->latest()
        ->take(5)
        ->get();

    // Saare assigned orders ki count
    $totalOrders = booking::where('delivery_boy_id', $deliveryBoyId)
        ->count();

    // Saare completed orders ki count
    $completedOrders = booking::where('delivery_boy_id', $deliveryBoyId)
        ->where('status', 'Delivered')
        ->count();

    // Saare pending / in-progress orders ki count
    $pendingOrders = booking::where('delivery_boy_id', $deliveryBoyId)
        ->where('status', '!=', 'Delivered')
        ->count();

    return view('delivery-boy.dashboard', compact(
        'orders',
        'totalOrders',
        'completedOrders',
        'pendingOrders'
    ));
}

    public function myOrders()
{
    abort_unless(
        auth()->user()?->role === 'delivery_boy',
        403
    );

    $orders = \App\Models\booking::with('product')
        ->where('delivery_boy_id', auth()->id())
        ->latest()
        ->get();

    return view('delivery-boy.my-orders', compact('orders'));
}


public function assignedDeliveries()
{
    abort_unless(
        auth()->user()?->role === 'delivery_boy',
        403
    );

    $orders = \App\Models\booking::with('product')
        ->where('delivery_boy_id', auth()->id())
        ->where('status', '!=', 'Delivered')
        ->latest()
        ->get();

    return view('delivery-boy.assigned-deliveries', compact('orders'));
}


public function markDelivered($id)
{
    abort_unless(
        auth()->user()?->role === 'delivery_boy',
        403
    );

    $order = \App\Models\booking::where('id', $id)
        ->where('delivery_boy_id', auth()->id())
        ->firstOrFail();

    // Already delivered order ko dobara update na karo
    if ($order->status === 'Delivered') {
        return redirect()
            ->route('delivery-boy.assigned-deliveries')
            ->with('success', 'This order is already delivered.');
    }

    $order->status = 'Delivered';
    $order->save();

    return redirect()
        ->route('delivery-boy.assigned-deliveries')
        ->with('success', 'Order marked as delivered successfully.');
}

// delivery boys completed orders.=

public function completedOrders(){
    $orders = booking::where('delivery_boy_id', auth()->id())
    ->where('status', 'Delivered')
    ->with('product')
    ->latest()
    ->get();

    return view('delivery-boy.completed-orders', compact('orders'));
}

// Delivery Boy Profile
public function profile()
{
    abort_unless(
        auth()->user()?->role === 'delivery_boy',
        403
    );

    $user = auth()->user();

    return view('delivery-boy.profile', compact('user'));
}


// Update Delivery Boy Profile
public function updateProfile(Request $request)
{
    abort_unless(
        auth()->user()?->role === 'delivery_boy',
        403
    );

    $user = auth()->user();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'mobile' => 'nullable|string|max:15',
        'address' => 'nullable|string|max:1000',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'pincode' => 'nullable|string|max:10',
    ]);

    $user->update($validated);

    return redirect()
        ->route('delivery-boy.profile')
        ->with('success', 'Profile updated successfully.');
}

// Change Delivery Boy Password
public function updatePassword(Request $request)
{
    abort_unless(
        auth()->user()?->role === 'delivery_boy',
        403
    );

    $request->validate([
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = auth()->user();

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()
        ->route('delivery-boy.profile')
        ->with('password_success', 'Password changed successfully.');
}

}
