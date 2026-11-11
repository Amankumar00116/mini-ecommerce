
@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

<style>
.dashboard-content {
    padding: 25px;
}
.dashboard-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 25px;
}
.stat-card, .dashboard-card {
    background: #fff;
    padding: 22px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.stat-card h3 {
    color: #64748b;
    font-size: 14px;
    margin: 0 0 12px;
}
.stat-card strong {
    font-size: 28px;
    color: #172554;
}
.dashboard-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.dashboard-card {
    margin-bottom: 20px;
    overflow-x: auto;
}
.dashboard-card h3 {
    margin-top: 0;
}
.dashboard-table {
    width: 100%;
    border-collapse: collapse;
}
.dashboard-table th,
.dashboard-table td {
    padding: 13px;
    text-align: left;
    border-bottom: 1px solid #e5e7eb;
}
.dashboard-table th {
    background: #f8fafc;
}
.status-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.status-item {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}
.quick-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}
.quick-action {
    padding: 12px 16px;
    background: #eff6ff;
    color: #1d4ed8;
    border-radius: 7px;
    text-decoration: none;
}
@media(max-width: 900px) {
    .dashboard-stats { grid-template-columns: repeat(2, 1fr); }
    .dashboard-grid { grid-template-columns: 1fr; }
}
@media(max-width: 500px) {
    .dashboard-stats { grid-template-columns: 1fr; }
}
</style>

<div class="dashboard-content">

    <div class="dashboard-stats">
        <div class="stat-card">
            <h3>Total Orders</h3>
            <strong>{{ $totalOrders ?? 0 }}</strong>
        </div>

        <div class="stat-card">
            <h3>Total Customers</h3>
            <strong>{{ $totalCustomers ?? 0 }}</strong>
        </div>

        <div class="stat-card">
            <h3>Delivery Boys</h3>
            <strong>{{ $totalDeliveryBoys ?? 0 }}</strong>
        </div>

        <div class="stat-card">
            <h3>Total Products</h3>
            <strong>{{ $totalProducts ?? 0 }}</strong>
        </div>
    </div>

    <div class="dashboard-grid">

        <div class="dashboard-card">
            <h3>Order Status</h3>

            <div class="status-list">
                @forelse(($orderStatuses ?? []) as $status => $count)
                    <div class="status-item">
                        <span>{{ $status }}</span>
                        <strong>{{ $count }}</strong>
                    </div>
                @empty
                    <p>No orders yet.</p>
                @endforelse
            </div>
        </div>

        <div class="dashboard-card">
            <h3>Quick Actions</h3>

            <div class="quick-actions">
                <a href="{{ url('/products/create') }}" class="quick-action">Add Product</a>
                <a href="{{ url('/admin/orders') }}" class="quick-action">View Orders</a>
                <a href="{{ route('admin.assign-orders') }}" class="quick-action">Assign Delivery</a>
                <a href="{{ route('admin.delivery-boys.index') }}" class="quick-action">Delivery Boys</a>
            </div>
        </div>

    </div>

    <div class="dashboard-card">
        <h3>Recent Orders</h3>

        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse(($recentOrders ?? collect()) as $order)
                    @php
                        $product = $order->product;
                        $quantity = $order->quantity_ordered ?? 1;
                        $amount = $product ? (($product->price ?? 0) * $quantity) : 0;
                    @endphp

                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $product->product_name ?? 'Product unavailable' }}</td>
                        <td>₹{{ number_format($amount, 2) }}</td>
                        <td>{{ $order->status ?? 'Unknown' }}</td>
                        <td>{{ optional($order->created_at)->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="dashboard-card">
        <h3>Recent Delivery Boys</h3>

        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                </tr>
            </thead>

            <tbody>
                @forelse(($recentDeliveryBoys ?? collect()) as $boy)
                    <tr>
                        <td>{{ $boy->name }}</td>
                        <td>{{ $boy->email }}</td>
                        <td>{{ $boy->phone ?? '—' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No delivery boys found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
