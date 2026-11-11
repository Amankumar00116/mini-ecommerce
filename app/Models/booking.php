<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class booking extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'selected_size',
        'quantity_ordered',
        'status',
        'name',
        'mobile',
        'pincode',
        'house_no',
        'address',
        'locality',
        'city',
        'state',
        'address_type'
    ];

     public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function deliveryBoy(){
        return $this->belongsTo(User::class, 'delivery_boy_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }


}
