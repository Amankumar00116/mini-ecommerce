@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')

<div class="edit-profile-wrapper">
    <div class="edit-profile-container">

        <!-- Back Link -->
        <a href="{{ route('my.account') }}" class="back-link">
            ← Back to My Account
        </a>

        <!-- Page Header -->
        <div class="edit-profile-header-flex">
            <h2 class="edit-profile-main-title">
                Edit Profile
            </h2>
            <span class="profile-subtitle-badge">Account Settings</span>
        </div>

        <!-- Status Alert -->
        @if (session('status') === 'profile-updated')
            <div class="status-success-alert">
                <i class="bi bi-check-circle-fill me-2"></i> Profile updated successfully.
            </div>
        @endif

        <!-- Form Card Box -->
        <div class="edit-profile-card">

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                <!-- Full Name Field -->
                <div class="form-group-box">
                    <label for="name" class="form-label-title">
                        <i class="bi bi-person me-1 text-teal"></i> Full Name
                    </label>

                    <input type="text"
                           id="name"
                           name="name"
                           value="{{ old('name', $user->name) }}"
                           required
                           class="form-input-control"
                           placeholder="Enter your full name">

                    @error('name')
                        <div class="error-msg-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email Address Field -->
                <div class="form-group-box">
                    <label for="email" class="form-label-title">
                        <i class="bi bi-envelope me-1 text-teal"></i> Email Address
                    </label>

                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email', $user->email) }}"
                           required
                           class="form-input-control"
                           placeholder="Enter your email address">

                    @error('email')
                        <div class="error-msg-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Mobile Number Field -->
                <div class="form-group-box mb-32">
                    <label for="mobile" class="form-label-title">
                        <i class="bi bi-phone me-1 text-teal"></i> Mobile Number
                    </label>

                    <input type="text"
                           id="mobile"
                           name="mobile"
                           value="{{ old('mobile', $user->mobile) }}"
                           maxlength="10"
                           placeholder="Enter 10-digit mobile number"
                           class="form-input-control">

                    @error('mobile')
                        <div class="error-msg-text">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons Row -->
                <div class="form-actions-row">
                    <button type="submit" class="btn-save-profile">
                        Save Changes
                    </button>

                    <a href="{{ route('my.account') }}" class="btn-cancel-link">
                        Cancel
                    </a>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- STYLING -->
<style>
    .edit-profile-wrapper {
        background: #f8f9fa;
        min-height: 85vh;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .edit-profile-container {
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

    .edit-profile-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .edit-profile-main-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin: 0;
    }

    .profile-subtitle-badge {
        background: #e6f4f1;
        color: #00796b;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 20px;
    }

    /* Success Alert Message */
    .status-success-alert {
        background: #e6f4f1;
        color: #00796b;
        border: 1px solid #b2dfdb;
        padding: 14px 18px;
        border-radius: 12px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Main Form Card */
    .edit-profile-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 36px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    }

    .form-group-box {
        margin-bottom: 22px;
    }

    .form-group-box.mb-32 {
        margin-bottom: 32px;
    }

    .form-label-title {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #2d3748;
        margin-bottom: 8px;
    }

    .text-teal {
        color: #00796b;
    }

    .form-input-control {
        width: 100%;
        padding: 13px 16px;
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

    .error-msg-text {
        color: #e53e3e;
        font-size: 13px;
        margin-top: 6px;
        font-weight: 500;
    }

    /* Actions */
    .form-actions-row {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-top: 6px;
        border-top: 1px solid #edf2f7;
    }

    .btn-save-profile {
        background: #00796b;
        color: white;
        border: none;
        padding: 13px 30px;
        border-radius: 10px;
        cursor: pointer;
        font-size: 15px;
        font-weight: 700;
        transition: background 0.2s, transform 0.1s;
        box-shadow: 0 2px 8px rgba(0, 121, 107, 0.2);
    }

    .btn-save-profile:hover {
        background: #005b50;
        transform: translateY(-1px);
    }

    .btn-cancel-link {
        color: #718096;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 16px;
        transition: color 0.2s;
    }

    .btn-cancel-link:hover {
        color: #1a202c;
    }
</style>

@endsection
