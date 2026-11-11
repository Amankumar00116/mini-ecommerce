@extends('layouts.app')

@section('title', 'Saved Addresses')

@section('content')

<div class="saved-address-wrapper">
    <div class="saved-address-container">

        <!-- Back Link -->
        <a href="{{ route('my.account') }}" class="back-link">
            ← Back to My Account
        </a>

        <!-- Page Header -->
        <div class="saved-address-header-flex">
            <h2 class="saved-address-main-title">
                Saved Addresses
            </h2>
            <span class="address-count-badge">
                {{ $addresses->count() }} {{ $addresses->count() == 1 ? 'Address' : 'Addresses' }}
            </span>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="status-success-alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif

        {{-- Add Address Form Card --}}
        <div class="address-card-box add-form-card">
            <h3 class="card-section-title">
                <i class="bi bi-plus-circle me-1 text-teal"></i> Add New Address
            </h3>

            <form action="{{ route('saved.addresses.store') }}" method="POST">
                @csrf

                <div class="form-grid-2col">

                    <div class="form-group-item">
                        <label class="form-label-title">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="form-input-control" placeholder="Enter full name">
                        @error('name')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item">
                        <label class="form-label-title">Mobile Number</label>
                        <input type="text" name="mobile" value="{{ old('mobile') }}" maxlength="10" required
                               class="form-input-control" placeholder="10-digit mobile number">
                        @error('mobile')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item">
                        <label class="form-label-title">Pincode</label>
                        <input type="text" name="pincode" value="{{ old('pincode') }}" maxlength="6" required
                               class="form-input-control" placeholder="6-digit pincode">
                        @error('pincode')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item">
                        <label class="form-label-title">House / Flat Number</label>
                        <input type="text" name="house_no" value="{{ old('house_no') }}" required
                               class="form-input-control" placeholder="House/Flat/Building">
                        @error('house_no')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item">
                        <label class="form-label-title">Street / Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" required
                               class="form-input-control" placeholder="Street name or Area">
                        @error('address')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item">
                        <label class="form-label-title">Locality</label>
                        <input type="text" name="locality" value="{{ old('locality') }}" required
                               class="form-input-control" placeholder="Locality / Landmark">
                        @error('locality')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item">
                        <label class="form-label-title">City</label>
                        <input type="text" name="city" value="{{ old('city') }}" required
                               class="form-input-control" placeholder="City">
                        @error('city')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item">
                        <label class="form-label-title">State</label>
                        <input type="text" name="state" value="{{ old('state') }}" required
                               class="form-input-control" placeholder="State">
                        @error('state')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group-item full-width-col">
                        <label class="form-label-title">Address Type</label>
                        <select name="address_type" required class="form-input-control">
                            <option value="">Select Type</option>
                            <option value="Home" {{ old('address_type') == 'Home' ? 'selected' : '' }}>Home</option>
                            <option value="Work" {{ old('address_type') == 'Work' ? 'selected' : '' }}>Work</option>
                            <option value="Other" {{ old('address_type') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('address_type')
                            <p class="error-msg-text">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn-save-address">
                    Save Address
                </button>

            </form>
        </div>

        {{-- Existing Addresses List --}}
        @if($addresses->isEmpty())

            <div class="address-card-box empty-state-box">
                <div class="empty-icon-circle">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <h3 class="empty-title">No saved addresses</h3>
                <p class="empty-desc">Your saved delivery addresses will appear here.</p>
            </div>

        @else

            <div class="saved-addresses-list">
                @foreach($addresses as $address)

                    <div class="address-card-box address-item-box">

                        <div class="address-item-header">
                            <div class="address-name-wrap">
                                <strong class="address-fullname">{{ $address->name }}</strong>
                                <span class="address-type-pill">{{ $address->address_type }}</span>
                            </div>

                            <form action="{{ route('address.delete', $address->id) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('DELETE')

                                <button type="submit"
                                        onclick="return confirm('Delete this address?')"
                                        class="btn-delete-address">
                                    <i class="bi bi-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>

                        <p class="address-detail-text">
                            {{ $address->house_no }},
                            {{ $address->address }},
                            {{ $address->locality }},
                            {{ $address->city }},
                            {{ $address->state }} - {{ $address->pincode }}
                        </p>

                        <p class="address-mobile-text">
                            Mobile: <strong>{{ $address->mobile }}</strong>
                        </p>

                    </div>

                @endforeach
            </div>

        @endif

    </div>
</div>


<!-- STYLING -->
<style>
    .saved-address-wrapper {
        background: #f8f9fa;
        min-height: 85vh;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .saved-address-container {
        max-width: 850px;
        margin: auto;
    }

    .back-link {
        display: inline-block;
        color: #00796b;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 16px;
        transition: color 0.2s;
    }

    .back-link:hover {
        color: #005b50;
        text-decoration: underline;
    }

    .saved-address-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .saved-address-main-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .address-count-badge {
        background: #e6f4f1;
        color: #00796b;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
    }

    /* Success Alert */
    .status-success-alert {
        background: #e6f4f1;
        color: #00796b;
        border: 1px solid #b2dfdb;
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 24px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Common Card Box */
    .address-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
    }

    .card-section-title {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #edf2f7;
    }

    .text-teal {
        color: #00796b;
    }

    /* Form Grid */
    .form-grid-2col {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    @media (max-width: 650px) {
        .form-grid-2col {
            grid-template-columns: 1fr;
        }
    }

    .full-width-col {
        grid-column: span 2;
    }

    @media (max-width: 650px) {
        .full-width-col {
            grid-column: span 1;
        }
    }

    .form-group-item {
        display: flex;
        flex-direction: column;
    }

    .form-label-title {
        font-size: 13px;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 6px;
    }

    .form-input-control {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid #cbd5e0;
        border-radius: 10px;
        font-size: 14px;
        color: #1a202c;
        background: #fff;
        outline: none;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-input-control:focus {
        border-color: #00796b;
        box-shadow: 0 0 0 4px rgba(0, 121, 107, 0.12);
    }

    select.form-input-control {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23718096%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        background-size: 10px;
        padding-right: 35px;
    }

    .error-msg-text {
        color: #e53e3e;
        font-size: 12px;
        margin-top: 5px;
        font-weight: 500;
    }

    .btn-save-address {
        background: #00796b;
        color: white;
        border: none;
        padding: 13px 30px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 700;
        margin-top: 24px;
        transition: background 0.2s, transform 0.1s;
        box-shadow: 0 2px 8px rgba(0, 121, 107, 0.2);
    }

    .btn-save-address:hover {
        background: #005b50;
        transform: translateY(-1px);
    }

    /* Saved Addresses List Cards */
    .saved-addresses-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .address-item-box {
        margin-bottom: 0;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .address-item-box:hover {
        box-shadow: 0 6px 22px rgba(0, 0, 0, 0.06);
    }

    .address-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .address-name-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .address-fullname {
        font-size: 17px;
        color: #1a202c;
    }

    .address-type-pill {
        background: #e6f4f1;
        color: #00796b;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-delete-address {
        border: none;
        background: none;
        color: #e53e3e;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        padding: 6px 12px;
        border-radius: 6px;
        transition: background 0.2s;
    }

    .btn-delete-address:hover {
        background: #fff5f5;
    }

    .address-detail-text {
        color: #4a5568;
        line-height: 1.6;
        margin: 0 0 10px 0;
        font-size: 14px;
    }

    .address-mobile-text {
        color: #718096;
        margin: 0;
        font-size: 13px;
    }

    .address-mobile-text strong {
        color: #2d3748;
    }

    /* Empty State */
    .empty-state-box {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-icon-circle {
        font-size: 45px;
        color: #00796b;
        background: #e6f4f1;
        width: 85px;
        height: 85px;
        margin: 0 auto 16px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-title {
        font-size: 20px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 6px;
    }

    .empty-desc {
        color: #718096;
        font-size: 14px;
        margin: 0;
    }
</style>

@endsection
