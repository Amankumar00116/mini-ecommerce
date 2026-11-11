@extends('layouts.admin')

@section('title', 'Edit Product')

@section('content')

<h2>Edit Product</h2>

<form action="{{ route('products.update', $product->id) }}" method="POST">
    @csrf
       @method('PUT')

    <div style="margin-bottom:15px;">
        <label>Product Name</label><br>
        <input type="text"
               name="product_name"
               value="{{ $product->product_name }}"
               required>
    </div>

    <div style="margin-bottom:15px;">
        <label>Category</label><br>

        <select name="category_id" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                    {{ $category->category_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div style="margin-bottom:15px;">
        <label>Price</label><br>
        <input type="number"
               name="price"
               value="{{ $product->price }}"
               required>
    </div>

    <div style="margin-bottom:15px;">
        <label>Quantity</label><br>
        <input type="number"
               name="quantity"
               value="{{ $product->quantity }}"
               required>
    </div>

    <div style="margin-bottom:15px;">
        <label>Size</label><br>
        <input type="text"
               name="size"
               value="{{ $product->size }}"
               required>
    </div>

    <button type="submit"
            style="
                background:#1677ff;
                color:white;
                border:none;
                padding:8px 15px;
                border-radius:5px;
                cursor:pointer;
            ">
        Update Product
    </button>

    <a href="{{ url('/products') }}"
       style="
           background:#6c757d;
           color:white;
           padding:8px 15px;
           border-radius:5px;
           text-decoration:none;
           margin-left:5px;
       ">
        Cancel
    </a>
</form>

@endsection
