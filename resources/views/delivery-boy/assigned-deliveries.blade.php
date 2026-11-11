@extends('layouts.delivery-boy')

@section('title', 'Assigned Deliveries')
@section('header', 'Assigned Deliveries')

@section('content')

    <div style="background:white; padding:24px; border-radius:10px; box-shadow:0 2px 8px rgba(0,0,0,0.06);">

        <h2 style="margin:0 0 8px;">Assigned Deliveries</h2>

        <p style="color:#666; margin-bottom:20px;">
            Orders waiting to be delivered.
        </p>

        @if ($orders->isEmpty())

            <p style="color:#777;">No pending deliveries.</p>
        @else
            <div style="overflow-x:auto;">
                <table style="width:100%; border-collapse:collapse;">
                    <thead>
                        <tr style="background:#f5f7fa; text-align:left;">
                            <th style="padding:12px;">Order ID</th>
                            <th style="padding:12px;">Product</th>
                            <th style="padding:12px;">Quantity</th>
                            <th style="padding:12px;">Name</th>
                            <th style="padding:12px;">Mobile</th>
                            <th style="padding:12px;">Address</th>
                            <th style="padding:12px;">Status</th>
                            <th style="padding:12px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $order)
                            <tr style="border-bottom:1px solid #eee;">

                                <td style="padding:12px;">
                                    #{{ $order->id }}
                                </td>

                                <td style="padding:12px;">
                                    {{ $order->product->product_name ?? 'Product unavailable' }}
                                </td>

                                <td style="padding:12px;">
                                    {{ $order->quantity_ordered }}
                                </td>

                                <td style="padding:12px;">{{ $order->name ?? 'N/A' }}</td>
                                <td style="padding:12px;">{{ $order->mobile ?? 'N/A' }}</td>
                                <td style="padding:12px;">
                                    {{ $order->house_no }},
                                    {{ $order->address }},
                                    {{ $order->locality }},
                                    {{ $order->city }},
                                    {{ $order->state }} - {{ $order->pincode }}
                                </td>

                                <td style="padding:12px;">
                                    {{ $order->status }}
                                </td>


                                <td style="padding:12px;">
                                    <form method="POST" action="{{ route('delivery-boy.mark-delivered', $order->id) }}"
                                        onsubmit="return confirm('Are you sure this order has been delivered?');">

                                        @csrf

                                        <button type="submit"
                                            style="background:#16a34a; color:white; border:none; padding:9px 13px; border-radius:5px; cursor:pointer; white-space:nowrap;">
                                            Mark as Delivered
                                        </button>

                                    </form>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>

@endsection
