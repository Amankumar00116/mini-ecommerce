@extends('layouts.app')

@section('title', 'My E-commerce')

@section('content')

 @if(session('success'))
    <div id="success-message"
     style="position:fixed; top:20px; right:20px;color:black;">
        {{ session('success') }}
    </div>
@endif
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Dress Well.&nbsp;<span>Feel Great.</span></h1>
            <p>Everyday fashion for men, women and kids, delivered to your door.</p>
            <a href="#products" class="shop-btn">Shop Now</a>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="section">
        <h2 class="section-title">Shop by Category</h2>


        <div class="categories">

    {{-- Men's Casual Wear - ID 6 --}}
    <a href="{{ route('category.show', 6) }}" class="category"
       style="background-image: url('{{ asset('assets/images/Men’s Casual Wear Sale Banner.png') }}')">
    </a>

    {{-- Men's Activewear - ID 7 --}}
    <a href="{{ route('category.show', 7) }}" class="category"
       style="background-image: url('{{ asset('assets/images/activewear.png') }}')">
    </a>

    {{-- Women's Ethnic Wear - ID 8 --}}
    <a href="{{ route('category.show', 8) }}" class="category"
       style="background-image: url('{{ asset('assets/images/enthicwear.png') }}')">
    </a>

    {{-- Women's Activewear - ID 9 --}}
    <a href="{{ route('category.show', 9) }}" class="category"
       style="background-image: url('{{ asset('assets/images/women-activewear.png') }}')">
    </a>

    {{-- Women's Western Wear - ID 10 --}}
    <a href="{{ route('category.show', 10) }}" class="category"
       style="background-image: url('{{ asset('assets/images/westernwear.png') }}')">
    </a>

    {{-- Sportswear - ID 11 --}}
    <a href="{{ route('category.show', 11) }}" class="category"
       style="background-image: url('{{ asset('assets/images/sportswear.png') }}')">
    </a>

    {{-- Innerwear - ID 12 --}}
    <a href="{{ route('category.show', 12) }}" class="category"
       style="background-image: url('{{ asset('assets/images/innerwear.png') }}')">
    </a>

    {{-- Watches - ID 13 --}}
    <a href="{{ route('category.show', 13) }}" class="category"
       style="background-image: url('{{ asset('assets/images/watches.png') }}')">
    </a>

    {{-- Grooming - ID 14 --}}
    <a href="{{ route('category.show', 14) }}" class="category"
       style="background-image: url('{{ asset('assets/images/grooming.png') }}')">
    </a>

    {{-- Kids Wear - ID 15 --}}
    <a href="{{ route('category.show', 15) }}" class="category"
       style="background-image: url('{{ asset('assets/images/kiddeswear.png') }}')">
    </a>

    {{-- Men's Footwear - ID 16 --}}
    <a href="{{ route('category.show', 16) }}" class="category"
       style="background-image: url('{{ asset('assets/images/men-footwear.png') }}')">
    </a>

    {{-- Women's Footwear - ID 17 --}}
    <a href="{{ route('category.show', 17) }}" class="category"
       style="background-image: url('{{ asset('assets/images/women-footwear.png/') }}')">
    </a>

    {{-- Bags, Belts & Wallets - ID 18 --}}
    <a href="{{ route('category.show', 18) }}" class="category"
       style="background-image: url('{{ asset('assets/images/belt_wallet.png') }}')">
    </a>

    {{-- Headphones & Audio - ID 19 --}}
    <a href="{{ route('category.show', 19) }}" class="category"
       style="background-image: url('{{ asset('assets/images/headphone.png') }}')">
    </a>

    {{-- Trolleys & Luggage - ID 20 --}}
    <a href="{{ route('category.show', 20) }}" class="category"
       style="background-image: url('{{ asset('assets/images/trolley.png') }}')">
    </a>

    {{-- Women's Sleepwear - ID 21 --}}
    <a href="{{ route('category.show', 21) }}" class="category"
       style="background-image: url('{{ asset('assets/images/Sleepwear.jpg') }}')">
    </a>

</div>
    </section>

    <script>
// Success message automatically hide
let successMessage = document.getElementById('success-message');

if (successMessage) {
    setTimeout(function () {
        successMessage.remove();
    }, 2000);
}

</script>

<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

</style>

@endsection














