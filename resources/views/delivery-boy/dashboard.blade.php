@extends('layouts.delivery-boy')

@section('title', 'Delivery Boy Dashboard')
@section('header', 'Dashboard')

@section('content')

<div style="padding:10px 0;">

    <h2 style="margin-bottom:8px;">
        Welcome, {{ auth()->user()->name }}!
    </h2>

    <p style="color:#666; margin-bottom:25px;">
        Manage your assigned orders and delivery activities here.
    </p>

    {{-- Dashboard Cards --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
        gap:20px;
        margin-bottom:30px;
    ">

        {{-- Total Orders --}}
        <a href="{{ route('delivery-boy.my-orders') }}"
        style="
            background:white;
            padding:24px;
            border-radius:10px;
            border-left:5px solid #1677ff;
            box-shadow:0 2px 8px rgba(0,0,0,0.06);
            display: block;
            text-decoration: none;
            color: inherit;
        ">
            <div style="font-size:15px; color:#666;">
                Total Orders
            </div>

            <h2 style="font-size:30px; margin:12px 0; color:#1677ff;">
                {{ $totalOrders }}
            </h2>

            <p style="color:#777; margin:0;">
                Orders assigned to you
            </p>
        </a>

        {{-- Completed Deliveries --}}
        <a href="{{ route('delivery-boy.completed-orders') }}"
        style="
            background:white;
            padding:24px;
            border-radius:10px;
            border-left:5px solid #16a34a;
            box-shadow:0 2px 8px rgba(0,0,0,0.06);
            display: block;
            text-decoration: none;
            color: inherit;
        ">
            <div style="font-size:15px; color:#666;">
                Completed Deliveries
            </div>

            <h2 style="font-size:30px; margin:12px 0; color:#16a34a;">
                {{ $completedOrders }}
            </h2>

            <p style="color:#777; margin:0;">
                Successfully delivered orders
            </p>
        </a>

        {{-- Pending Deliveries --}}
        <a href="{{ route('delivery-boy.assigned-deliveries') }}"
        style="
            background:white;
            padding:24px;
            border-radius:10px;
            border-left:5px solid #f59e0b;
            box-shadow:0 2px 8px rgba(0,0,0,0.06);
            display: block;
            text-decoration: none;
            color: inherit;
        ">
            <div style="font-size:15px; color:#666;">
                Pending Deliveries
            </div>

            <h2 style="font-size:30px; margin:12px 0; color:#f59e0b;">
                {{ $pendingOrders }}
            </h2>

            <p style="color:#777; margin:0;">
                Deliveries still in progress
            </p>
        </a>

    </div>

    {{-- Recent Orders Section --}}
    <div style="
        background:white;
        padding:24px;
        border-radius:10px;
        box-shadow:0 2px 8px rgba(0,0,0,0.06);
    ">

        <h3 style="margin:0 0 10px;">
            My Assigned Orders
        </h3>


@if($orders->isEmpty())

    <p style="color:#777; margin:0;">
        No orders assigned to you yet.
    </p>

@else

    <div style="overflow-x:auto; margin-top:15px;">
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:#f5f7fa; text-align:left;">
                    <th style="padding:12px;">Order ID</th>
                    <th style="padding:12px;">Product</th>
                    <th style="padding:12px;">Quantity</th>
                    <th style="padding:12px;">State</th>
                    <th style="padding:12px;">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach($orders as $order)
                    <tr style="border-bottom:1px solid #eee;">
                        <td style="padding:12px;">
                            #{{ $order->id }}
                        </td>

                        <td style="padding:12px;">
                            {{ $order->product->product_name ?? 'Product unavailable' }}
                        </td>

                        <td style="padding:12px; ">
                            {{ $order->quantity_ordered }}
                        </td>

                        <td style="padding:12px;">
                            {{ $order->state ?? '—' }}
                        </td>

                        <td style="padding:12px;">
                            {{ $order->status }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endif


    </div>

</div>

@endsection

