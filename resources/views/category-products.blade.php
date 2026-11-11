@extends('layouts.app')

@section('title', $title)

@section('content')

@if(session('success'))
    <div id="cart-popup" class="cart-popup">
        <i class="bi bi-check-circle-fill"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

<div class="products-page-wrapper">
    <section class="section">

        <!-- Category/Page Title -->
        <div class="products-header-flex">
            <h2 class="section-title">
                {{ $title }}
            </h2>
        </div>

        <div class="products-grid">

            @forelse($products as $product)

                <div class="product-card">

                    <!-- Product Image Container -->
                    <div class="product-img-wrapper">
                        <img src="{{ asset('storage/' . $product->image) }}"
                             alt="{{ $product->product_name }}"
                             class="product-image">
                    </div>

                    <!-- Product Details Body -->
                    <div class="product-card-body">
                        <h3 class="product-name" title="{{ $product->product_name }}">{{ $product->product_name }}</h3>

                        <div class="product-price-row">
                            <span class="price">₹{{ $product->price }}</span>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST" onsubmit="saveCartScroll()" class="product-form">
                            @csrf

                            <div class="form-inputs-inline">
                                <!-- Size Select -->
                                <div class="input-group-field">
                                    <label>Size</label>
                                    <select name="size" required class="custom-select-box">
                                        <option value="">Size</option>
                                        <option value="S">S</option>
                                        <option value="M">M</option>
                                        <option value="L">L</option>
                                        <option value="XL">XL</option>
                                    </select>
                                </div>

                                <!-- Quantity Input -->
                                <div class="input-group-field">
                                    <label>Qty</label>
                                    <input type="number"
                                           name="quantity"
                                           value="1"
                                           min="1"
                                           max="{{ $product->quantity }}"
                                           required
                                           class="custom-input-number">
                                </div>
                            </div>

                            <button type="submit" class="book-btn">
                                <i class="bi bi-bag-plus me-1"></i> Add to cart
                            </button>
                        </form>
                    </div>

                </div>

            @empty

                <div class="empty-products-card">
                    <i class="bi bi-box-seam empty-icon"></i>
                    <h4>No products found</h4>
                    <p>There are no products available in this category right now.</p>
                </div>

            @endforelse

        </div>

    </section>
</div>


<!-- STYLING -->
<style>
    /* Background and Card color both set to White */
    .products-page-wrapper {
        background: #ffffff;
        min-height: 85vh;
        padding: 30px 15px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .products-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    /* 5 to 6 Cards per Row Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(185px, 1fr));
        gap: 14px;
    }

    /* Product Card with White Background */
    .product-card {
        background: #ffffff;
        border: 1px solid #f1f3f5;
        /* border-radius: 8px; */
        border: none;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
    }

    .product-card:hover {
        transform: translateY(-3px);
        border-color: #e2e8f0;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    /* Tall Portrait Image Height */
    .product-img-wrapper {
        width: 100%;
        height: 250px;
        background: #f8fafc;
        position: relative;
        overflow: hidden;
    }

    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image {
        transform: scale(1.04);
    }

    /* Card Body */
    .product-card-body {
        padding: 10px 12px 12px 12px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .product-name {
        font-size: 13px;
        font-weight: 600;
        color: #2d3748;
        margin: 0 0 2px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .product-price-row {
        margin-bottom: 6px;
    }

    .price {
        font-size: 14px;
        font-weight: 700;
        color: #1a202c;
    }

    .product-form {
        margin-top: auto;
    }

    .form-inputs-inline {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 6px;
        margin-bottom: 6px;
    }

    .input-group-field label {
        display: block;
        font-size: 9px;
        font-weight: 600;
        color: #a0aec0;
        text-transform: uppercase;
        margin-bottom: 1px;
    }

    .custom-select-box,
    .custom-input-number {
        width: 100%;
        padding: 5px 6px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 12px;
        color: #2d3748;
        background: #fdfdfd;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        box-sizing: border-box;
    }

    .custom-select-box:focus,
    .custom-input-number:focus {
        border-color: #00796b;
        background: #fff;
        box-shadow: 0 0 0 2px rgba(0, 121, 107, 0.1);
    }

    /* Add to Cart Button */
    .book-btn {
        width: 100%;
        padding: 7px;
        background: #00796b;
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.1s;
    }

    .book-btn:hover {
        background: #005b50;
    }

    .book-btn:active {
        transform: scale(0.98);
    }

    /* Empty Products State */
    .empty-products-card {
        grid-column: 1 / -1;
        background: white;
        border: 1px solid #e2e8f0;
        text-align: center;
        padding: 50px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
    }

    .empty-icon {
        font-size: 40px;
        color: #00796b;
        background: #e6f4f1;
        width: 75px;
        height: 75px;
        margin: 0 auto 14px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-products-card h4 {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 6px;
    }

    .empty-products-card p {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    /* Cart Popup Notification Styling */
    .cart-popup {
        position: fixed;
        top: 90px;
        right: 30px;
        background: white;
        color: #1a202c;
        padding: 12px 18px;
        border-radius: 10px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 9999;
        font-size: 13px;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        animation: popupSlide 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .cart-popup i {
        color: #00796b;
        font-size: 18px;
    }

    @keyframes popupSlide {
        from {
            opacity: 0;
            transform: translateX(30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>

<script>
function saveCartScroll() {
    sessionStorage.setItem('cartScrollPosition', window.scrollY);
}

window.addEventListener('load', function () {
    let scrollPosition = sessionStorage.getItem('cartScrollPosition');

    if (scrollPosition !== null) {
        window.scrollTo(0, parseInt(scrollPosition));
        sessionStorage.removeItem('cartScrollPosition');
    }
});

setTimeout(function () {
    let popup = document.getElementById('cart-popup');

    if (popup) {
        popup.remove();
    }
}, 2000);
</script>

@endsection
