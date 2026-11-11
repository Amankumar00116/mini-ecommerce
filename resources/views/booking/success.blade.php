@extends('layouts.app')

@section('title', 'Order Placed')

@section('content')

<div class="success-page-wrapper">

    <!-- Success Header Animation -->
    <div class="success-container">
        <div class="success-circle">
            <span>✓</span>
        </div>

        <h2 class="success-title">
            Order Placed Successfully!
        </h2>

        <p class="success-message">
            Thank you for shopping with us. Your order has been confirmed.
        </p>
    </div>


    <!-- Order Details Card -->
    <div class="order-box">

        <h3 class="order-box-title">
            Order Summary
        </h3>

        @php
            $grandTotal = 0;
        @endphp

        @foreach($bookings as $booking)

            @php
                $product = $booking->product;
                $itemTotal = $product->price * $booking->quantity_ordered;
                $grandTotal += $itemTotal;
            @endphp

            <div class="order-product-item">

                <div class="order-product-details">
                    <h4 class="product-name-text">{{ $product->product_name }}</h4>

                    <div class="specs-grid">
                        <p class="detail-row">
                            <span>Size:</span> <strong>{{ $booking->selected_size }}</strong>
                        </p>
                        <p class="detail-row">
                            <span>Quantity:</span> <strong>{{ $booking->quantity_ordered }}</strong>
                        </p>
                        <p class="detail-row">
                            <span>Price:</span> <strong>₹{{ $product->price }}</strong>
                        </p>
                        <p class="detail-row">
                            <span>Item Total:</span> <strong class="text-teal">₹{{ $itemTotal }}</strong>
                        </p>
                    </div>
                </div>

                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->product_name }}"
                         class="product-thumb-img">
                @endif

            </div>

            @if(!$loop->last)
                <hr class="order-item-divider">
            @endif

        @endforeach


        <!-- Order Status Info Grid -->
        <div class="order-meta-grid">
            <div class="meta-item">
                <span>Payment Method</span>
                <strong>Cash on Delivery</strong>
            </div>
            <div class="meta-item">
                <span>Order Status</span>
                <strong class="status-badge">Confirmed</strong>
            </div>
        </div>

        <!-- Grand Total -->
        <div class="grand-total-row">
            <span>Grand Total</span>
            <span class="total-price-teal">
                ₹{{ $grandTotal }}
            </span>
        </div>

        <!-- Continue Shopping Button -->
        <div class="button-wrapper">
            <a href="{{ url('/') }}" class="shopping-btn">
                Continue Shopping
            </a>
        </div>

    </div>

</div>


<!-- STYLING & ANIMATIONS -->
<style>

.success-page-wrapper {
    max-width: 800px;
    margin: 0 auto;
    padding: 50px 20px;
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    color: #2d3748;
}

/* Success Section */
.success-container {
    text-align: center;
    margin-bottom: 30px;
}

/* Teal Circle */
.success-circle {
    width: 85px;
    height: 85px;
    margin: 0 auto 20px;
    border-radius: 50%;
    background: #00796b;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 25px rgba(0, 121, 107, 0.25);

    animation: circlePop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

/* Check Mark */
.success-circle span {
    color: white;
    font-size: 45px;
    font-weight: bold;
    line-height: 1;

    animation: checkAppear 0.4s ease 0.2s both;
}

/* Heading */
.success-title {
    color: #1a202c;
    font-size: 26px;
    font-weight: 700;
    margin: 0;
    animation: textAppear 0.6s ease 0.3s both;
}

/* Message */
.success-message {
    margin-top: 8px;
    color: #718096;
    font-size: 15px;
    animation: textAppear 0.6s ease 0.4s both;
}

/* Order Box */
.order-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    padding: 32px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    animation: boxAppear 0.6s ease 0.3s both;
}

.order-box-title {
    font-size: 18px;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 20px 0;
    padding-bottom: 12px;
    border-bottom: 1px solid #edf2f7;
}

.order-product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    background: #f8fafc;
    padding: 18px 20px;
    border-radius: 12px;
    border: 1px solid #edf2f7;
}

.order-product-details {
    flex: 1;
}

.product-name-text {
    font-size: 17px;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 10px 0;
}

.specs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 6px 20px;
}

@media (max-width: 600px) {
    .specs-grid {
        grid-template-columns: 1fr;
    }
}

.detail-row {
    font-size: 14px;
    color: #718096;
    margin: 0;
}

.detail-row strong {
    color: #2d3748;
}

.text-teal {
    color: #00796b !important;
}

.product-thumb-img {
    width: 90px;
    height: 105px;
    object-fit: cover;
    border-radius: 8px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
}

.order-item-divider {
    border: none;
    border-top: 1px solid #edf2f7;
    margin: 16px 0;
}

/* Order Meta Info */
.order-meta-grid {
    display: flex;
    justify-content: space-between;
    background: #e6f4f1;
    padding: 14px 20px;
    border-radius: 10px;
    margin-top: 20px;
}

.meta-item {
    font-size: 14px;
    color: #2d3748;
}

.meta-item span {
    display: block;
    font-size: 12px;
    color: #718096;
    margin-bottom: 2px;
}

.status-badge {
    color: #00796b;
}

/* Grand Total Row */
.grand-total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #edf2f7;
    font-size: 18px;
    font-weight: 700;
    color: #1a202c;
}

.total-price-teal {
    color: #00796b;
    font-size: 22px;
}

.button-wrapper {
    text-align: center;
    margin-top: 30px;
}

/* Continue Shopping Button */
.shopping-btn {
    display: inline-block;
    padding: 13px 36px;
    background: #00796b;
    color: white;
    text-decoration: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
    transition: all 0.2s ease;
    box-shadow: 0 4px 15px rgba(0, 121, 107, 0.2);
}

.shopping-btn:hover {
    background: #005b50;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 121, 107, 0.3);
}

.shopping-btn:active {
    transform: translateY(0);
}


/* Keyframe Animations */
@keyframes circlePop {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    70% {
        transform: scale(1.15);
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
}

@keyframes checkAppear {
    0% {
        opacity: 0;
        transform: scale(0);
    }
    100% {
        opacity: 1;
        transform: scale(1);
    }
}

@keyframes textAppear {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes boxAppear {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

</style>

@endsection
