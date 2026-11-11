
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>@yield('title', 'MyShop Admin')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .admin-sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #172337;
            padding: 22px 14px;
            overflow-y: auto;
            z-index: 1000;
        }

        .admin-brand {
            color: white;
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 25px;
            padding-left: 10px;
        }

        .sidebar-heading {
            color: #91a0b8;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 22px 10px 8px;
        }

        .sidebar-link {
            display: block;
            color: #fff;
            text-decoration: none;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 4px;
            font-size: 15px;
        }

        .sidebar-link:hover {
            background: #293b55;
            color: white;
        }

        .admin-main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .page-content {
            padding: 30px;
            background: #f8f9fa;
            min-height: calc(100vh - 80px);
        }
    </style>
</head>

<body>

    <!-- ADMIN SIDEBAR -->
    <aside class="admin-sidebar">

        <div class="admin-brand">
            MyShop Admin
        </div>

        <a href="{{ route('dashboard') }}" class="sidebar-link">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
        </a>

        <!-- PRODUCT CATALOG -->
        <div class="sidebar-heading">
            PRODUCT CATALOG
        </div>

        <a href="{{ url('/products') }}" class="sidebar-link">
            <i class="bi bi-box-seam me-2"></i>
            Products
        </a>

        <a href="{{ url('/products/create') }}" class="sidebar-link">
            <i class="bi bi-plus-circle me-2"></i>
            Add Product
        </a>

        <a href="#" class="sidebar-link">
            <i class="bi bi-tags me-2"></i>
            Categories
        </a>

        <!-- ORDER MANAGEMENT -->
        <div class="sidebar-heading">
            ORDER MANAGEMENT
        </div>

        <a href="{{ route('admin.orders') }}" class="sidebar-link">
            <i class="bi bi-cart-check me-2"></i>
            Orders
        </a>

        <!-- DELIVERY MANAGEMENT -->
        <div class="sidebar-heading">
            DELIVERY MANAGEMENT
        </div>

        <a href="{{ route('admin.delivery-boys.index') }}" class="sidebar-link">
            <i class="bi bi-people me-2"></i>
            Delivery Boy
        </a>

        <a href="{{ route('admin.assign-orders') }}" class="sidebar-link">
            <i class="bi bi-truck me-2"></i>
            Assign Orders
        </a>

        <a href="#" class="sidebar-link">
            <i class="bi bi-geo-alt me-2"></i>
            State Management
        </a>

        <a href="#" class="sidebar-link">
            <i class="bi bi-geo me-2"></i>
            Delivery Tracking
        </a>

    </aside>

    <!-- RIGHT SIDE -->
    <div class="admin-main">

        @include('layouts.navigation')

        <!-- PAGE HEADER -->
        @hasSection('header')
            <header style="background:white; border-bottom:1px solid #eee;">
                <div style="padding:20px 30px;">
                    @yield('header')
                </div>
            </header>
        @endif

        <!-- PAGE CONTENT -->
        <main class="page-content">
            @yield('content')
        </main>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
