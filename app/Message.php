<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'restaurant_name',
        'delivery_time',
        'customer_phone_number',
        'status',
        'error_text'
    ];
}
