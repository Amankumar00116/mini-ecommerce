<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DeliveryBoyController extends Controller
{
    // Delivery Boys ki list
    public function index()
    {
        abort_unless(auth()->user()?->role == 'admin', 403);

        $deliveryBoys = User::where('role', 'delivery_boy')
            ->latest()
            ->get();

            // Total Delivery Boys.==
            $totalDeliveryBoys = User::where('role', 'delivery_boy')
            ->count();

            // How many states cover.==
            $totalStates = User::where('role', 'delivery_boy')
            ->whereNotNull('state')
            ->where('state', '!=', '')
            ->distinct()
            ->count('state');

            $totalDistricts = User::where('role', 'delivery_boy')
            ->whereNotNull('district')
            ->where('district', '!=', '')
            ->distinct()
            ->count('district');

            $totalCities = User::where('role', 'delivery_boy')
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->count('city');

        return view('admin.delivery-boys', compact('deliveryBoys', 'totalDeliveryBoys', 'totalStates', 'totalDistricts', 'totalCities'));
    }

    // Naya Delivery Boy create karna
    public function store(Request $request)
    {
        abort_unless(auth()->user()?->role== 'admin', 403);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|string|max:20',
            'state' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'password' => 'required|string|min:8',

        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'state' => $request->state,
            'district' => $request->district,
            'city' => $request->city,
            'password' => Hash::make($request->password),
            'role' => 'delivery_boy',
        ]);

        return redirect()
            ->route('admin.delivery-boys.index')
            ->with('success', 'Delivery Boy created successfully.');
    }


public function edit(User $user)
{
    abort_unless(auth()->user()?->role === 'admin', 403);
    abort_unless($user->role === 'delivery_boy', 404);

    return view('admin.edit-delivery-boy', compact('user'));
}

public function update(Request $request, User $user)
{
    abort_unless(auth()->user()?->role === 'admin', 403);
    abort_unless($user->role === 'delivery_boy', 404);

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'mobile' => 'required|string|max:20',
        'state' => 'required|string|max:100',
        'district' => 'required|string|max:100',
        'city' => 'required|string|max:100',
    ]);

    $user->update($request->only([
        'name', 'email', 'mobile', 'state','district', 'city'
    ]));

    return redirect()
        ->route('admin.delivery-boys.index')
        ->with('success', 'Delivery Boy updated successfully.');
}

public function destroy(User $user)
{
    abort_unless(auth()->user()?->role === 'admin', 403);
    abort_unless($user->role === 'delivery_boy', 404);

    $user->delete();

    return redirect()
        ->route('admin.delivery-boys.index')
        ->with('success', 'Delivery Boy deleted successfully.');
}

}
