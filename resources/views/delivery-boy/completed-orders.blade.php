@extends('layouts.delivery-boy')

@section('content')

    <style>
        .completed-page {
            padding: 25px;
            background: #f5f7fb;
            min-height: 100vh;
        }

        .completed-header {
            margin-bottom: 25px;
        }

        .completed-header h2 {
            font-size: 26px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .completed-header p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }

        .completed-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 22px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8edf4;
        }

        .completed-card h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .completed-table {
            width: 100%;
            border-collapse: collapse;
            white-space: nowrap;
        }

        .completed-table thead {
            background: #f1f5f9;
        }

        .completed-table th {
            padding: 15px;
            text-align: left;
            color: #475569;
            font-size: 13px;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
        }

        .completed-table td {
            padding: 16px 15px;
            color: #334155;
            font-size: 14px;
            border-bottom: 1px solid #edf0f5;
        }

        .completed-table tbody tr:hover {
            background: #f8fafc;
        }

        .order-id {
            font-weight: 600;
            color: #2563eb;
        }

        .delivered-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            background: #dcfce7;
            color: #15803d;
            font-size: 12px;
            font-weight: 600;
        }

        .empty-orders {
            text-align: center;
            padding: 45px 15px;
            color: #64748b;
        }

        .empty-orders h4 {
            color: #334155;
            margin-bottom: 8px;
            font-size: 17px;
        }

        .empty-orders p {
            font-size: 14px;
            margin: 0;
        }

        @media (max-width: 768px) {
            .completed-page {
                padding: 15px;
            }

            .completed-card {
                padding: 15px;
            }

            .completed-header h2 {
                font-size: 22px;
            }
        }
    </style>

    <div class="completed-page">

        <div class="completed-header">
            <h2>Completed Orders</h2>
            <p>View all orders successfully delivered by you.</p>
        </div>

        <div class="completed-card">
            <h3>Delivered orders</h3>

            @if ($orders->isEmpty())
                <div class="empty-orders">
                    <h4>No completed Orders</h4>
                    <p>Your delivered orders will appear here.</p>
                </div>
            @else
                <div style="overflow-x: auto">

                    <table class="completed-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th>Full Address</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="order-id">
                                        #{{ $order->id }}
                                    </td>

                                    <td>
                                        {{ $order->product->product_name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $order->quantity_ordered }}
                                    </td>

                                    <td>
                                        {{ $order->selected_size ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $order->name ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $order->mobile ?? 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $order->house_no }},
                                        {{ $order->address }},
                                        {{ $order->locality }},
                                        {{ $order->city }},
                                        {{ $order->state }} - {{ $order->pincode }}
                                        <br>
                                        <small>Address Type: {{ $order->address_type ?? 'N/A' }}</small>
                                    </td>

                                    <td>
                                        <span class="delivered-badge">
                                            {{ $order->status }}
                                        </span>
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
