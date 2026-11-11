@extends('layouts.admin')

@section('title', 'Assign Orders')

@section('header')
    <h2 style="font-size:24px; font-weight:bold; margin:0;">
        Assign Orders
    </h2>
@endsection

@section('content')

    <div
        style="background:white; padding:25px; border-radius:8px;
            box-shadow:0 2px 8px rgba(0,0,0,0.08); overflow-x:auto;">

        <div
            style="display:flex; justify-content:space-between;
                align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:20px;">
            <h3 style="font-size:21px; margin:0;">Assign Orders to Delivery Boys</h3>

            <span style="background:#e7f1ff; color:#0d6efd;
                     padding:8px 12px; border-radius:6px;">
                Total Orders: {{ $orders->count() }}
            </span>
        </div>

        @if (session('success'))
            <div
                style="background:#d1e7dd; color:#0f5132;
                    padding:12px; border-radius:6px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div
                style="background:#f8d7da; color:#842029;
                    padding:12px; border-radius:6px; margin-bottom:15px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <table style="width:100%; border-collapse:collapse; min-width:1000px;">
            <thead>
                <tr style="background:#172337; color:white;">
                    <th style="padding:12px; text-align:left;">Order ID</th>
                    <th style="padding:12px; text-align:left;">Customer</th>
                    <th style="padding:12px; text-align:left;">Product</th>
                    <th style="padding:12px; text-align:left;">State</th>
                    <th style="padding:12px; text-align:center;">Status</th>
                    <th style="padding:12px; text-align:left;">Delivery Boy</th>
                    <th style="padding:12px; text-align:center;">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr style="border-bottom:1px solid #ddd;">
                        <td style="padding:12px;">#{{ $order->id }}</td>

                        <td style="padding:12px;">
                            {{ $order->name }}
                            <br>
                            <small>{{ $order->mobile }}</small>
                        </td>

                        <td style="padding:12px;">
                            {{ $order->product?->product_name ?? 'Product unavailable' }}
                        </td>

                        <td style="padding:12px; text-align:center;">
                            {{ $order->state }}
                        </td>

                        <td style="padding:12px; text-align:center;">
                            {{ $order->status }}
                        </td>

                        <td style="padding:12px;">
                            {{ $order->deliveryBoy?->name ?? 'Not assigned' }}
                        </td>

                        <td style="padding:12px; text-align:center;">
                            <form action="{{ route('admin.assign-orders.store', $order->id) }}" method="POST">
                                @csrf

                                <select name="delivery_boy_id" required
                                    style="padding:8px; border:1px solid #ccc;
                                           border-radius:5px; max-width:180px;">
                                    <option value="">Select Delivery Boy</option>

                                    @foreach ($deliveryBoys->where('state', $order->state) as $boy)
                                        <option value="{{ $boy->id }}"
                                            {{ $order->delivery_boy_id == $boy->id ? 'selected' : '' }}>
                                            {{ $boy->name }}
                                        </option>
                                    @endforeach
                                </select>

                                <button type="submit"
                                    style="background:#1677ff; color:white;
                                           border:none; padding:8px 12px;
                                           border-radius:5px; cursor:pointer; margin-top:5px;">
                                    Assign
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding:30px; text-align:center; color:#777;">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
