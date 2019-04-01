<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use Notifiable;

    protected $fillable = [
        'restaurant_name',
        'delivery_time',
        'phone_number',
        'message',
        'status',
        'status_msg'
    ];
}
