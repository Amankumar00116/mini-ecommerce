
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Delivery Dashboard')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .delivery-sidebar {
            width: 250px;
            height: 100vh;
            background: #202b3c;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding: 22px 15px;
        }

        .delivery-sidebar h2 {
            margin: 0 0 30px;
            font-size: 21px;
        }

        .delivery-sidebar a {
            display: block;
            color: #dce3ed;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 6px;
            margin-bottom: 7px;
        }

        .delivery-sidebar a:hover,
        .delivery-sidebar a.active {
            background: #1677ff;
            color: white;
        }

        .delivery-main {
            margin-left: 250px;
        }

        .delivery-header {
            background: white;
            padding: 18px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px #0000000d;
        }

        .delivery-header h3 {
            margin: 0;
        }

        .delivery-content {
            padding: 25px;
        }

        .delivery-logout {
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }

        @media (max-width: 700px) {
            .delivery-sidebar {
                width: 190px;
            }

            .delivery-main {
                margin-left: 190px;
            }

            .delivery-content {
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <aside class="delivery-sidebar">
        <h2>Delivery Panel</h2>

        <a href="{{ route('delivery-boy.dashboard') }}"
           class="{{ request()->routeIs('delivery-boy.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('delivery-boy.my-orders') }}"
        class="{{ request()->routeIs('delivery-boy.my-orders') ? 'active' : '' }}">
            My Orders
        </a>

        <a href="{{ route('delivery-boy.assigned-deliveries') }}">
            Assigned Deliveries
        </a>

        <a href="{{ route('delivery-boy.completed-orders') }}">
            Completed Orders
        </a>

        <a href="{{ route('delivery-boy.profile') }}">
            My Profile
        </a>
    </aside>

    <div class="delivery-main">

        <header class="delivery-header">
            <h3>@yield('header', 'Delivery Dashboard')</h3>

            <div>
                {{ auth()->user()->name }}

                <form method="POST" action="{{ route('logout') }}"
                      style="display:inline; margin-left:12px;">
                    @csrf
                    <button type="submit" class="delivery-logout">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <main class="delivery-content">
            @yield('content')
        </main>

    </div>

</body>
</html>
