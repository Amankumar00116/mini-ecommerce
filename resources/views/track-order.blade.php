@extends('layouts.app')

@section('title', 'Track Order')

@section('content')

<div class="tracking-page-wrapper">

    <div class="tracking-container">

        <!-- Back Link -->
        <a href="{{ route('my.orders') }}" class="back-link">
            ← Back to My Orders
        </a>

        <!-- Header Row -->
        <div class="tracking-header-row">
            <h2 class="tracking-main-title">Track Order</h2>
            <span class="order-id-badge">Order #{{ $order->id }}</span>
        </div>

        <div class="tracking-card-box">

            <!-- PRODUCT DETAILS -->
            <div class="tracking-product-header">
                @if($order->product->image)
                    <img src="{{ asset('storage/' . $order->product->image) }}"
                         alt="{{ $order->product->product_name }}"
                         class="tracking-prod-img">
                @else
                    <div class="tracking-prod-placeholder"></div>
                @endif

                <div class="tracking-prod-info">
                    <h4 class="tracking-prod-name">
                        {{ $order->product->product_name }}
                    </h4>
                    <p class="tracking-meta-text">
                        Size: <strong>{{ $order->selected_size }}</strong> | Qty: <strong>{{ $order->quantity_ordered }}</strong>
                    </p>
                    <p class="tracking-price-text">
                        Total Amount: <strong class="text-teal">₹{{ $order->product->price * $order->quantity_ordered }}</strong>
                    </p>
                </div>
            </div>

            <hr class="tracking-divider">

            @php
                $statuses = [
                    'Confirmed',
                    'Packed',
                    'Shipped',
                    'Out for Delivery',
                    'Delivered'
                ];

                $currentIndex = array_search($order->status, $statuses);
            @endphp


            {{-- REJECTED --}}
            @if($order->status == 'Rejected')

                <div class="alert-state-box">
                    <div class="alert-icon-box bg-red-light">
                        <i class="bi bi-x-circle-fill text-danger" style="font-size: 32px;"></i>
                    </div>
                    <h4 class="fw-bold mt-3 text-danger">Order Rejected</h4>
                    <p class="text-muted">Unfortunately, this order has been rejected by the store.</p>
                </div>


            {{-- OUT OF STOCK --}}
            @elseif($order->status == 'Out of Stock')

                <div class="alert-state-box">
                    <div class="alert-icon-box bg-gray-light">
                        <i class="bi bi-box-seam text-secondary" style="font-size: 32px;"></i>
                    </div>
                    <h4 class="fw-bold mt-3">Out of Stock</h4>
                    <p class="text-muted">This product is currently out of stock and cannot be fulfilled.</p>
                </div>


            {{-- NORMAL TRACKING TIMELINE --}}
            @else

                <!-- Quick Progress Summary -->
                <div class="progress-status-banner">
                    <div class="banner-info">
                        <span class="banner-label">Current Status:</span>
                        <strong class="banner-status-text">{{ $order->status }}</strong>
                    </div>
                    <div class="banner-subtext">
                        @if($order->status == 'Delivered')
                            Your package has been successfully delivered.
                        @else
                            Your order is on its way to you!
                        @endif
                    </div>
                </div>

                <h5 class="timeline-section-title">
                    Activity Timeline
                </h5>

                <div class="timeline-wrapper">
                    @foreach($statuses as $index => $status)

                        @php
                            $completed = $currentIndex !== false && $currentIndex >= $index;
                            $isCurrent = $status == $order->status;

                            $timestampColumn = match ($status) {
                                'Confirmed' => 'confirmed_at',
                                'Packed' => 'packed_at',
                                'Shipped' => 'shipped_at',
                                'Out for Delivery' => 'out_for_delivery_at',
                                'Delivered' => 'delivered_at',
                                default => null,
                            };

                            $statusTime = $timestampColumn ? $order->{$timestampColumn} : null;
                        @endphp

                        <div class="timeline-step-item {{ $isCurrent ? 'current-active-step' : '' }}">

                            <!-- Step Circle & Vertical Line -->
                            <div class="timeline-indicator-col">
                                <div class="timeline-circle {{ $completed ? 'completed' : 'pending' }} {{ $isCurrent ? 'pulse-ring' : '' }}">
                                    @if($completed)
                                        ✓
                                    @else
                                        {{ $index + 1 }}
                                    @endif
                                </div>
                                @if(!$loop->last)
                                    <div class="timeline-line {{ ($currentIndex !== false && $currentIndex > $index) ? 'completed-line' : '' }}"></div>
                                @endif
                            </div>

                            <!-- Step Content Details -->
                            <div class="timeline-content-col">
                                <div class="timeline-title-row">
                                    <strong class="{{ $completed ? 'text-dark-teal' : 'text-gray' }}">
                                        {{ $status }}
                                    </strong>
                                    @if($isCurrent)
                                        <span class="current-status-pill">Active</span>
                                    @endif
                                </div>

                                @if($completed && $statusTime)
                                    <div class="timestamp-text">
                                        {{ \Carbon\Carbon::parse($statusTime)->format('d M, Y • h:i A') }}
                                    </div>
                                @elseif(!$completed)
                                    <div class="timestamp-text text-light-gray">
                                        Pending
                                    </div>
                                @endif
                            </div>

                        </div>

                    @endforeach
                </div>

            @endif

        </div>

    </div>

</div>


<!-- STYLING -->
<style>
    .tracking-page-wrapper {
        background: #f8f9fa;
        min-height: 85vh;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .tracking-container {
        max-width: 750px;
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

    .tracking-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .tracking-main-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .order-id-badge {
        background: #e6f4f1;
        color: #00796b;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
    }

    .tracking-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .tracking-product-header {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .tracking-prod-img {
        width: 100px;
        height: 115px;
        object-fit: cover;
        border-radius: 10px;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
    }

    .tracking-prod-placeholder {
        width: 100px;
        height: 115px;
        background: #edf2f7;
        border-radius: 10px;
    }

    .tracking-prod-info {
        flex: 1;
    }

    .tracking-prod-name {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin: 0 0 6px 0;
    }

    .tracking-meta-text {
        font-size: 14px;
        color: #718096;
        margin: 2px 0;
    }

    .tracking-meta-text strong {
        color: #2d3748;
    }

    .tracking-price-text {
        font-size: 15px;
        color: #4a5568;
        margin-top: 6px;
    }

    .text-teal {
        color: #00796b;
        font-weight: 700;
        font-size: 17px;
    }

    .tracking-divider {
        border: none;
        border-top: 1px solid #edf2f7;
        margin: 24px 0;
    }

    /* Progress Banner */
    .progress-status-banner {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        padding: 16px 20px;
        border-radius: 12px;
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .banner-info {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .banner-label {
        font-size: 13px;
        color: #166534;
        font-weight: 600;
    }

    .banner-status-text {
        font-size: 15px;
        color: #15803d;
        font-weight: 700;
        text-transform: uppercase;
    }

    .banner-subtext {
        font-size: 13px;
        color: #166534;
    }

    .alert-state-box {
        text-align: center;
        padding: 40px 0;
    }

    .alert-icon-box {
        width: 70px;
        height: 70px;
        margin: 0 auto;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .bg-red-light { background: #fde8e8; }
    .bg-gray-light { background: #edf2f7; }

    .timeline-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 20px;
    }

    /* Timeline Stepper UI */
    .timeline-wrapper {
        display: flex;
        flex-direction: column;
        padding-left: 10px;
    }

    .timeline-step-item {
        display: flex;
        gap: 20px;
        position: relative;
    }

    .timeline-indicator-col {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .timeline-circle {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 14px;
        flex-shrink: 0;
        z-index: 2;
        box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    }

    .timeline-circle.completed {
        background: #00796b;
    }

    .timeline-circle.pending {
        background: #e2e8f0;
        color: #718096;
    }

    /* Pulse effect on current active step */
    .pulse-ring {
        box-shadow: 0 0 0 4px rgba(0, 121, 107, 0.2);
    }

    .timeline-line {
        width: 3px;
        flex: 1;
        background: #e2e8f0;
        min-height: 45px;
        margin: 4px 0;
    }

    .timeline-line.completed-line {
        background: #00796b;
    }

    .timeline-content-col {
        padding-bottom: 30px;
        padding-top: 6px;
        flex: 1;
    }

    .timeline-title-row {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .text-dark-teal {
        color: #00796b;
        font-size: 15px;
        font-weight: 700;
    }

    .text-gray {
        color: #a0aec0;
        font-size: 15px;
        font-weight: 600;
    }

    .text-light-gray {
        color: #cbd5e0;
    }

    .timestamp-text {
        font-size: 12px;
        color: #718096;
        margin-top: 4px;
    }

    .current-status-pill {
        background: #e6f4f1;
        color: #00796b;
        font-size: 10px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
</style>

@endsection
