@extends('layouts.app')

@section('content')

<div class="container py-4">

    <h2 class="mb-4">My Notifications</h2>

    @forelse($notifications as $notification)

        <div class="card mb-3 shadow-sm">
            <div class="card-body">

                <h5>
                    {{ $notification->data['title'] ?? 'Notification' }}
                </h5>

                <p>
                    {{ $notification->data['message'] ?? '' }}
                </p>

                <hr>

                <p>
                    <strong>Order ID:</strong>
                    {{ $notification->data['booking_id'] ?? 'N/A' }}
                </p>

                <p>
                    <strong>Product Name:</strong>
                    {{ $notification->data['product_name'] ?? 'N/A' }}
                </p>

                <p>
                    <strong>Product ID:</strong>
                    {{ $notification->data['product_id'] ?? 'N/A' }}
                </p>

                <p>
                    <strong>Quantity:</strong>
                    {{ $notification->data['quantity'] ?? 'N/A' }}
                </p>

                <p>
                    <strong>Size:</strong>
                    {{ $notification->data['size'] ?? 'N/A' }}
                </p>

                <p>
                    <strong>Status:</strong>
                    {{ $notification->data['status'] ?? 'N/A' }}
                </p>

                <small class="text-muted">
                    {{ $notification->created_at->diffForHumans() }}
                </small>

                <div class="mt-3">

                    @if(is_null($notification->read_at))

                        <span class="badge bg-primary">New</span>

                        <form action="{{ route('notifications.read', $notification->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf

                            <button type="submit" class="btn btn-sm btn-primary">
                                Mark as Read
                            </button>
                        </form>

                    @else

                        <span class="badge bg-success">Read</span>

                    @endif

                </div>

            </div>
        </div>

    @empty

        <div class="alert alert-info">
            No notifications available.
        </div>

    @endforelse

</div>

@endsection
