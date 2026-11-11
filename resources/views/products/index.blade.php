@extends('layouts.admin')

@section('title', 'Products')

@section('content')

 <!-- PRODUCTS CONTENT -->
<div style="padding:30px;">

<!-- HEADING + BACK BUTTON -->
<div style="display: flex; justify-content: space-between; align-items: center">
<h2>Products</h2>

<a href="{{ url('/dashboard') }}" style="background-color: rgb(52, 52, 239); color: white; padding: 5px; border-radius: 5px;  ">Back</a>

</div>

<!-- CATEGORY FILTER -->
<form method="GET" action="{{ url('/products') }}">

    <select name="category_id" onchange="this.form.submit()">

    <option value="">
        All Products
    </option>

    @foreach($categories as $category)
        <option value="{{ $category->id }}"
            {{ request('category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->category_name }}
        </option>
    @endforeach

</select>

</form>

<br>

 <!-- PRODUCTS TABLE -->
<table style="border-collapse: collapse; width: 100%;">
    <tr>
        <th style="border:1px solid #000; padding:10px;">ID</th>
        <th style="border:1px solid #000; padding:10px;">Product Name</th>
        <th style="border:1px solid #000; padding:10px;">Category</th>
        <th style="border:1px solid #000; padding:10px;">Price</th>
        <th style="border:1px solid #000; padding:10px;">Quantity</th>
        <th style="border:1px solid #000; padding:10px;">Size</th>
        <th style="border:1px solid #000; padding:10px;">Image</th>
        <th style="border:1px solid #000; padding:10px;">Action</th>
    </tr>

    @foreach ($products as $product )
    <tr>
        <td style="border:1px solid #000; padding:10px;">{{ $product ->id }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $product ->product_name }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $product ->category_id }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $product ->price }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $product ->quantity }}</td>
        <td style="border:1px solid #000; padding:10px;">{{ $product ->size }}</td>
        <td style="border:1px solid #000; padding:10px;">
            @if ($product->image)
            <img src="{{ asset('storage/' .$product->image) }}" alt=""
             width="80"
             height="80"
             style="object-fit: cover;">

            @else
            No Image
            @endif
        </td>
        <td style="border:1px solid #000; padding:10px;">

            <!-- EDIT -->
    <a href="{{ route('products.edit', $product->id) }}"
       style="
           background:#1677ff;
           color:white;
           padding:6px 12px;
           border-radius:5px;
           text-decoration:none;
           margin-right:5px;
       ">
        Edit
    </a>

    <!-- DELETE -->
    <form action="{{ route('products.destroy', $product->id) }}"
          method="POST"
          style="display:inline;">

        @csrf
        @method('DELETE')

        <button type="submit"
                onclick="return confirm('Are you sure you want to delete this product?')"
                style="
                    background:#dc3545;
                    color:white;
                    border:none;
                    padding:6px 12px;
                    border-radius:5px;
                    cursor:pointer;
                ">
            Delete
        </button>

    </form>

</td>
    </tr>

    @endforeach
</table>

@endsection
