@extends('layouts.app')

@section('title', 'Help Center')

@section('content')

<div class="help-page-wrapper">

    <div class="help-container">

        <!-- Back Link -->
        <a href="{{ route('my.account') }}" class="back-link">
            ← Back to My Account
        </a>

        <!-- Page Title -->
        <h2 class="help-main-title">
            Help Center
        </h2>

        <!-- Top Greeting Banner -->
        <div class="help-card-box">
            <h3 class="help-card-heading">
                How can we help you?
            </h3>
            <p class="help-card-desc">
                Find answers to common questions about your orders and account.
            </p>
        </div>

        <!-- FAQ Section -->
        <div class="help-card-box">
            <h3 class="help-card-heading" style="margin-bottom: 20px;">
                Frequently Asked Questions
            </h3>

            <div class="faq-item">
                <strong class="faq-question">How can I track my order?</strong>
                <p class="faq-answer">
                    Go to My Orders and select Track Order to check your order status.
                </p>
            </div>

            <div class="faq-item">
                <strong class="faq-question">How can I cancel my order?</strong>
                <p class="faq-answer">
                    Contact our support team for help with an order cancellation.
                </p>
            </div>

            <div class="faq-item">
                <strong class="faq-question">How can I change my delivery address?</strong>
                <p class="faq-answer">
                    Visit Saved Addresses to manage your delivery addresses.
                </p>
            </div>

            <div class="faq-item last-faq">
                <strong class="faq-question">How can I reset my password?</strong>
                <p class="faq-answer">
                    Use the Forgot Password option on the login page to reset your password.
                </p>
            </div>
        </div>

        <!-- Support Contact Banner -->
        <div class="help-card-box support-banner">
            <div class="support-content">
                <h3 class="help-card-heading" style="margin-bottom: 6px;">
                    Need more help?
                </h3>
                <p class="help-card-desc" style="margin: 0;">
                    Please contact our support team for further assistance.
                </p>
            </div>
            <a href="mailto:support@myshop.com" class="btn-support-contact">
                Contact Support
            </a>
        </div>

    </div>

</div>


<!-- STYLING -->
<style>
    .help-page-wrapper {
        background: #f8f9fa;
        min-height: 85vh;
        padding: 40px 20px;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    .help-container {
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

    .help-main-title {
        font-size: 26px;
        font-weight: 700;
        color: #1a202c;
        margin-bottom: 24px;
    }

    /* Common Card Box Styling */
    .help-card-box {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 28px;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
        margin-bottom: 20px;
    }

    .help-card-heading {
        font-size: 18px;
        font-weight: 700;
        color: #1a202c;
        margin: 0 0 6px 0;
    }

    .help-card-desc {
        color: #718096;
        font-size: 14px;
        margin: 0;
        line-height: 1.5;
    }

    /* FAQ List Styles */
    .faq-item {
        padding: 16px 0;
        border-bottom: 1px solid #edf2f7;
    }

    .faq-item.last-faq {
        border-bottom: none;
        padding-bottom: 0;
    }

    .faq-item:first-of-type {
        padding-top: 0;
    }

    .faq-question {
        font-size: 15px;
        color: #1a202c;
        font-weight: 600;
    }

    .faq-answer {
        color: #718096;
        font-size: 14px;
        margin: 6px 0 0 0;
        line-height: 1.5;
    }

    /* Support Banner */
    .support-banner {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #e6f4f1;
        border: 1px solid #b2dfdb;
    }

    @media (max-width: 600px) {
        .support-banner {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
    }

    .btn-support-contact {
        padding: 10px 20px;
        background: #00796b;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: background 0.2s;
        box-shadow: 0 2px 8px rgba(0, 121, 107, 0.2);
        white-space: nowrap;
    }

    .btn-support-contact:hover {
        background: #005b50;
        color: white;
    }
</style>

@endsection
