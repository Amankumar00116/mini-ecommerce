<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
             $table->timestamp('confirmed_at')->nullable();
        $table->timestamp('packed_at')->nullable();
        $table->timestamp('shipped_at')->nullable();
        $table->timestamp('out_for_delivery_at')->nullable();
        $table->timestamp('delivered_at')->nullable();
        $table->timestamp('rejected_at')->nullable();
        $table->timestamp('out_of_stock_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
             $table->dropColumn([
            'confirmed_at',
            'packed_at',
            'shipped_at',
            'out_for_delivery_at',
            'delivered_at',
            'rejected_at',
            'out_of_stock_at',
        ]);
        });
    }
};
