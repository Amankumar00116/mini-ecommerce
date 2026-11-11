@extends('layouts.app')

@section('title', 'My Account')

@section('content')

<div class="account-page-wrapper">

    <div class="account-container">

        <!-- PAGE TITLE -->
        <h2 class="account-title">
            My Account
        </h2>

        <!-- USER INFO CARD -->
        <div class="user-info-card">
            <h3 class="user-name">
                {{ auth()->user()->name }}
            </h3>
            <p class="user-email">
                {{ auth()->user()->email }}
            </p>
        </div>


        <!-- ACCOUNT OPTIONS LIST -->
        <div class="account-options-list">

            <!-- ORDERS -->
            <a href="{{ route('my.orders') }}" class="account-option-item">
                <div class="option-left">
                    <i class="bi bi-box-seam option-icon"></i>
                    <div>
                        <strong>My Orders</strong>
                        <div class="option-desc">View your orders</div>
                    </div>
                </div>
                <span class="arrow-icon">›</span>
            </a>

            <!-- HELP CENTER -->
            <a href="{{ route('help.center') }}" class="account-option-item">
                <div class="option-left">
                    <i class="bi bi-headset option-icon"></i>
                    <div>
                        <strong>Help Center</strong>
                        <div class="option-desc">Get help with your orders and account</div>
                    </div>
                </div>
                <span class="arrow-icon">›</span>
            </a>

            <!-- EDIT PROFILE -->
            <a href="{{ route('profile.edit') }}" class="account-option-item">
                <div class="option-left">
                    <i class="bi bi-person option-icon"></i>
                    <div>
                        <strong>Edit Profile</strong>
                        <div class="option-desc">Change your name, email and password</div>
                    </div>
                </div>
                <span class="arrow-icon">›</span>
            </a>

            <!-- SAVED ADDRESSES -->
            <a href="{{ route('saved.addresses') }}" class="account-option-item">
                <div class="option-left">
                    <i class="bi bi-geo-alt option-icon"></i>
                    <div>
                        <strong>Saved Addresses</strong>
                        <div class="option-desc">Manage your saved delivery addresses</div>
                    </div>
                </div>
                <span class="arrow-icon">›</span>
            </a>

            <!-- NOTIFICATIONS -->
            <a href="#" class="account-option-item">
                <div class="option-left">
                    <i class="bi bi-bell option-icon"></i>
                    <div>
                        <strong>Notifications</strong>
                        <div class="option-desc">Manage your notifications</div>
                    </div>
                </div>
                <span class="arrow-icon">›</span>
            </a>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-button-item">
                    <div class="option-left">
                        <i class="bi bi-box-arrow-right logout-icon"></i>
                        <strong>Logout</strong>
                    </div>
                </button>
            </form>

        </div>

    </div>

</div>


<!-- STYLING -->
<style>
    .account-page-wrapper {
        background: #f8f9fa;
        min-height: 80vh;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .account-container {
        max-width: 850px;
        margin: auto;
    }

    .account-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 24px;
    }

    .user-info-card {
        background: white;
        padding: 24px;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    .user-name {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin: 0 0 4px 0;
    }

    .user-email {
        color: #718096;
        font-size: 14px;
        margin: 0;
    }

    .account-options-list {
        background: white;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .account-option-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 24px;
        color: #2d3748;
        text-decoration: none;
        border-bottom: 1px solid #edf2f7;
        transition: background 0.2s ease;
    }

    .account-option-item:hover {
        background: #f8fafc;
    }

    .option-left {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .option-icon {
        font-size: 22px;
        color: #00796b;
    }

    .option-left strong {
        font-size: 15px;
        color: #1a202c;
    }

    .option-desc {
        color: #718096;
        font-size: 13px;
        margin-top: 3px;
    }

    .arrow-icon {
        font-size: 20px;
        color: #a0aec0;
        font-weight: 300;
    }

    /* Logout Button Styling */
    .logout-button-item {
        width: 100%;
        padding: 18px 24px;
        background: white;
        border: none;
        text-align: left;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: background 0.2s ease;
    }

    .logout-button-item:hover {
        background: #fff5f5;
    }

    .logout-icon {
        font-size: 22px;
        color: #e53e3e;
    }

    .logout-button-item strong {
        font-size: 15px;
        color: #e53e3e;
    }
</style>

@endsection
