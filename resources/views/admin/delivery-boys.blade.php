@extends('layouts.admin')

@section('title', 'Delivery Boy Management')

@section('header')
    <h2>Delivery Boy Management</h2>
@endsection

@section('content')

    <style>
        .delivery-container {
            padding: 25px;
        }

        .delivery-card {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            max-width: 650px;
            margin-bottom: 30px;
        }

        .delivery-card h3 {
            margin: 0 0 22px;
            font-size: 22px;
            color: #333333;
        }

        .delivery-form .form-group {
            margin-bottom: 18px;
        }

        .delivery-form label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #444444;
        }

        .delivery-form input {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 15px;
            box-sizing: border-box;
            outline: none;
        }

        .delivery-form input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .create-button {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
        }

        .create-button:hover {
            background: #1d4ed8;
        }

        .success-message {
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error-message {
            padding: 12px;
            background: #fee2e2;
            color: #991b1b;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        /* right side: Delivery Overview */

        .delivery-top-section {
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(250px, 1fr);
            gap: 25px;
            align-items: start;
        }

        .delivery-overview {
            background: #ffffff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .delivery-overview h3 {
            margin: 0 0 20px;
            font-size: 22px;
            color: #333333;
        }

        .overview-item {
            padding: 18px;
            margin-bottom: 15px;
            background: #f3f6ff;
            border-left: 4px solid #2563eb;
            border-radius: 7px;
        }

        .overview-item p {
            margin: 0 0 8px;
            color: #666666;
            font-size: 14px;
        }

        .overview-item h4 {
            margin: 0;
            font-size: 28px;
            color: #2563eb;
        }

        .overview-item:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 800px) {
            .delivery-top-section {
                grid-template-columns: 1fr;
            }
        }


        @media (max-width: 600px) {
            .delivery-container {
                padding: 12px;
            }

            .delivery-card {
                padding: 18px;
            }
        }
    </style>

    <div class="delivery-container">

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="delivery-top-section">

            {{-- Left Side: Existing Create Form --}}
            <div class="delivery-card">

                <h3>Create New Delivery Boy</h3>

                <form class="delivery-form" method="POST" action="{{ route('admin.delivery-boys.store') }}">

                    @csrf

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Enter full name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            placeholder="Enter email address" required>
                    </div>

                    <div class="form-group">
                        <label for="mobile">Mobile Number</label>
                        <input type="text" id="mobile" name="mobile" value="{{ old('mobile') }}"
                            placeholder="Enter mobile number" required>
                    </div>

                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state" value="{{ old('state') }}"
                            placeholder="Enter State name" required>
                    </div>

                    <div class="form-group">
                        <label for="district">District</label>
                        <input type="text" id="district" name="district" value="{{ old('district') }}"
                            placeholder="Enter District name" required>
                    </div>

                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}"
                            placeholder="Enter city name" required>
                    </div>


                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required>
                    </div>

                    <button type="submit" class="create-button">
                        Create Delivery Boy
                    </button>

                </form>
            </div>

            {{-- Right Side: Delivery Overview --}}
            <div class="delivery-overview">
                <h3>Delivery Overview</h3>

                <div class="overview-item">
                    <p>Total Delivery Boys</p>
                    <h4>{{ $totalDeliveryBoys }}</h4>
                </div>

                <div class="overview-item">
                    <p>States Covered</p>
                    <h4>{{ $totalStates }}</h4>
                </div>

                <div class="overview-item">
                    <p>Districts Covered</p>
                    <h4>{{ $totalDistricts }}</h4>
                </div>

                <div class="overview-item">
                    <p>Cities Covered</p>
                    <h4>{{ $totalCities }}</h4>
                </div>

            </div>
        </div>

        {{-- Delivery Boys Table --}}
        <div class="delivery-card" style="max-width: 100%; overflow-x: auto;">

            <h3>All Delivery Boys</h3>

            <table style="width: 100%; border-collapse: collapse; text-align: left;">
                <thead>
                    <tr style="background: #f3f4f6;">
                        <th style="padding: 12px; border: 1px solid #ddd;">ID</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Name</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Email</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Mobile</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">State</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">City</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">District</th>
                        <th style="padding: 12px; border: 1px solid #ddd;">Actions</th>

                    </tr>
                </thead>

                <tbody>
                    @forelse ($deliveryBoys as $boy)
                        <tr>
                            <td style="padding: 12px; border: 1px solid #ddd;">
                                {{ $boy->id }}
                            </td>

                            <td style="padding: 12px; border: 1px solid #ddd;">
                                {{ $boy->name }}
                            </td>

                            <td style="padding: 12px; border: 1px solid #ddd;">
                                {{ $boy->email }}
                            </td>

                            <td style="padding: 12px; border: 1px solid #ddd;">
                                {{ $boy->mobile }}
                            </td>

                            <td style="padding: 12px; border: 1px solid #ddd;">
                                {{ $boy->state }}
                            </td>

                            <td style="padding: 12px; border: 1px solid #ddd;">
                                {{ $boy->city }}
                            </td>

                            <td style="padding: 12px; border: 1px solid #ddd;">
                                {{ $boy->district }}
                            </td>

                            <td style="white-space: nowrap;">
                                <a href="{{ route('admin.delivery-boys.edit', $boy->id) }}"
                                    style="display:inline-block; background:#2563eb; color:white;
              padding:7px 12px; border-radius:5px; text-decoration:none;">
                                    Edit
                                </a>

                                <form action="{{ route('admin.delivery-boys.destroy', $boy->id) }}" method="POST"
                                    style="display:inline-block; margin-left:5px;"
                                    onsubmit="return confirm('Are you sure you want to delete this delivery boy?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        style="background:#dc2626; color:white; padding:7px 12px;
                       border:0; border-radius:5px; cursor:pointer;">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 18px; text-align: center; border: 1px solid #ddd;">
                                No Delivery Boys Found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>


    </div>

@endsection
