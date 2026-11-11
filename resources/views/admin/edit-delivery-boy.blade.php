@extends('layouts.admin')

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
            margin: 0 0 25px;
            font-size: 23px;
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
            padding: 11px 12px;
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
            padding: 11px 18px;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            cursor: pointer;
        }

        .create-button:hover {
            background: #1d4ed8;
        }

        .cancel-button {
            display: inline-block;
            margin-left: 10px;
            padding: 10px 16px;
            color: #374151;
            background: #e5e7eb;
            border-radius: 6px;
            text-decoration: none;
        }

        .error-message {
            color: #b91c1c;
            background: #fee2e2;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
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

        <div class="delivery-card">
            <h3>Edit Delivery Boy</h3>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form class="delivery-form" method="POST" action="{{ route('admin.delivery-boys.update', $user->id) }}">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="mobile">Mobile Number</label>
                    <input type="text" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" required>
                </div>

                <div class="form-group">
                    <label for="state">State</label>
                    <input type="text" id="state" name="state" value="{{ old('state', $user->state) }}" required>
                </div>

                <div class="form-group">
                    <label for="district">District</label>
                    <input type="text" id="district" name="district" value="{{ old('district', $user->district) }}"
                        required>
                </div>


                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" required>
                </div>

                <button type="submit" class="create-button">
                    Update Delivery Boy
                </button>

                <a href="{{ route('admin.delivery-boys.index') }}" style="margin-left: 10px;">
                    Cancel
                </a>

            </form>
        </div>

    </div>
@endsection
