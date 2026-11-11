@extends('layouts.app')

@section('title', 'Payment')

@section('content')

<div class="payment-page-wrapper">

    <div class="payment-main-title">Payment & Order Summary</div>

    <x-checkout-steps :current="3" />

    <div class="payment-layout-grid">

        <!-- LEFT COLUMN: ORDER SUMMARY + DELIVERY & TRUST INFO -->
        <div class="payment-left-column">

            <!-- ORDER SUMMARY CARD -->
            <div class="payment-section-card">
                <h3 class="section-title">Order Summary</h3>

                @php
                    $grandTotal = 0;
                @endphp

                @foreach($bookings as $booking)

                    @php
                        $product = $booking->product;
                        $itemTotal = $product->price * $booking->quantity_ordered;
                        $grandTotal += $itemTotal;
                    @endphp

                    <div class="payment-product-item">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->product_name }}"
                                 class="payment-prod-img">
                        @endif

                        <div class="payment-prod-info">
                            <h4 class="payment-prod-name">{{ $product->product_name }}</h4>
                            <div class="prod-specs-grid">
                                <p class="payment-prod-text">Size: <span>{{ $booking->selected_size }}</span></p>
                                <p class="payment-prod-text">Quantity: <span>{{ $booking->quantity_ordered }}</span></p>
                                <p class="payment-prod-text">Price: <span>₹{{ $product->price }}</span></p>
                            </div>
                            <div class="item-total-box">
                                <span>Item Total:</span>
                                <strong class="text-teal">₹{{ $itemTotal }}</strong>
                            </div>
                        </div>
                    </div>

                    @if(!$loop->last)
                        <hr class="payment-divider">
                    @endif

                @endforeach
            </div>

            <!-- TRUST & DELIVERY INFO BADGES (Fills left space nicely) -->
            <div class="trust-badges-card">
                <div class="badge-item">
                    <span class="badge-icon">🚚</span>
                    <div>
                        <strong>Estimated Delivery</strong>
                        <p>Get it within 3-5 business days</p>
                    </div>
                </div>
                <div class="badge-item">
                    <span class="badge-icon">🔄</span>
                    <div>
                        <strong>Easy Returns & Exchange</strong>
                        <p>7 days hassle-free return policy</p>
                    </div>
                </div>
                <div class="badge-item">
                    <span class="badge-icon">🛡️</span>
                    <div>
                        <strong>100% Secure Checkout</strong>
                        <p>Safe and encrypted transactions</p>
                    </div>
                </div>
            </div>

        </div>


        <!-- RIGHT COLUMN: PAYMENT METHODS & PLACE ORDER -->
        <div class="payment-right-column">

            <div class="summary-card-box">
                <h3 class="summary-title">Select Payment Method</h3>

                <form action="{{ route('booking.placeOrder') }}" method="POST">
                    @csrf

                    <div class="payment-options-list">

                        <!-- Cash on Delivery -->
                        <label class="payment-option-card">
                            <input type="radio" name="payment_method" value="COD" checked>
                            <div class="payment-option-details">
                                <strong>Cash on Delivery (COD)</strong>
                                <p>Pay cash when your order is delivered.</p>
                            </div>
                        </label>

                        <!-- UPI Options -->
                        <label class="payment-option-card">
                            <input type="radio" name="payment_method" value="UPI">
                            <div class="payment-option-details">
                                <strong>UPI (Google Pay / PhonePe / Paytm)</strong>
                                <p>Pay instantly using your preferred UPI app.</p>
                            </div>
                        </label>

                        <!-- Credit / Debit Card -->
                        <label class="payment-option-card">
                            <input type="radio" name="payment_method" value="Card">
                            <div class="payment-option-details">
                                <strong>Credit / Debit Card</strong>
                                <p>Visa, MasterCard, RuPay, and Maestro supported.</p>
                            </div>
                        </label>

                        <!-- Net Banking -->
                        <label class="payment-option-card">
                            <input type="radio" name="payment_method" value="NetBanking">
                            <div class="payment-option-details">
                                <strong>Net Banking</strong>
                                <p>Pay directly from your bank account.</p>
                            </div>
                        </label>

                    </div>

                    <div class="summary-row">
                        <span>Grand Total</span>
                        <span class="grand-total-amount">₹{{ $grandTotal }}</span>
                    </div>

                    <button type="submit" class="btn-place-order">
                        Place Order
                    </button>
                </form>
            </div>

        </div>

    </div>

</div>


<!-- STYLING -->
<style>
    .payment-page-wrapper {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        color: #2d3748;
    }

    .payment-main-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 24px;
    }

    /* 2-Column Layout */
    .payment-layout-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 30px;
        align-items: start;
    }

    @media (max-width: 950px) {
        .payment-layout-grid {
            grid-template-columns: 1fr;
        }
    }

    .payment-left-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .payment-section-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 32px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #edf2f7;
    }

    /* Product Item Layout */
    .payment-product-item {
        display: flex;
        gap: 24px;
        align-items: center;
        background: #f8fafc;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #edf2f7;
    }

    .payment-prod-img {
        width: 110px;
        height: 130px;
        object-fit: cover;
        border-radius: 8px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
    }

    .payment-prod-info {
        flex: 1;
    }

    .payment-prod-name {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin: 0 0 10px 0;
    }

    .prod-specs-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 6px 16px;
        margin-bottom: 12px;
    }

    .payment-prod-text {
        font-size: 14px;
        color: #718096;
        margin: 0;
    }

    .payment-prod-text span {
        font-weight: 600;
        color: #2d3748;
    }

    .item-total-box {
        border-top: 1px solid #e2e8f0;
        padding-top: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 15px;
        color: #4a5568;
    }

    .text-teal {
        color: #00796b;
        font-weight: 700;
        font-size: 18px;
    }

    .payment-divider {
        border: none;
        border-top: 1px solid #edf2f7;
        margin: 20px 0;
    }

    /* Trust Badges Card */
    .trust-badges-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 24px 32px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .badge-item {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .badge-icon {
        font-size: 24px;
        background: #e6f4f1;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }

    .badge-item strong {
        display: block;
        font-size: 14px;
        color: #1a202c;
    }

    .badge-item p {
        margin: 2px 0 0 0;
        font-size: 12px;
        color: #718096;
    }

    /* Right Column: Payment Options List */
    .payment-right-column {
        position: sticky;
        top: 20px;
    }

    .summary-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 24px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .summary-title {
        font-size: 16px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 18px;
        padding-bottom: 10px;
        border-bottom: 1px solid #edf2f7;
    }

    .payment-options-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }

    .payment-option-card {
        display: flex;
        align-items: flex-start;
        border: 1px solid #cbd5e0;
        padding: 14px 16px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .payment-option-card:hover {
        border-color: #00796b;
        background: #f8fafc;
    }

    .payment-option-card input[type="radio"] {
        margin-top: 3px;
        accent-color: #00796b;
    }

    .payment-option-card input[type="radio"]:checked + .payment-option-details strong {
        color: #00796b;
    }

    .payment-option-details {
        margin-left: 10px;
    }

    .payment-option-details strong {
        display: block;
        font-size: 14px;
        color: #2d3748;
        transition: color 0.2s;
    }

    .payment-option-details p {
        margin: 3px 0 0 0;
        font-size: 12px;
        color: #718096;
        line-height: 1.4;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 16px;
        color: #4a5568;
        padding-top: 14px;
        border-top: 1px solid #edf2f7;
    }

    .grand-total-amount {
        color: #00796b;
        font-weight: 700;
        font-size: 20px;
    }

    .btn-place-order {
        width: 100%;
        margin-top: 20px;
        padding: 14px;
        background: #00796b;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: background 0.2s;
    }

    .btn-place-order:hover {
        background: #005b50;
    }
</style>

@endsection
