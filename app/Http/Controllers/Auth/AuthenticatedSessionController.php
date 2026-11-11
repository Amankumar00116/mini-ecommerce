<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Models\Cart;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {

    $user = User::create([
        'name' => explode('@', $request->email)[0],
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'customer',
    ]);
        Auth::login($user);
    } else{

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors([
            'email' => 'Email or password is incorrect.',
        ]);
    }

    Auth::login($user);
    }

    $request->session()->regenerate();

    // Admin Dashboard
    if ($user->role === 'admin') {
        return redirect('/dashboard');
    }

     // Delivery Boy Dashboard
    if ($user->role === 'delivery_boy') {
        return redirect('/delivery-boy/dashboard');
    }

    // Add Pending Product to Cart After Login
if ($user->role === 'customer' && $request->session()->has('pending_cart_product')) {

    $pendingCart = $request->session()->pull('pending_cart_product');

    $cart = Cart::where('user_id', $user->id)
        ->where('product_id', $pendingCart['product_id'])
        ->where('size', $pendingCart['size'])
        ->first();

    if ($cart) {

        $cart->update([
            'quantity' => $cart->quantity + $pendingCart['quantity'],
        ]);

    } else {

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $pendingCart['product_id'],
            'quantity' => $pendingCart['quantity'],
            'size' => $pendingCart['size'],
        ]);
    }

    // First-time notification popup
    if (!$user->notification_prompt_shown) {

        $user->update([
            'notification_prompt_shown' => true,
        ]);

        return redirect($pendingCart['return_url'] ?? '/')
            ->with('show_notification_prompt', true);
    }

    return redirect($pendingCart['return_url'] ?? '/')
        ->with('success', 'Product added to cart!');
}

    // Customer First-Time Notification Popup
if ($user->role === 'customer' && !$user->notification_prompt_shown) {

    // Popup ko sirf ek baar dikhane ke liye status update
    $user->update([
        'notification_prompt_shown' => true,
    ]);

    return redirect()->intended('/')
        ->with('show_notification_prompt', true);
}

return redirect()->intended('/');
}

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
