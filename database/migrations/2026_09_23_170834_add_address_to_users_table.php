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
        Schema::table('users', function (Blueprint $table) {
        $table->string('mobile')->nullable();
        $table->string('pincode')->nullable();
        $table->string('house_no')->nullable();
        $table->text('address')->nullable();
        $table->string('locality')->nullable();
        $table->string('city')->nullable();
        $table->string('state')->nullable();
        $table->string('address_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
             $table->dropColumn([
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
