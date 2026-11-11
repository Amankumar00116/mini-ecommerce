@extends('layouts.app')

@section('title', 'Select Address')

@section('content')

<div style="padding: 40px 60px;">

    <h2 style="margin-bottom: 25px;">Select Delivery Address</h2>

    <!-- Product Details -->
    <div style="border: 1px solid #ddd; padding: 20px; border-radius: 10px; margin-bottom: 30px;>

        <h3>{{ $product->product_name }}</h3>

        <p style="margin-top: 10px;">
            Price: <strong>₹{{ $product->price }}</strong>
        </p>

        <label for="">Quantity:</label>
        <div style="display:flex; align-items:center; gap:12px; margin-top:8px;">

    <button type="button"
            onclick="this.nextElementSibling.stepDown()"
            style="border:none; background:none; font-size:22px; cursor:pointer;">
        −
    </button>

    <input type="number"
    id="quantity-{{ $product->id }}"
    name="quantity_ordered"
           value="{{ $booking->quantity_ordered }}"
           min="1"
           max="{{ $product->quantity }}"
           style="width:35px; border:none; text-align:center; font-size:16px;">

    <button type="button"
            onclick="this.previousElementSibling.stepUp()"
            style="border:none; background:none; font-size:22px; cursor:pointer;">
        +
    </button>

</div>

        <p style="margin-top: 8px;">
            Size: {{ $product->size }}
        </p>

        <p style="margin-top: 8px;">
            Total Amount: <strong style="color:rgb(6, 182, 6) ">₹{{ $product->price }}</strong>
        </p>


    </div>


    <!-- Saved Address -->
    <div style="border: 1px solid #ddd; padding: 25px; border-radius: 10px; max-width: 800px;">

        <h3 style="margin-bottom: 20px;">Delivery Address</h3>

        <div style="border: 2px solid #1677ff; padding: 20px; border-radius: 8px;">

            <div style="display: flex; justify-content: space-between;">

                <strong style="font-size: 18px;">
                    {{ $booking->name }}
                </strong>

                <span style="background: #eee; padding: 5px 10px; border-radius: 5px;">
                    {{ $booking->address_type }}
                </span>

            </div>

            <p style="margin-top: 12px;">
                Mobile: <strong>{{ $booking->mobile }}</strong>
            </p>

            <p style="margin-top: 20px;">
                {{ $booking->house_no }},
                {{ $booking->address }},
                {{ $booking->locality }}
            </p>

            <p style="margin-top: 8px;">
                {{ $booking->city }},
                {{ $booking->state }} -
                {{ $booking->pincode }}
            </p>
            <button type="submit" style="padding: 10px; border-radius: 5px; margin-top: 20px; font-weight: 600; cursor: pointer;">REMOVE</button>
            <button type="submit" style="padding: 10px; border-radius: 5px; margin-top: 20px; font-weight: 600; cursor: pointer; ">EDIT</button>

        </div>


        <!-- Continue Button -->
       <a href="{{ route('booking.payment', $product->id) }}"
            style="display:block; width:100%; margin-top:25px; padding:13px; border:none; border-radius:6px; background:#1677ff; color:white; font-weight:bold; cursor:pointer; text-align:center; text-decoration:none;">
            Continue
        </a>

    </div>

</div>

@endsection
