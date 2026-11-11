<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\booking;
use App\Models\Product;

class OrderStatusNotification extends Notification
{
    use Queueable;

    public $bookingId;
    public $status;

    public function __construct($bookingId, $status)
    {
        $this->bookingId = $bookingId;
        $this->status = $status;
    }

    // Notification database me save hogi
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    // Notification ka data
    public function toDatabase(object $notifiable): array
    {
        // Booking ko database se find karo
        $booking = booking::find($this->bookingId);

        // Booking milne par uska product find karo
        $product = $booking
            ? Product::find($booking->product_id)
            : null;

        return [
            'title' => 'Order Status Updated',

            'message' => 'Your order status is now ' . $this->status,

            'booking_found' => $booking ? 'Yes' : 'No',

            'booking_id' => $booking->id ?? null,

            'product_id' => $booking->product_id ?? null,

            'product_name' => $product->product_name ?? 'Product not found',

            'quantity' => $booking->quantity_ordered ?? null,

            'size' => $booking->selected_size ?? null,

            'status' => $this->status,
        ];
    }
}
