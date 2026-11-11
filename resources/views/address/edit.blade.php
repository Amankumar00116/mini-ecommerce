@extends('layouts.app')

@section('title', 'Edit Address')

@section('content')



<div style="max-width:700px; margin:40px auto;">

    <h2 style="margin-bottom:25px;">Edit Address</h2>

    <form action="{{ route('address.update', $address->id) }}" method="POST">

        @csrf
        @method('PUT')

        <label>Name</label>
        <input type="text"
               name="name"
               value="{{ $address->name }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>Mobile</label>
        <input type="text"
               name="mobile"
               value="{{ $address->mobile }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>Pincode</label>
        <input type="text"
               name="pincode"
               value="{{ $address->pincode }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>House No.</label>
        <input type="text"
               name="house_no"
               value="{{ $address->house_no }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>Address</label>
        <input type="text"
               name="address"
               value="{{ $address->address }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>Locality</label>
        <input type="text"
               name="locality"
               value="{{ $address->locality }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>City</label>
        <input type="text"
               name="city"
               value="{{ $address->city }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>State</label>
        <input type="text"
               name="state"
               value="{{ $address->state }}"
               required
               style="width:100%; padding:10px; margin:5px 0 15px;">

        <label>Address Type</label>

        <select name="address_type"
                required
                style="width:100%; padding:10px; margin:5px 0 20px;">

            <option value="Home"
                {{ $address->address_type == 'Home' ? 'selected' : '' }}>
                Home
            </option>

            <option value="Work"
                {{ $address->address_type == 'Work' ? 'selected' : '' }}>
                Work
            </option>

            <option value="Office"
                {{ $address->address_type == 'Office' ? 'selected' : '' }}>
                Office
            </option>

        </select>

        <button type="submit"
                style="background:#1677ff;
                       color:white;
                       border:none;
                       padding:12px 25px;
                       border-radius:6px;
                       cursor:pointer;
                       font-weight:bold;">
            Update Address
        </button>

    </form>

</div>

@endsection
