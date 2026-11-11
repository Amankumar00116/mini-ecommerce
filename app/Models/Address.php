<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'pincode',
        'house_no',
        'address',
        'locality',
        'city',
        'state',
        'address_type',
    ];
}
