@extends('layouts.app')

@section('title', 'Book Product')

@section('content')

    <div class="checkout-page-wrapper">

        <div class="checkout-main-title">
            {{ isset($carts) ? 'Checkout' : 'Book Product' }}
        </div>

        @if ($errors->any())
            <div class="error-alert">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif


        {{-- ================= CART CHECKOUT ================= --}}
        @if (isset($carts))

            <x-checkout-steps :current="2" />

            <div class="checkout-layout-grid">

                <!-- LEFT COLUMN: ADDRESS & PRODUCTS -->
                <div class="checkout-left-column">

                    <!-- DELIVERY ADDRESS SECTION -->
                    <div class="checkout-section-card">
                        <div class="section-header-flex">
                            <h3 class="section-title" style="margin:0;">Delivery Address</h3>
                            <button type="button" onclick="showAddressForm()" class="btn-add-address">
                                + Add New Address
                            </button>
                        </div>

                        <div id="savedAddresses">
                            @if ($addresses->count() > 0)
                                @foreach ($addresses as $address)
                                    <div class="address-box">
                                        <label class="address-label">
                                            <input type="radio" name="address_id" value="{{ $address->id }}"
                                                {{ $loop->first ? 'checked' : '' }} form="cartCheckoutForm">
                                            <strong class="address-name">{{ $address->name }}</strong>
                                        </label>

                                        <div class="address-details">
                                            Mobile: {{ $address->mobile }}<br>
                                            {{ $address->house_no }}, {{ $address->address }},
                                            {{ $address->locality }}<br>
                                            {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}<br>
                                            <span class="address-type-badge">Type: {{ $address->address_type }}</span>
                                        </div>

                                        <div class="address-actions">
                                            <!-- DELETE BUTTON -->
                                            <form action="{{ route('address.delete', $address->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Are you sure you want to delete this address?')"
                                                    class="btn-address-remove">
                                                    Remove
                                                </button>
                                            </form>

                                            <!-- EDIT BUTTON -->
                                            <a href="{{ route('address.edit', $address->id) }}"
                                                class="btn-address-edit">
                                                Edit
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- NEW ADDRESS FORM --}}
                        <div id="newAddressForm" style="{{ $addresses->count() > 0 ? 'display:none;' : '' }}">
                            <form action="{{ route('saved.addresses.store') }}" method="POST"
                                class="address-form-box">
                                @csrf

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{ $user->name }}" class="form-input"
                                        required>
                                </div>

                                <div class="form-group">
                                    <label>Mobile No.</label>
                                    <input type="text" name="mobile" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label>Pin Code</label>
                                    <input type="text" name="pincode" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label>House No. / Building / Block</label>
                                    <input type="text" name="house_no" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label>Address / Street</label>
                                    <textarea name="address" rows="3" class="form-input" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label>Locality / Town</label>
                                    <input type="text" name="locality" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label>City / District</label>
                                    <input type="text" name="city" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" name="state" class="form-input" required>
                                </div>

                                <div class="form-group">
                                    <label>Address Type</label>
                                    <div class="radio-group">
                                        <label><input type="radio" name="address_type" value="Home" checked>
                                            Home</label>
                                        <label><input type="radio" name="address_type" value="Office"> Office</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn-submit-address">
                                    Save Address & Continue
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- ORDER ITEMS LIST -->
                    <div class="checkout-section-card">
                        <h3 class="section-title">Your Products</h3>

                        @php $grandTotal = 0; @endphp

                        @foreach ($carts as $cart)
                            @php
                                $itemTotal = $cart->product->price * $cart->quantity;
                                $grandTotal += $itemTotal;
                            @endphp

                            <div class="checkout-product-item">
                                @if ($cart->product->image)
                                    <img src="{{ asset('storage/' . $cart->product->image) }}"
                                        alt="{{ $cart->product->product_name }}" class="checkout-prod-img">
                                @endif

                                <div class="checkout-prod-info">
                                    <h4 class="checkout-prod-name">{{ $cart->product->product_name }}</h4>
                                    <p class="checkout-prod-text">Price: <strong>₹{{ $cart->product->price }}</strong>
                                    </p>
                                    <p class="checkout-prod-text">Size: <strong>{{ $cart->size }}</strong></p>
                                    <p class="checkout-prod-text">Quantity: <strong>{{ $cart->quantity }}</strong></p>
                                    <p class="checkout-prod-text">Total: <strong
                                            class="text-teal">₹{{ $itemTotal }}</strong></p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                <!-- /LEFT COLUMN -->


                <!-- RIGHT COLUMN: PRICE SUMMARY & CONTINUE -->
                <div class="checkout-right-column">
                    <div class="summary-card-box">
                        <h3 class="summary-title">Price Details</h3>

                        <div class="summary-row">
                            <span>Total Items</span>
                            <span>{{ $carts->sum('quantity') }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping Fee</span>
                            <span style="color: #0F766E; font-weight: 600;">FREE</span>
                        </div>

                        <div class="summary-row grand-total">
                            <span>Total Amount</span>
                            <span class="grand-total-amount">₹{{ $grandTotal }}</span>
                        </div>

                        <form id="cartCheckoutForm" action="{{ route('cart.checkout.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-continue-order">
                                Continue
                            </button>
                        </form>
                    </div>
                </div>
                <!-- /RIGHT COLUMN -->

            </div>
            <!-- /GRID -->


            {{-- ================= DIRECT BOOKING ================= --}}
        @else
            <div class="checkout-layout-grid">

                <!-- LEFT COLUMN: PRODUCT INFO & ADDRESS FORM -->
                <div class="checkout-left-column">

                    <div class="checkout-section-card">
                        <h3 class="section-title">{{ $product->product_name }}</h3>
                        <p class="checkout-prod-text" style="margin-bottom: 12px;">
                            Price: <strong>₹{{ $product->price }}</strong>
                        </p>

                        <label class="checkout-prod-text">Quantity:</label>
                        <div style="display:flex; align-items:center; gap:12px; margin-top:8px; margin-bottom:12px;">
                            <input type="number" id="quantity-{{ $product->id }}" name="quantity_ordered"
                                form="bookingForm" value="{{ $quantity }}" min="1"
                                max="{{ $product->quantity }}" oninput="updateTotal()" class="qty-input-box">
                        </div>

                        <p class="checkout-prod-text">Size: <strong>{{ $product->size }}</strong></p>
                        <p class="checkout-prod-text" style="margin-top:8px;">
                            Total Amount: <strong id="totalAmount"
                                class="text-teal">₹{{ $product->price * $quantity }}</strong>
                        </p>
                    </div>

                    <div class="checkout-section-card">
                        <h3 class="section-title">Delivery Address</h3>

                        <form id="bookingForm" action="{{ route('booking.store', $product->id) }}" method="POST"
                            class="address-form-box">
                            @csrf

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label>Mobile No.</label>
                                <input type="text" name="mobile" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label>Pin Code</label>
                                <input type="text" name="pincode" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label>House No. / Building / Block</label>
                                <input type="text" name="house_no" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label>Address / Street</label>
                                <textarea name="address" rows="3" class="form-input" required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Locality / Town</label>
                                <input type="text" name="locality" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label>City / District</label>
                                <input type="text" name="city" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label>State</label>
                                <input type="text" name="state" class="form-input" required>
                            </div>

                            <div class="form-group">
                                <label>Address Type</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="address_type" value="Home" checked>
                                        Home</label>
                                    <label><input type="radio" name="address_type" value="Office"> Office</label>
                                </div>
                            </div>

                            <button type="submit" class="btn-submit-address">
                                Save Address & Continue
                            </button>
                        </form>
                    </div>

                </div>


                <!-- RIGHT COLUMN: SUMMARY & CONFIRMATION -->
                <div class="checkout-right-column">
                    <div class="summary-card-box">
                        <h3 class="summary-title">Booking Summary</h3>

                        <div class="summary-row">
                            <span>Product</span>
                            <span style="font-weight: 600;">{{ $product->product_name }}</span>
                        </div>

                        <div class="summary-row">
                            <span>Shipping Fee</span>
                            <span style="color: #0F766E; font-weight: 600;">FREE</span>
                        </div>

                        <div class="summary-row grand-total">
                            <span>Total Amount</span>
                            <span class="grand-total-amount">₹{{ $product->price * $quantity }}</span>
                        </div>

                        <button type="submit" form="bookingForm" class="btn-continue-order">
                            Continue
                        </button>
                    </div>
                </div>

            </div>
        @endif

    </div>


    <!-- SCRIPTS (Unchanged Logic) -->
    <script>
        function updateTotal() {
            let quantityField = document.querySelector('input[name="quantity_ordered"]');
            if (!quantityField) return;

            let quantity = quantityField.value;
            let price = {{ isset($product) ? $product->price : 0 }};
            let total = quantity * price;

            let totalElement = document.getElementById('totalAmount');
            if (totalElement) {
                totalElement.innerText = '₹' + total;
            }
        }

        function showAddressForm() {
            let savedAddr = document.getElementById('savedAddresses');
            let newAddr = document.getElementById('newAddressForm');
            if (savedAddr) savedAddr.style.display = 'none';
            if (newAddr) newAddr.style.display = 'block';
        }
    </script>


    <!-- STYLING (Teal Theme Matching) -->
    <style>
        .checkout-page-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: #2d3748;
        }

        .checkout-main-title {
            font-size: 26px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 24px;
        }

        .error-alert {
            color: #e53e3e;
            background: #fff5f5;
            border: 1px solid #feb2b2;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        /* 2-Column Layout */
        .checkout-layout-grid {
            display: grid;
            width: 100%;
            grid-template-columns: minmax(0, 1.7fr) minmax(0, 1fr);
            gap: 30px;
            align-items: start;
        }

        .checkout-left-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
            min-width: 0;
        }

        .checkout-section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        }

        .section-header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 16px;
        }

        /* Address Box Styles */
        .address-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 18px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .address-box:has(input[type="radio"]:checked) {
            border-color: #0F766E;
            background: #f0faf8;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
        }

        .address-label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 15px;
        }

        .address-name {
            margin-left: 8px;
            color: #1a202c;
        }

        .address-details {
            margin-left: 24px;
            margin-top: 8px;
            font-size: 14px;
            color: #4a5568;
            line-height: 1.6;
        }

        .address-type-badge {
            display: inline-block;
            background: #e6f4f1;
            color: #0F766E;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-top: 6px;
        }

        .address-actions {
            margin-left: 24px;
            margin-top: 12px;
            display: flex;
            gap: 10px;
        }

        .btn-add-address {
            padding: 8px 16px;
            border: 1px solid #0F766E;
            border-radius: 8px;
            background: white;
            color: #0F766E;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-add-address:hover {
            background: #e6f4f1;
        }

        .btn-address-remove {
            background: #e53e3e;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-address-remove:hover {
            background: #c53030;
        }

        .btn-address-edit {
            background: #0F766E;
            color: white;
            border: none;
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-address-edit:hover {
            background: #0B5A54;
            color: white;
        }

        /* Form Fields */
        .address-form-box .form-group {
            margin-bottom: 14px;
        }

        .address-form-box label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #4a5568;
            margin-bottom: 6px;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #fff;
        }

        .form-input:focus {
            border-color: #0F766E;
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 6px;
            font-size: 14px;
        }

        .btn-submit-address {
            width: 100%;
            margin-top: 10px;
            padding: 12px;
            background: #0F766E;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit-address:hover {
            background: #0B5A54;
        }

        /* Checkout Products List */
        .checkout-product-item {
            display: flex;
            gap: 16px;
            align-items: center;
            border-bottom: 1px solid #edf2f7;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }

        .checkout-product-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .checkout-prod-img {
            width: 80px;
            height: 90px;
            object-fit: cover;
            border-radius: 8px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .checkout-prod-name {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
            margin: 0 0 4px 0;
        }

        .checkout-prod-text {
            font-size: 13px;
            color: #4a5568;
            margin: 2px 0;
        }

        .text-teal {
            color: #0F766E;
            font-weight: 700;
        }

        .qty-input-box {
            font-weight: 700;
            font-size: 16px;
            width: 70px;
            padding: 6px;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            text-align: center;
            outline: none;
        }

        /* Right Order Summary Card */
        .checkout-right-column {
            position: sticky;
            top: 20px;
            min-width: 0;
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
            color: #0F766E;
        }

        .btn-continue-order {
            width: 100%;
            margin-top: 20px;
            padding: 13px;
            background: #0F766E;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 6px 16px rgba(15, 118, 110, 0.25);
            transition: background 0.2s;
        }

        .btn-continue-order:hover {
            background: #0B5A54;
        }

        /* ================= Radio / checkbox teal ================= */
        input[type="radio"],
        input[type="checkbox"] {
            accent-color: #0F766E;
        }

        /* ================= Mobile / tablet (sabse neeche rakhna) ================= */
        @media (max-width: 950px) {
            .checkout-layout-grid {
                grid-template-columns: 1fr;
            }

            .checkout-right-column {
                position: static;
            }
        }
    </style>

@endsection
