<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('name')->after('quantity_ordered');
            $table->string('mobile')->after('name');
            $table->string('pincode')->after('mobile');
            $table->string('house_no')->after('pincode');
            $table->text('address')->after('house_no');
            $table->string('locality')->after('address');
            $table->string('city')->after('locality');
            $table->string('state')->after('city');
            $table->string('address_type')->default('Home')->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'name',
                'mobile',
                'pincode',
                'house_no',
                'address',
                'locality',
                'city',
                'state',
                'address_type',
            ]);
        });
    }
};
