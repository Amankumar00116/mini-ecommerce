<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Address;

class CartController extends Controller
{
   public function addToCart(Request $request, Product $product)
{
    // Validate product details
    $request->validate([
        'quantity' => 'required|integer|min:1|max:' . $product->quantity,
        'size' => 'required|string|max:50',
    ]);

    // If customer is not logged in
    if (!auth()->check()) {

        session()->put('pending_cart_product', [
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'size' => $request->size,

            'return_url' => url()->previous(),
        ]);

        return redirect()->route('login');
    }

    // Check existing cart
    $cart = Cart::where('user_id', auth()->id())
        ->where('product_id', $product->id)
        ->where('size', $request->size)
        ->first();

    if ($cart) {

        $cart->update([
            'quantity' => $cart->quantity + $request->quantity,
        ]);

    } else {

        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'size' => $request->size,
        ]);
    }

    return redirect()->back()->with('success', 'Product added to cart!');
}

    public function index()
    {
        $carts = Cart::where('user_id', auth()->id())
            ->with('product')
            ->get();

        return view('cart.index', compact('carts'));
    }


    // updateQuantity.================
    public function updateQuantity(Request $request, Cart $cart)
    {
        if ($request->has('size')) {

            $request->validate([
                'size' => 'required|string|max:50',
            ]);

            $cart->update([
                'size' => $request->size,
            ]);

        } elseif ($request->has('quantity')) {

            $request->validate([
                'quantity' => 'required|integer|min:1|max:' . $cart->product->quantity,
            ]);

            $cart->update([
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index');
    }

public function remove(Request $request, Cart $cart)
{
    $cart->delete();

    return redirect()->route('cart.index');
}

public function checkout()
{
    $carts = Cart::where('user_id', auth()->id())
        ->with('product')
        ->get();

    if ($carts->isEmpty()) {
        return redirect()->route('cart.index');
    }

    $user = auth()->user();

    $addresses = $user->addresses;

    return view('booking.create', compact('carts','user','addresses'));
}

public function deleteAddress(Address $address)
{
    if ($address->user_id != auth()->id()) {
        abort(403);
    }

    $address->delete();

    return back()->with('success', 'Address deleted successfully.');
}

// EDIT ADDRESS IN Checkout.
public function editAddress(Address $address)
{
    if ($address->user_id != auth()->id()) {
        abort(403);
    }

    return view('address.edit', compact('address'));
}

public function updateAddress(Request $request, Address $address)
{
    if ($address->user_id != auth()->id()) {
        abort(403);
    }

    $request->validate([
        'name' => 'required',
        'mobile' => 'required|digits:10',
        'pincode' => 'required',
        'house_no' => 'required',
        'address' => 'required',
        'locality' => 'required',
        'city' => 'required',
        'state' => 'required',
        'address_type' => 'required',
    ]);

    $address->update($request->only([
        'name',
        'mobile',
        'pincode',
        'house_no',
        'address',
        'locality',
        'city',
        'state',
        'address_type',
    ]));

    return redirect()->back()->with('success', 'Address updated successfully!');
}

public function storeAddress(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'mobile' => 'required|digits:10',
        'pincode' => 'required|digits:6',
        'house_no' => 'required|string|max:255',
        'address' => 'required|string',
        'locality' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'address_type' => 'required|in:Home,Work,Other',
    ]);

    Address::create([
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

    return redirect()->route('cart.checkout')
        ->with('success', 'Address saved successfully!');
}
}
