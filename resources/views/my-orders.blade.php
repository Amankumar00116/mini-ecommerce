@extends('layouts.app')

@section('title', 'My Orders')

@section('content')

<div class="orders-page-wrapper">

    <div class="orders-container">

        <!-- Back Link -->
        <a href="{{ route('my.account') }}" class="back-link">
            ← Back to My Account
        </a>

        <!-- Page Header -->
        <div class="orders-header-flex">
            <h2 class="orders-main-title">My Orders</h2>
            <span class="orders-count-badge">{{ $orders->count() }} {{ $orders->count() == 1 ? 'Order' : 'Orders' }}</span>
        </div>

        @if($orders->count() > 0)

            <div class="orders-list">
                @foreach($orders as $order)

                    <div class="order-card-box">

                        <!-- Card Header: Order ID & Date -->
                        <div class="order-card-top-row">
                            <span class="order-id-text">Order ID: <strong>#{{ $order->id }}</strong></span>

                            <!-- Status Badge inside Header -->
                            @if($order->status == 'Pending')
                                <span class="status-badge badge-pending">Pending</span>
                            @elseif($order->status == 'Confirmed')
                                <span class="status-badge badge-confirmed">Confirmed</span>
                            @elseif($order->status == 'Packed')
                                <span class="status-badge badge-packed">Packed</span>
                            @elseif($order->status == 'Shipped')
                                <span class="status-badge badge-shipped">Shipped</span>
                            @elseif($order->status == 'Out for Delivery')
                                <span class="status-badge badge-out-delivery">Out for Delivery</span>
                            @elseif($order->status == 'Delivered')
                                <span class="status-badge badge-delivered">Delivered</span>
                            @elseif($order->status == 'Rejected')
                                <span class="status-badge badge-rejected">Rejected</span>
                            @elseif($order->status == 'Out of Stock')
                                <span class="status-badge badge-stock">Out of Stock</span>
                            @endif
                        </div>

                        <hr class="order-divider">

                        <!-- Main Product Content -->
                        <div class="order-item-content">
                            @if($order->product->image)
                                <img src="{{ asset('storage/' . $order->product->image) }}"
                                     alt="{{ $order->product->product_name }}"
                                     class="order-prod-img">
                            @else
                                <div class="order-prod-placeholder"></div>
                            @endif

                            <div class="order-prod-info">
                                <h4 class="order-prod-name">
                                    {{ $order->product->product_name }}
                                </h4>

                                <div class="order-meta-specs">
                                    <p>Size: <strong>{{ $order->selected_size }}</strong></p>
                                    <p>Qty: <strong>{{ $order->quantity_ordered }}</strong></p>
                                </div>

                                <p class="order-total-price">
                                    Total Amount: <strong class="text-teal">₹{{ $order->product->price * $order->quantity_ordered }}</strong>
                                </p>
                            </div>
                        </div>

                        <hr class="order-divider">

                        <!-- Bottom Footer: Action Button -->
                        <div class="order-footer-row">
                            <div class="order-delivery-hint">
                                <i class="bi bi-shield-check text-teal"></i> <span>Securely processed by MyShop</span>
                            </div>

                            <a href="{{ route('order.track', $order->id) }}" class="btn-track-order">
                                <i class="bi bi-truck me-1"></i> Track Order
                            </a>
                        </div>

                    </div>

                @endforeach
            </div>

        @else

            <!-- Empty Orders State -->
            <div class="empty-orders-card">
                <div class="empty-icon-box">
                    <i class="bi bi-box-seam"></i>
                </div>
                <h4 class="empty-title">No Orders Yet</h4>
                <p class="empty-desc">You haven't placed any orders yet. Let's explore our latest fashion collection!</p>
                <a href="{{ url('/#products') }}" class="btn-shop-continue">
                    Continue Shopping
                </a>
            </div>

        @endif

    </div>

</div>


<!-- STYLING -->
<style>
    .orders-page-wrapper {
        background: #f8f9fa;
        min-height: 85vh;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .orders-container {
        max-width: 850px;
        margin: auto;
    }

    .back-link {
        display: inline-block;
        color: #00796b;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 16px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #005b50;
        text-decoration: underline;
    }

    .orders-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .orders-main-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .orders-count-badge {
        background: #e6f4f1;
        color: #00796b;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
    }

    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Order Card Box */
    .order-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 24px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .order-card-box:hover {
        box-shadow: 0 6px 22px rgba(0, 0, 0, 0.06);
    }

    .order-card-top-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-id-text {
        font-size: 14px;
        color: #718096;
    }

    .order-id-text strong {
        color: #1a202c;
    }

    .order-item-content {
        display: flex;
        gap: 24px;
        align-items: center;
    }

    .order-prod-img {
        width: 100px;
        height: 115px;
        object-fit: cover;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .order-prod-placeholder {
        width: 100px;
        height: 115px;
        background: #edf2f7;
        border-radius: 10px;
    }

    .order-prod-info {
        flex: 1;
    }

    .order-prod-name {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin: 0 0 8px 0;
    }

    .order-meta-specs {
        display: flex;
        gap: 20px;
        margin-bottom: 8px;
    }

    .order-meta-specs p {
        font-size: 13px;
        color: #718096;
        margin: 0;
    }

    .order-meta-specs strong {
        color: #2d3748;
    }

    .order-total-price {
        font-size: 15px;
        color: #4a5568;
        margin: 0;
    }

    .text-teal {
        color: #00796b;
        font-weight: 700;
        font-size: 17px;
    }

    .order-divider {
        border: none;
        border-top: 1px solid #edf2f7;
        margin: 16px 0;
    }

    /* Footer Row */
    .order-footer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-delivery-hint {
        font-size: 13px;
        color: #718096;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Status Badges */
    .status-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .badge-pending { background: #feebc8; color: #744210; }
    .badge-confirmed { background: #e6f4f1; color: #00796b; }
    .badge-packed { background: #ebf8ff; color: #2b6cb0; }
    .badge-shipped { background: #edf2f7; color: #2d3748; }
    .badge-out-delivery { background: #fefcbf; color: #744210; }
    .badge-delivered { background: #def7ec; color: #03543f; }
    .badge-rejected { background: #fde8e8; color: #9b1c1c; }
    .badge-stock { background: #edf2f7; color: #4a5568; }

    /* Track Order Button */
    .btn-track-order {
        padding: 9px 20px;
        background: #00796b;
        color: white;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.1s ease;
        box-shadow: 0 2px 8px rgba(0, 121, 107, 0.2);
    }

    .btn-track-order:hover {
        background: #005b50;
        color: white;
        transform: translateY(-1px);
    }

    /* Empty State Card */
    .empty-orders-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        text-align: center;
        padding: 60px 20px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .empty-icon-box {
        font-size: 45px;
        color: #00796b;
        background: #e6f4f1;
        width: 85px;
        height: 85px;
        margin: 0 auto 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 6px;
    }

    .empty-desc {
        color: #718096;
        font-size: 14px;
        margin-bottom: 20px;
    }

    .btn-shop-continue {
        display: inline-block;
        padding: 12px 28px;
        background: #00796b;
        color: white;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 14px;
        transition: background 0.2s;
    }

    .btn-shop-continue:hover {
        background: #005b50;
        color: white;
    }
</style>

@endsection
