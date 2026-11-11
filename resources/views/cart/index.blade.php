@extends('layouts.app')

@section('title', 'My Cart')

@section('content')

    <div class="cart-page-wrapper">


        <div class="cart-main-title">My Shopping Bag</div>

        <x-checkout-steps :current="1" />
        @if ($carts->count() > 0)


            <div class="cart-layout-grid">

                <!-- LEFT: CART ITEMS LIST -->
                <div class="cart-items-column">
                    @foreach ($carts as $cart)
                        <div class="cart-item-card">


                            <!-- Remove Form -->
                            <div class="remove-top-right">
                                <form action="{{ route('cart.remove', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove">
                                        <i class="fa-solid fa-trash-can"></i>
                                        Remove
                                    </button>
                                </form>
                            </div>

                            <!-- Product Image -->
                            @if ($cart->product->image)
                                <img src="{{ asset('storage/' . $cart->product->image) }}"
                                    alt="{{ $cart->product->product_name }}" class="cart-product-img">
                            @else
                                <div class="cart-product-placeholder"></div>
                            @endif

                            <!-- Product Details -->
                            <div class="cart-item-info">

                                <h3 class="cart-product-name">
                                    {{ $cart->product->product_name }}
                                </h3>

                                <p class="cart-product-price">
                                    Price: <strong>₹{{ $cart->product->price }}</strong>
                                </p>

                                <!-- Size Update Form -->
                                <div class="cart-action-row">
                                    <span class="label-text">Size:</span>
                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST" class="inline-form">
                                        @csrf
                                        <select name="size" class="size-select" onchange="this.form.submit()">
                                            <option value="S" {{ $cart->size == 'S' ? 'selected' : '' }}>S</option>
                                            <option value="M" {{ $cart->size == 'M' ? 'selected' : '' }}>M</option>
                                            <option value="L" {{ $cart->size == 'L' ? 'selected' : '' }}>L</option>
                                            <option value="XL" {{ $cart->size == 'XL' ? 'selected' : '' }}>XL</option>
                                        </select>
                                    </form>
                                </div>

                                <!-- Quantity Update Form -->
                                <div class="cart-action-row">
                                    <span class="label-text">Quantity:</span>

                                    <form action="{{ route('cart.update', $cart->id) }}" method="POST"
                                        class="inline-form">
                                        @csrf

                                        <div class="quantity-controller">
                                            <button type="button" onclick="changeQuantity(this, -1)"
                                                class="qty-btn">−</button>

                                            <input type="number" name="quantity" value="{{ $cart->quantity }}"
                                                min="1" max="{{ $cart->product->quantity }}" class="qty-input"
                                                onchange="this.form.submit()">

                                            <button type="button" onclick="changeQuantity(this, 1)"
                                                class="qty-btn">+</button>
                                        </div>
                                    </form>
                                </div>

                                <p class="item-subtotal">
                                    Total: <strong
                                        style="color: #00796b;">₹{{ $cart->product->price * $cart->quantity }}</strong>
                                </p>

                            </div>

                        </div>
                    @endforeach
                </div>


                <!-- RIGHT: ORDER SUMMARY CARD -->
                <div class="cart-summary-column">
                    <div class="summary-card-box">
                        <h3 class="summary-title">Price Details ({{ $carts->sum('quantity') }} Items)</h3>

                        <div class="summary-row">
                            <span>Total MRP</span>
                            <span>₹{{ $carts->sum(function ($cart) {return $cart->product->price * $cart->quantity;}) }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping Fee</span>
                            <span style="color: #00796b; font-weight: 600;">FREE</span>
                        </div>

                        <div class="summary-row grand-total">
                            <span>Total Amount</span>
                            <span class="grand-total-amount">
                                ₹{{ $carts->sum(function ($cart) {
                                    return $cart->product->price * $cart->quantity;
                                }) }}
                            </span>
                        </div>

                        <form action="{{ route('cart.checkout') }}" method="GET">
                            <button type="submit" class="btn-continue-checkout">
                                PLACE ORDER
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        @else
            <div class="empty-cart-card">
                <div class="empty-cart-icon">🛒</div>
                <h3>Your Cart is Empty</h3>
                <p style="color: #718096; margin-top: 6px;">Add some products to your cart.</p>
            </div>

        @endif

    </div>


    <!-- SCRIPTS -->
    <script>
        function changeQuantity(button, change) {
            let form = button.closest('form');

            let input = form.querySelector('input[name="quantity"]');

            let current = parseInt(input.value);
            let min = parseInt(input.min);
            let max = parseInt(input.max);

            let newQuantity = current + change;

            if (newQuantity >= min && newQuantity <= max) {
                input.value = newQuantity;
                form.submit();
            }
        }
    </script>


    <!-- STYLING -->
    <style>
        .cart-page-wrapper {
            max-width: 1150px;
            margin: 0 auto;
            padding: 40px 20px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #2d3748;
        }

        .cart-main-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 24px;
        }

        .cart-layout-grid {
            display: grid;
            grid-template-columns: 1.6fr 1fr;
            gap: 30px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .cart-layout-grid {
                grid-template-columns: 1fr;
            }
        }

        .cart-items-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .cart-item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            display: flex;
            gap: 24px;
            align-items: flex-start;
            position: relative;
        }

        .remove-top-right {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        .cart-product-img {
            width: 110px;
            height: 130px;
            object-fit: cover;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .cart-product-placeholder {
            width: 110px;
            height: 130px;
            background: #edf2f7;
            border-radius: 8px;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-product-name {
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
            margin: 0 0 6px 0;
        }

        .cart-product-price {
            font-size: 15px;
            color: #4a5568;
            margin: 0 0 14px 0;
        }

        .cart-action-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .label-text {
            font-size: 13px;
            font-weight: 600;
            color: #718096;
            min-width: 70px;
        }

        .inline-form {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .size-select {
            padding: 6px 12px;
            font-size: 14px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            background: white;
            cursor: pointer;
            outline: none;
        }

        .quantity-controller {
            display: flex;
            align-items: center;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            overflow: hidden;
            background: #f8fafc;
        }

        .qty-btn {
            width: 30px;
            height: 32px;
            background: transparent;
            border: none;
            cursor: pointer;
            font-weight: 700;
            color: #4a5568;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .qty-btn:hover {
            background: #e2e8f0;
        }

        .qty-input {
            width: 40px;
            height: 32px;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 14px;
            font-weight: 600;
            color: #2d3748;
            outline: none;
            -moz-appearance: textfield;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn-action-done,
        .btn-action-update {
            padding: 6px 14px;
            background: #00796b;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-action-done:hover,
        .btn-action-update:hover {
            background: #005b50;
        }

        .btn-remove {
            display: flex;
            align-items: center;
            gap: 5px;
            background: transparent;
            color: #dc3545;
            border: none;
            padding: 6px 10px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .item-subtotal {
            margin-top: 14px;
            font-size: 14px;
            color: #4a5568;
        }

        /* Right Order Summary Card */
        .cart-summary-column {
            position: sticky;
            top: 20px;
        }

        .summary-card-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .summary-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 16px;
            padding-bottom: 10px;
            border-bottom: 1px solid #edf2f7;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
            color: #4a5568;
        }

        .summary-row.grand-total {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
            border-top: 1px solid #edf2f7;
            padding-top: 14px;
            margin-top: 14px;
        }

        .grand-total-amount {
            color: #00796b;
        }

        .btn-continue-checkout {
            width: 100%;
            margin-top: 20px;
            padding: 12px;
            background: #00796b;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-continue-checkout:hover {
            background: #005b50;
        }

        .empty-cart-card {
            text-align: center;
            padding: 60px 20px;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
        }

        .empty-cart-icon {
            font-size: 48px;
            margin-bottom: 12px;
        }
    </style>

@endsection
