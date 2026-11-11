@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')

<div style="
    max-width:1100px;
    margin:0 auto;
">

    <!-- HEADER -->
    <div style="
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:25px;
    ">
        <div>
            <h2 style="
                margin:0;
                font-size:30px;
                font-weight:600;
                color:#172337;
            ">
                Add Product
            </h2>

            <p style="
                margin:6px 0 0;
                color:#777;
                font-size:14px;
            ">
                Add a new product to your store
            </p>
        </div>

        <a href="{{ url('/dashboard') }}"
           style="
                background:#172337;
                color:white;
                padding:9px 18px;
                border-radius:6px;
                text-decoration:none;
                font-size:14px;
           ">
            ← Back
        </a>
    </div>


    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div style="
            background:#d1e7dd;
            color:#0f5132;
            padding:12px 15px;
            border-radius:6px;
            margin-bottom:20px;
        ">
            {{ session('success') }}
        </div>
    @endif


    <!-- FORM CARD -->
    <div style="
        background:white;
        border-radius:10px;
        padding:30px;
        box-shadow:0 2px 10px rgba(0,0,0,0.08);
    ">

        <form action="{{ url('/products/create') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <!-- ROW 1 -->
            <div style="
                display:grid;
                grid-template-columns:1fr 1fr;
                gap:20px;
                margin-bottom:20px;
            ">

                <!-- CATEGORY -->
                <div>
                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#333;
                    ">
                        Category
                    </label>

                    <select name="category_id"
                            id="category"
                            style="
                                width:100%;
                                padding:11px 12px;
                                border:1px solid #ced4da;
                                border-radius:6px;
                                font-size:14px;
                                background:white;
                            ">

                        @foreach ($categories as $category)

                            <option value="{{ $category->id }}">
                                {{ $category->category_name }}
                            </option>

                        @endforeach

                    </select>
                </div>
            </div>


            <!-- PRODUCT NAME -->
            <div style="margin-bottom:20px;">

                <label style="
                    display:block;
                    margin-bottom:7px;
                    font-weight:600;
                    color:#333;
                ">
                    Product Name
                </label>

                <input type="text"
                       name="product_name"
                       placeholder="Enter product name"
                       style="
                            width:100%;
                            padding:11px 12px;
                            border:1px solid #ced4da;
                            border-radius:6px;
                            font-size:14px;
                            box-sizing:border-box;
                       ">

            </div>


            <!-- ROW 2 -->
            <div style="
                display:grid;
                grid-template-columns:1fr 1fr 1fr;
                gap:20px;
                margin-bottom:20px;
            ">

                <!-- PRICE -->
                <div>

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#333;
                    ">
                        Price
                    </label>

                    <input type="text"
                           name="price"
                           placeholder="Enter price"
                           style="
                                width:100%;
                                padding:11px 12px;
                                border:1px solid #ced4da;
                                border-radius:6px;
                                font-size:14px;
                                box-sizing:border-box;
                           ">

                </div>


                <!-- QUANTITY -->
                <div>

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#333;
                    ">
                        Quantity
                    </label>

                    <input type="text"
                           name="quantity"
                           placeholder="Enter quantity"
                           style="
                                width:100%;
                                padding:11px 12px;
                                border:1px solid #ced4da;
                                border-radius:6px;
                                font-size:14px;
                                box-sizing:border-box;
                           ">

                </div>


                <!-- SIZE -->
                <div>

                    <label style="
                        display:block;
                        margin-bottom:7px;
                        font-weight:600;
                        color:#333;
                    ">
                        Size
                    </label>

                    <input type="text"
                           name="size"
                           placeholder="Enter size"
                           style="
                                width:100%;
                                padding:11px 12px;
                                border:1px solid #ced4da;
                                border-radius:6px;
                                font-size:14px;
                                box-sizing:border-box;
                           ">

                </div>

            </div>


            <!-- IMAGE -->
            <div style="margin-bottom:25px;">

                <label style="
                    display:block;
                    margin-bottom:7px;
                    font-weight:600;
                    color:#333;
                ">
                    Product Image
                </label>

                <input type="file"
                       name="image"
                       style="
                            width:100%;
                            padding:9px;
                            border:1px solid #ced4da;
                            border-radius:6px;
                            font-size:14px;
                            box-sizing:border-box;
                       ">

                <small style="
                    display:block;
                    margin-top:6px;
                    color:#888;
                ">
                    Upload product image
                </small>

            </div>


            <!-- BUTTONS -->
            <div style="
                display:flex;
                gap:10px;
                border-top:1px solid #eee;
                padding-top:20px;
            ">

                <button type="submit"
                        style="
                            background:#1677ff;
                            color:white;
                            border:none;
                            padding:10px 22px;
                            border-radius:6px;
                            font-size:14px;
                            cursor:pointer;
                        ">
                    Add Product
                </button>

                <a href="{{ url('/products') }}"
                   style="
                        background:#6c757d;
                        color:white;
                        padding:10px 22px;
                        border-radius:6px;
                        text-decoration:none;
                        font-size:14px;
                   ">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>


@endsection
