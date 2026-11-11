
@extends('layouts.admin')

@section('title', 'Orders')

@section('header')
    <h2 style="font-size:24px; font-weight:bold; margin:0;">
        Orders
    </h2>
@endsection

@section('content')

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div id="success-message"
             style="position:fixed; top:20px; right:20px; background:#198754; color:white; padding:12px 20px; border-radius:6px; box-shadow:0 3px 10px rgba(0,0,0,0.2); z-index:9999;">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                const message = document.getElementById('success-message');
                if (message) {
                    message.remove();
                }
            }, 2500);
        </script>
    @endif

    {{-- ORDERS CONTENT --}}
    <div style="background:white; padding:25px; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.08); overflow-x:auto;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; gap:20px; flex-wrap:wrap;">

            <h3 style="font-size:22px; font-weight:bold; margin:0;">
                All Orders
            </h3>

            {{-- ORDER STATUS FILTER --}}
            <form action="{{ route('admin.orders') }}" method="GET">
                <select name="status"
                        onchange="this.form.submit()"
                        style="padding:10px 14px; border:1px solid #ccc; border-radius:6px; font-size:15px; min-width:190px; background:white; cursor:pointer;">

                    <option value="All" {{ ($status ?? 'All') == 'All' ? 'selected' : '' }}>All Orders</option>
                    <option value="Pending" {{ ($status ?? '') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="Confirmed" {{ ($status ?? '') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Packed" {{ ($status ?? '') == 'Packed' ? 'selected' : '' }}>Packed</option>
                    <option value="Shipped" {{ ($status ?? '') == 'Shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="Out for Delivery" {{ ($status ?? '') == 'Out for Delivery' ? 'selected' : '' }}>Out for Delivery</option>
                    <option value="Delivered" {{ ($status ?? '') == 'Delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="Rejected" {{ ($status ?? '') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="Out of Stock" {{ ($status ?? '') == 'Out of Stock' ? 'selected' : '' }}>Out of Stock</option>

                </select>
            </form>
        </div>

        {{-- ORDERS TABLE --}}
        <table style="width:100%; border-collapse:collapse; min-width:1200px;">

            <thead>
                <tr style="background:#172337; color:white;">
                    <th style="padding:12px; text-align:left;">Order ID</th>
                    <th style="padding:12px; text-align:left;">Customer</th>
                    <th style="padding:12px; text-align:left;">Mobile</th>
                    <th style="padding:12px; text-align:left;">Product</th>
                    <th style="padding:12px; text-align:center;">Size</th>
                    <th style="padding:12px; text-align:center;">Qty</th>
                    <th style="padding:12px; text-align:left;">Address</th>
                    <th style="padding:12px; text-align:right;">Price</th>
                    <th style="padding:12px; text-align:center;">Status</th>
                    <th style="padding:12px; text-align:center;">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($orders as $order)
                    <tr style="border-bottom:1px solid #ddd;">

                        <td style="padding:12px;">
                            #{{ $order->id }}
                        </td>

                        <td style="padding:12px;">
                            {{ $order->name }}
                        </td>

                        <td style="padding:12px;">
                            {{ $order->mobile }}
                        </td>

                        {{-- PRODUCT --}}
                        <td style="padding:12px;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                <img src="{{ asset('storage/' . $order->product->image) }}"
                                     alt="{{ $order->product->product_name }}"
                                     style="width:60px; height:60px; object-fit:cover; border-radius:6px; border:1px solid #ddd;">

                                <span>{{ $order->product->product_name }}</span>
                            </div>
                        </td>

                        <td style="padding:12px; text-align:center;">
                            {{ $order->selected_size }}
                        </td>

                        <td style="padding:12px; text-align:center;">
                            {{ $order->quantity_ordered }}
                        </td>

                        {{-- ADDRESS --}}
                        <td style="padding:12px; line-height:1.6; max-width:300px;">
                            {{ $order->house_no }},
                            {{ $order->address }},
                            {{ $order->locality }}<br>

                            {{ $order->city }},
                            {{ $order->state }} -
                            {{ $order->pincode }}<br>

                            <small>{{ $order->address_type }}</small>
                        </td>

                        {{-- PRICE --}}
                        <td style="padding:12px; text-align:right;">
                            ₹{{ number_format((float) $order->product->price * (int) $order->quantity_ordered, 2) }}
                        </td>

                        {{-- STATUS --}}
                        <td style="padding:12px; text-align:center;">
                            <span style="background:#fff3cd; color:#856404; padding:5px 10px; border-radius:5px; font-size:13px;">
                                {{ $order->status }}
                            </span>
                        </td>

                        {{-- STATUS ACTIONS --}}
                        <td style="padding:12px; text-align:center; white-space:nowrap;">

                            @php
                                $orderStatuses = [
                                    'Confirmed' => ['Confirm', '#198754', '#fff'],
                                    'Packed' => ['Packed', '#0d6efd', '#fff'],
                                    'Shipped' => ['Shipped', '#6f42c1', '#fff'],
                                    'Out for Delivery' => ['Out for Delivery', '#fd7e14', '#fff'],
                                    'Delivered' => ['Delivered', '#20c997', '#fff'],
                                    'Rejected' => ['Reject', '#dc3545', '#fff'],
                                    'Out of Stock' => ['Out of Stock', '#ffc107', '#000'],
                                ];
                            @endphp

                            @foreach($orderStatuses as $statusValue => $button)
                                <form action="{{ route('admin.orders.status', $order->id) }}"
                                      method="POST"
                                      style="display:inline;">
                                    @csrf

                                    <input type="hidden" name="status" value="{{ $statusValue }}">

                                    <button type="submit"
                                            style="background:{{ $button[1] }}; color:{{ $button[2] }}; border:none; padding:7px 12px; border-radius:5px; margin:2px; cursor:pointer;">
                                        {{ $button[0] }}
                                    </button>
                                </form>
                            @endforeach

                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="10" style="padding:30px; text-align:center; color:#777;">
                            No orders found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

@endsection
