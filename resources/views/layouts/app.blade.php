<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>@yield('title', 'MyShop')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary: #0F766E;
            --primary-dark: #0B5A54;
            --dark: #13262B;
            --text: #111827;
            --muted: #6b7280;
            --border: #e5e7eb;
            --radius: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-padding-top: 110px;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #f5f8f8;
            color: var(--text);
            -webkit-font-smoothing: antialiased;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        /* ================= Old navbar (agar kisi page me use ho) ================= */
        .navbar {
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 60px;
            background: #fff;
            border-bottom: 1px solid var(--border);
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--primary);
        }

        .nav-links {
            display: flex;
            gap: 32px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            font-size: 15px;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .login-btn {
            background: var(--primary);
            color: #fff !important;
            padding: 10px 20px;
            border-radius: 8px;
        }

        /* ================= Main content ================= */
        .main-content {
            min-width: 0;
            max-width: 1500px;
            margin: 0 auto;
            min-height: calc(100vh - 200px);
        }

        /* ================= Top navbar (Flipkart style) ================= */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 500;
            background: #fff;
            border-bottom: 1px solid var(--border);
        }

        .topbar-inner {
            max-width: 1500px;
            margin: 0 auto;
            padding: 0 24px;
            height: 68px;
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .tb-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
            text-decoration: none;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--primary);
        }

        .tb-logo i {
            font-size: 24px;
        }

        .tb-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 26px;
        }

        .tb-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 4px;
            color: #1f2937;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: color .2s;
        }

        .tb-item i {
            font-size: 22px;
            line-height: 1;
        }

        .tb-item:hover {
            color: var(--primary);
        }

        .tb-item .notification-badge {
            top: 0;
            right: -8px;
        }

        .tb-account {
            position: relative;
        }

        .tb-account .tb-chevron {
            font-size: 11px;
            transition: transform .2s;
        }

        .tb-account:hover .tb-chevron {
            transform: rotate(180deg);
        }

        /* Profile par cursor le jaane se khulne wala dropdown */
        .tb-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: -20px;
            width: 270px;
            padding-top: 12px;
            z-index: 600;
        }

        .tb-account:hover .tb-dropdown,
        .tb-account:focus-within .tb-dropdown {
            display: block;
        }

        .tb-dropdown-card {
            padding: 8px 0;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 12px 32px rgba(19, 38, 43, 0.16);
        }

        .tb-dd-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px 8px;
            font-size: 15px;
            font-weight: 600;
            color: #374151;
        }

        .tb-dd-head a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .tb-dd-divider {
            height: 1px;
            margin: 6px 0;
            background: #eef0f3;
        }

        .tb-dd-link {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 12px 20px;
            border: none;
            background: none;
            color: #1f2937;
            font-size: 15px;
            text-align: left;
            text-decoration: none;
            cursor: pointer;
            transition: background .15s, color .15s;
        }

        .tb-dd-link i {
            font-size: 18px;
        }

        .tb-dd-link:hover {
            background: #f0faf8;
            color: var(--primary);
        }

        /* ================= Meesho Style Category Navbar ================= */

        .catbar {
            position: relative;
            background: #fff;
            border-bottom: 1px solid var(--border);
            z-index: 450;
        }

        .catbar-inner {
            max-width: 1500px;
            min-height: 54px;
            margin: 0 auto;
            padding: 0 35px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .cat-link {
            display: flex;
            align-items: center;
            gap: 7px;
            height: 54px;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            white-space: nowrap;
            border-bottom: 3px solid transparent;
            transition: color .2s, border-color .2s;
        }

        .cat-link:hover {
            color: var(--primary);
            border-bottom-color: var(--primary);
        }

        .cat-link i {
            font-size: 11px;
        }

        /* Dropdown container */

        .cat-dropdown {
            position: relative;
            height: 54px;
        }

        /* Mega menu */

        .mega-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 480px;
            padding: 25px;
            background: #fff;
            border: 1px solid var(--border);
            box-shadow: 0 12px 30px rgba(0, 0, 0, .12);
            border-radius: 0 0 10px 10px;
            gap: 35px;
            z-index: 1000;
        }

        .cat-dropdown:hover .mega-menu,
        .cat-dropdown:focus-within .mega-menu {
            display: flex;
        }

        .mega-column {
            min-width: 130px;
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        .mega-column h4 {
            color: var(--primary);
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .mega-column a {
            color: #6b7280;
            font-size: 13px;
            text-decoration: none;
        }

        .mega-column a:hover {
            color: var(--primary);
        }

        /* ================= Search bar ================= */
        .search-container {
            width: 100%;
            display: flex;
            justify-content: center;
            position: relative;
        }

        .topbar .search-container {
            flex: 1;
            max-width: 680px;
            justify-content: flex-start;
        }

        .search-form {
            display: flex;
            align-items: center;
            width: 100%;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            overflow: hidden;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: border-color .2s, box-shadow .2s;
        }

        .search-form:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
        }

        .search-input {
            flex: 1;
            min-width: 0;
            padding: 12px 15px;
            border: none;
            outline: none;
            font-size: 15px;
            background: transparent;
        }

        .search-input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 16px;
            pointer-events: none;
        }

        .search-form .search-input {
            padding-left: 42px;
        }

        .search-button {
            padding: 12px 18px;
            border: none;
            background: var(--primary);
            color: #fff;
            cursor: pointer;
            transition: background .2s;
        }

        .search-button:hover {
            background: var(--primary-dark);
        }

        .search-suggestions {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            margin-top: 6px;
            background: #fff;
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            z-index: 1000;
        }

        .suggestion-item {
            padding: 12px 16px;
            cursor: pointer;
            color: #374151;
            font-size: 14px;
        }

        .suggestion-item:hover {
            background: #f3f6fb;
        }

        /* ================= Header badges ================= */
        .notification-badge {
            position: absolute;
            top: -7px;
            right: -9px;
            background: red;
            color: white;
            font-size: 10px;
            width: 17px;
            height: 17px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bag-symbol {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .cart-count {
            position: absolute;
            top: -9px;
            right: -12px;
            min-width: 18px;
            height: 18px;
            padding: 0 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ef4444;
            color: #fff;
            border-radius: 999px;
            font-size: 11px;
            font-weight: 700;
            z-index: 10;
        }

        /* ================= Firebase notification prompt ================= */
        .notification-prompt-trigger {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: #fff;
            color: var(--primary);
            font-size: 21px;
            cursor: pointer;
            flex-shrink: 0;
            transition: background .2s, color .2s, border-color .2s;
        }

        .notification-prompt-trigger:hover {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        /* Popup ka dark transparent background */
        .notification-prompt-overlay {
            display: none;
            position: fixed;
            inset: 0;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: rgba(15, 23, 42, .55);
            z-index: 2000;
        }

        /* Popup ka main white card */
        .notification-prompt-card {
            width: 100%;
            max-width: 380px;
            padding: 30px 26px;
            border-radius: 16px;
            background: #fff;
            text-align: center;
            box-shadow: 0 20px 55px rgba(0, 0, 0, .2);
        }

        .notification-prompt-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: #e6f4f1;
            color: var(--primary);
            font-size: 27px;
        }

        .notification-prompt-card h3 {
            margin: 0 0 10px;
            color: var(--dark);
            font-size: 21px;
            font-weight: 700;
        }

        .notification-prompt-card p {
            margin: 0 0 22px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .notification-prompt-card button {
            display: block;
            width: 100%;
            padding: 12px 16px;
            border: 0;
            border-radius: 9px;
            background: var(--primary);
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .notification-prompt-card button:hover {
            background: var(--primary-dark);
        }

        .notification-prompt-card>a {
            display: inline-block;
            margin-top: 16px;
            color: var(--muted);
            font-size: 13px;
            text-decoration: none;
        }

        .notification-prompt-card>a:hover {
            color: var(--primary);
        }

        /* Success Toast */
        .success-toast {
            position: fixed;
            top: 25px;
            right: 25px;
            background: #ffffff;
            color: #198754;
            padding: 15px 22px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 99999;
            font-size: 15px;
            font-weight: 600;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-15px);
            transition: all 0.3s ease;
        }

        .success-toast.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .success-toast i {
            font-size: 20px;
        }

        /* ================= Hero ================= */
        .hero {
            position: relative;
            min-height: 420px;
            background-image:
                linear-gradient(90deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.5) 30%, rgba(255, 255, 255, 0) 50%),
                url('{{ asset('assets/images/hero-image1.png') }}');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            display: flex;
            align-items: center;
            padding: 45px 60px;
            border-radius: 18px;
            margin: 20px 25px 0;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(23, 35, 55, 0.08);
        }

        .hero-content {
            width: 50%;
            max-width: 520px;
        }

        .hero-content h1 {
            font-size: clamp(32px, 3.2vw, 50px);
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -1px;
            color: var(--dark);
            margin-bottom: 18px;
        }

        .hero-content h1 span {
            color: var(--primary);
        }

        .hero-content p {
            font-size: 16px;
            line-height: 1.75;
            color: #4b5563;
            margin-bottom: 28px;
        }

        .shop-btn {
            display: inline-block;
            background: var(--primary);
            color: #fff;
            padding: 14px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 6px 16px rgba(15, 118, 110, 0.3);
            transition: background .2s, transform .2s, box-shadow .2s;
        }

        .shop-btn:hover {
            background: var(--primary-dark);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(15, 118, 110, 0.35);
        }

        /* ================= Sections / Categories ================= */
        .section {
            padding: 50px 60px;
            width: 100%;
        }

        .section-title {
            font-size: 26px;
            color: var(--text);
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 26px;
        }

        .section-title::after {
            content: '';
            display: block;
            width: 48px;
            height: 3px;
            margin-top: 10px;
            background: var(--primary);
            border-radius: 2px;
        }

        .categories {
            display: grid !important;
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 18px;
            width: 100%;
        }

        .category {
            display: block;
            width: 100%;
            height: 300px;
            min-width: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            border-radius: var(--radius);
            text-decoration: none;
            cursor: pointer;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            transition: transform .3s ease, box-shadow .3s ease;
        }

        .category:hover {
            transform: translateY(-5px);
            box-shadow: 0 14px 28px rgba(0, 0, 0, 0.16);
        }

        /* Last row ko center karne ke liye (sirf desktop par) */
        @media (min-width: 1101px) {
            .category:nth-child(13) {
                grid-column: 2;
            }

            .category:nth-child(14) {
                grid-column: 3;
            }

            .category:nth-child(15) {
                grid-column: 4;
            }
        }

        /* ================= Products ================= */
        .products {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr));
            gap: 20px;
            width: 100%;
        }

        .product-card {
            width: 100%;
            min-width: 0;
            padding: 12px;
            background: #fff;
            border: 1px solid #eef0f3;
            border-radius: var(--radius);
            transition: box-shadow .25s, transform .25s;
        }

        .product-card:hover {
            box-shadow: 0 12px 26px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        .product-card .product-image {
            width: 100%;
            height: 230px;
            object-fit: cover;
            display: block;
            border-radius: 8px;
        }

        .product-card h3 {
            font-size: 16px;
            font-weight: 600;
            margin: 10px 0 6px;
        }

        .product-card .price {
            font-size: 17px;
            margin-bottom: 8px;
            font-weight: 700;
            color: var(--primary);
        }

        .product-card form {
            width: 100%;
        }

        .product-card form label {
            display: block;
            margin-top: 10px;
            margin-bottom: 5px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .product-card form select,
        .product-card form input {
            width: 100%;
            padding: 9px 10px;
            border: 1px solid var(--border);
            border-radius: 8px;
            margin-bottom: 8px;
            font-size: 14px;
            outline: none;
        }

        .product-card form select:focus,
        .product-card form input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.12);
        }

        .product-card form .book-btn {
            display: block;
            width: 100%;
            padding: 11px;
            margin-top: 10px;
            border: none;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: background .2s;
        }

        .product-card form .book-btn:hover {
            background: var(--primary-dark);
        }

        /* ================= Footer ================= */
        .footer {
            background: var(--dark);
            color: #fff;
            padding: 50px 60px 30px;
            margin-top: 40px;
            width: 100%;
        }

        .footer-content {
            max-width: 1500px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1.5fr;
            gap: 40px;
        }

        .footer h3 {
            color: #fff;
            margin-bottom: 16px;
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .footer p {
            color: #94a3b8;
            font-size: 14px;
            line-height: 1.5;
            margin: 6px 0;
            cursor: pointer;
            transition: color .2s;
        }

        .footer p:hover {
            color: #fff;
        }

        .app-buttons {
            display: flex !important;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .app-buttons img {
            width: 150px !important;
            height: auto !important;
            display: block !important;
        }

        .app-buttons+p {
            margin-top: 14px;
            color: #5eead4;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 14px;
        }

        .social-icons a {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            color: #fff;
            font-size: 18px;
            text-decoration: none;
            transition: background .2s, transform .2s;
        }

        .social-icons a:hover {
            background: #14b8a6;
            transform: translateY(-2px);
        }

        .copyright {
            max-width: 1500px;
            margin: 36px auto 0;
            text-align: center;
            border-top: 1px solid #2a4249;
            padding-top: 20px;
            font-size: 13px;
            color: #94a3b8;
        }

        /* ================= Admin dashboard sidebar ================= */
        .sidebar-heading {
            color: #8fa3bf;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 0 12px;
            margin: 24px 0 10px;
        }

        .sidebar-link {
            display: block;
            color: #dce5f1;
            text-decoration: none;
            padding: 11px 12px;
            border-radius: 8px;
            margin-bottom: 5px;
            font-size: 15px;
            transition: background .2s, color .2s;
        }

        .sidebar-link:hover {
            background: #24414a;
            color: #fff;
        }


        /* ================= Responsive ================= */
        @media (max-width: 1100px) {
            .categories {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .footer-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 1000px) {
            .hero {
                padding: 35px;
            }

            .hero-content {
                width: 60%;
            }
        }

        @media (max-width: 900px) {
            .products {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        /* Mobile */
        @media (max-width: 768px) {
            .topbar-inner {
                flex-wrap: wrap;
                height: auto;
                padding: 10px 14px;
                gap: 10px 16px;
            }

            .tb-logo {
                font-size: 22px;
            }

            .topbar .search-container {
                order: 3;
                flex: 1 1 100%;
                max-width: 100%;
            }

            .tb-actions {
                gap: 16px;
            }

            .tb-label {
                display: none;
            }

            .tb-dropdown {
                right: -10px;
            }

            .catbar-inner {
                justify-content: flex-start;
                overflow-x: auto;
                scrollbar-width: none;
                gap: 22px;
            }

            .catbar-inner::-webkit-scrollbar {
                display: none;
            }

            .mega-menu {
                min-width: 300px;
                max-width: 90vw;
                gap: 20px;
                flex-wrap: wrap;
            }

            .cat-item {
                padding: 9px 16px 8px;
            }

            .footer {
                padding: 36px 20px 24px;
            }
        }

        @media (max-width: 650px) {
            .hero {
                min-height: 320px;
                margin: 10px;
                padding: 25px 20px;
                background-position: 80% top;
                background-image:
                    linear-gradient(90deg, rgba(255, 255, 255, 0.92) 0%, rgba(255, 255, 255, 0.75) 60%, rgba(255, 255, 255, 0.3) 100%),
                    url('{{ asset('assets/images/hero-image1.png') }}');
            }

            .hero-content {
                width: 80%;
            }

            .hero-content h1 {
                font-size: 28px;
            }

            .hero-content p {
                font-size: 14px;
            }

            .section {
                padding: 28px 15px;
            }

            .section-title {
                font-size: 22px;
            }

            .categories {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .category {
                height: 190px;
            }

            .products {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .product-card .product-image {
                height: 170px;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 28px;
            }

            .app-buttons img {
                width: 130px !important;
            }
        }
    </style>
</head>

<body>

    {{-- Admin dashboard layout; the matching @endif is near the end of the file. --}}
    @if (request()->routeIs('dashboard'))

        <!-- ================= ADMIN DASHBOARD ================= -->

        <!-- Dashboard Sidebar -->
        <aside
            style="
        width:220px;
        height:100vh;
        position:fixed;
        left:0;
        top:0;
        background:#172337;
        padding:25px 15px;
        z-index:1000;
    ">

            <div
                style="
            color:white;
            font-size:30px;
            font-weight:bold;
            margin-bottom:30px;
            padding-left:10px;
        ">
                MyShop Admin
            </div>


            <a href="{{ route('dashboard') }}"
                style="
               display:block;
               color:white;
               text-decoration:none;
               padding:12px 15px;
               border-radius:6px;
               margin-bottom:8px;
               font-size: 20px;
           ">
                ▦ &nbsp; Dashboard
            </a>

            {{-- Product Group --}}
            <div
                style="
        color:#8fa3bf;
        font-size:11px;
        font-weight:bold;
        letter-spacing:1px;
        padding:0 12px;
        margin:24px 0 10px;
    ">
                PRODUCT CATALOG
            </div>

            <a href="{{ url('/products') }}" class="sidebar-link">
                ▣ &nbsp; Products
            </a>


            <a href="{{ url('/products/create') }}" class="sidebar-link">
                ＋ &nbsp; Add Product
            </a>

            <a href="#" class="sidebar-link">
                ◈ &nbsp; Categories
            </a>

            {{-- Order Group --}}

            <div class="sidebar-heading">
                ORDER MANAGEMENT
            </div>

            <a href="{{ route('admin.orders') }}" class="sidebar-link">
                ▤ &nbsp; Orders
            </a>

            <!-- Delivery Group -->
            <div class="sidebar-heading">
                DELIVERY MANAGEMENT
            </div>

            <a href="#" class="sidebar-link">
                ♙ &nbsp; Delivery Boys
            </a>

            <a href="#" class="sidebar-link">
                ⇄ &nbsp; Assign Orders
            </a>

            <a href="#" class="sidebar-link">
                ⌖ &nbsp; State Management
            </a>

            <a href="#" class="sidebar-link">
                ◎ &nbsp; Delivery Tracking
            </a>
        </aside>


        <!-- Right Side -->
        <div style="margin-left:220px; min-height:100vh;">

            <!-- Breeze Navbar -->
            @include('layouts.navigation')


            <!-- Dashboard Header -->
            @if (isset($header))
                <header
                    style="
                background:white;
                border-bottom:1px solid #eee;
            ">

                    <div style="
                    padding:20px 30px;
                ">
                        {{ $header }}
                    </div>

                </header>
            @endif


            <!-- Dashboard Content -->
            <main>

                {{ $slot }}

            </main>

        </div>
    @else
        <!-- ================= FRONTEND CUSTOMER LAYOUT ================= -->

        @if (request()->routeIs('dashboard'))
            @include('layouts.navigation')
        @endif


        {{-- ================= TOP NAVBAR ================= --}}
        <header class="topbar">
            <div class="topbar-inner">

                <a href="{{ url('/') }}" class="tb-logo">
                    <i class="bi bi-bag-heart-fill"></i>
                    MyShop
                </a>

                {{-- Search Bar --}}
                <div class="search-container">
                    <form action="{{ route('products.search') }}" method="get" class="search-form">

                        <i class="bi bi-search search-input-icon"></i>

                        <input type="text" name="query" id="searchInput"
                            placeholder="Search for products, brands and more..." class="search-input"
                            value="{{ request('query') }}" autocomplete="off">

                        <button type="submit" class="search-button">
                            <i class="bi bi-search"></i>
                        </button>

                    </form>

                    {{-- Search Suggestions --}}
                    <div id="searchSuggestions" class="search-suggestions"></div>
                </div>

                <div class="tb-actions">

                    {{-- Profile: cursor le jaane par dropdown khulega --}}
                    <div class="tb-account">
                        @auth
                            <a href="{{ route('profile.edit') }}" class="tb-item">
                                <i class="bi bi-person-circle"></i>
                                <span
                                    class="tb-label">{{ \Illuminate\Support\Str::limit(auth()->user()->name, 12) }}</span>
                                <i class="bi bi-chevron-down tb-chevron"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="tb-item">
                                <i class="bi bi-person-circle"></i>
                                <span class="tb-label">Login</span>
                                <i class="bi bi-chevron-down tb-chevron"></i>
                            </a>
                        @endauth

                        <div class="tb-dropdown">
                            <div class="tb-dropdown-card">

                                @guest
                                    <div class="tb-dd-head">
                                        <span>New customer?</span>
                                        @if (Route::has('register'))
                                            <a href="{{ route('register') }}">Sign Up</a>
                                        @endif
                                    </div>
                                    <div class="tb-dd-divider"></div>
                                @endguest

                                @auth
                                    <div class="tb-dd-head"><span>Your Account</span></div>
                                @endauth

                                <a href="{{ route('my.account') }}" class="tb-dd-link">
                                    <i class="bi bi-person-circle"></i> My Account
                                </a>

                                <a href="{{ url('/my-orders') }}" class="tb-dd-link">
                                    <i class="bi bi-box-seam"></i> My Orders
                                </a>

                                <a href="{{ route('profile.edit') }}" class="tb-dd-link">
                                    <i class="bi bi-gear"></i> Edit Profile
                                </a>

                                <a href="{{ route('notifications.index') }}" class="tb-dd-link">
                                    <i class="bi bi-bell"></i> Notifications
                                </a>

                                @auth
                                    <div class="tb-dd-divider"></div>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="tb-dd-link">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                @endauth

                            </div>
                        </div>
                    </div>

                    {{-- Notification history: opens saved Laravel notifications --}}
                    <a href="{{ route('notifications.index') }}" class="tb-item" title="Notifications">
                        <i class="bi bi-bell"></i>

                        @if (auth()->check() && auth()->user()->unreadNotifications()->count() > 0)
                            <span class="notification-badge">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        @endif
                    </a>

                    {{-- Cart --}}
                    <a href="{{ route('cart.index') }}" class="tb-item" title="Cart">
                        <span class="bag-symbol">
                            <i class="bi bi-bag"></i>

                            @auth
                                @php
                                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                                @endphp

                                @if ($cartCount > 0)
                                    <span class="cart-count">{{ $cartCount }}</span>
                                @endif
                            @endauth
                        </span>

                        <span class="tb-label">Cart</span>
                    </a>

                </div>
            </div>
        </header>

        {{-- ================= MEESHO STYLE CATEGORY ROW ================= --}}

        <nav class="catbar">
            <div class="catbar-inner">

                <a href="{{ url('/') }}" class="cat-link">
                    Home
                </a>

                <a href="{{ url('/#products') }}" class="cat-link">
                    Products
                </a>

                {{-- Men Dropdown --}}
                <div class="cat-dropdown">
                    <a href="{{ route('category.group', 'men') }}" class="cat-link">
                        Men
                        <i class="bi bi-chevron-down"></i>
                    </a>

                    <div class="mega-menu">
                        <div class="mega-column">
                            <h4>Men's Clothing</h4>
                            <a href="{{ route('category.show', 6) }}">Men's Casual Wear</a>
                            <a href="{{ route('category.show', 7) }}">Men's Activewear</a>
                            <a href="{{ route('category.show', 11) }}">Sportswear</a>
                            <a href="{{ route('category.show', 12) }}">Innerwear</a>
                        </div>

                        <div class="mega-column">
                            <h4>Accessories</h4>
                            <a href="{{ route('category.show', 13) }}">Watches</a>
                            <a href="{{ route('category.show', 14) }}">Grooming</a>
                            <a href="{{ route('category.show', 18) }}">Bags, Belts & Wallets</a>
                            <a href="{{ route('category.show', 19) }}">Headphones & Audio</a>
                        </div>

                        <div class="mega-column">
                            <h4>Footwear</h4>
                            <a href="{{ route('category.show', 16) }}">Men's Footwear</a>
                        </div>
                    </div>
                </div>

                {{-- Women Dropdown --}}
                <div class="cat-dropdown">
                    <a href="{{ route('category.group', 'women') }}" class="cat-link">
                        Women
                        <i class="bi bi-chevron-down"></i>
                    </a>

                    <div class="mega-menu">
                        <div class="mega-column">
                            <h4>Women's Clothing</h4>
                            <a href="{{ route('category.show', 8) }}">Ethnic Wear</a>
                            <a href="{{ route('category.show', 9) }}">Women's Activewear</a>
                            <a href="{{ route('category.show', 10) }}">Western Wear</a>
                            <a href="{{ route('category.show', 21) }}">Sleepwear</a>
                        </div>

                        <div class="mega-column">
                            <h4>Accessories</h4>
                            <a href="{{ route('category.show', 13) }}">Watches</a>
                            <a href="{{ route('category.show', 14) }}">Grooming</a>
                            <a href="{{ route('category.show', 18) }}">Bags, Belts & Wallets</a>
                        </div>

                        <div class="mega-column">
                            <h4>Footwear</h4>
                            <a href="{{ route('category.show', 17) }}">Women's Footwear</a>
                        </div>
                    </div>
                </div>

                {{-- Kids Dropdown --}}
                <div class="cat-dropdown">
                    <a href="{{ route('category.group', 'kids') }}" class="cat-link">
                        Kids
                        <i class="bi bi-chevron-down"></i>
                    </a>

                    <div class="mega-menu">
                        <div class="mega-column">
                            <h4>Kids Collection</h4>
                            <a href="{{ route('category.show', 15) }}">Kids Wear</a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('category.show', 13) }}" class="cat-link">
                    Smart Watches
                </a>

                <a href="{{ route('category.show', 19) }}" class="cat-link">
                    Electronics
                </a>

            </div>
        </nav>

        <!-- Frontend Main Content -->
        <main class="main-content">

            {{-- Search suggestions script --}}
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const input = document.getElementById('searchInput');
                    const suggestionsBox = document.getElementById('searchSuggestions');

                    if (!input || !suggestionsBox) return;

                    input.addEventListener('input', async function() {
                        const query = input.value.trim();

                        suggestionsBox.innerHTML = '';

                        if (query.length < 2) {
                            suggestionsBox.style.display = 'none';
                            return;
                        }

                        try {
                            const response = await fetch(
                                `{{ route('products.suggestions') }}?query=${encodeURIComponent(query)}`
                            );

                            if (!response.ok) throw new Error('Suggestion request failed');

                            const data = await response.json();
                            const suggestions = [
                                ...(data.products || []),
                                ...(data.categories || [])
                            ];

                            const uniqueSuggestions = [...new Set(suggestions)];

                            uniqueSuggestions.forEach(function(name) {
                                const item = document.createElement('div');
                                item.className = 'suggestion-item';
                                item.textContent = name;

                                item.addEventListener('click', function() {
                                    input.value = name;
                                    suggestionsBox.style.display = 'none';
                                    input.form.requestSubmit();
                                });

                                suggestionsBox.appendChild(item);
                            });

                            suggestionsBox.style.display =
                                uniqueSuggestions.length ? 'block' : 'none';
                        } catch (error) {
                            suggestionsBox.style.display = 'none';
                            console.error('Search suggestions error:', error);
                        }
                    });

                    document.addEventListener('click', function(event) {
                        if (!event.target.closest('.search-container')) {
                            suggestionsBox.style.display = 'none';
                        }
                    });
                });
            </script>

            @yield('content')

            @isset($slot)
                {{ $slot }}
            @endisset

        </main>


        <!-- Frontend Footer -->
        <footer class="footer">

            <div class="footer-content">

                <div>
                    <h3>MyShop</h3>
                    <p>Better Products. Better Life.</p>
                </div>

                <div>
                    <h3>Quick Links</h3>
                    <p>Home</p>
                    <p>Products</p>
                    <p>About</p>
                </div>

                <div>
                    <h3>Contact</h3>
                    <p>Email: support@myshop.com</p>
                    <p>Phone: +91 98765 43210</p>
                    <p>FAQ</p>
                    <P>T&C</P>
                    <P>Terms Of Use</P>
                    <P>Track Orders</P>
                    <P>Shipping</P>
                    <p>Privacy Policy</p>
                    <p>Cancellation</p>
                </div>

                <div>
                    <h3>MyShop App ON MOBILE</h3>

                    <div class="app-buttons">
                        <img src="{{ asset('assets/images/mobile-app.png') }}" alt="Google play">

                        <img src="{{ asset('assets/images/app-store-badge(1).png') }}" alt="App-store">

                    </div>

                    <p>KEEP ON TOUCH.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
            <div class="copyright">
                &copy; 2026 MyShop. All rights reserved.
            </div>

        </footer>

    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrV6XK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>

    {{-- First-Time Notification Popup --}}
    @if (session('show_notification_prompt') && auth()->check() && auth()->user()->role === 'customer')
        <div id="notificationPrompt" class="notification-prompt-overlay" style="display: flex;">

            <div class="notification-prompt-card">

                <div class="notification-prompt-icon">
                    <i class="bi bi-bell-fill"></i>
                </div>

                <h3>Stay Updated!</h3>

                <p>
                    Get instant updates about your order status and delivery.
                </p>

                <button type="button" onclick="window.enableNotifications()">
                    Enable Notifications
                </button>

                <a href="{{ route('notifications.index') }}">
                    Maybe Later
                </a>

            </div>

        </div>
    @endif
    <!-- Success Toast -->
    <div id="successToast" class="success-toast">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMessage"></span>
    </div>
</body>


</html>
