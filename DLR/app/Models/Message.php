<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id,
        message_text,
        status,
        destination,
        delivery_status,
        terminator_message_id,
        date_recieved,
        date_sent,
        date_dlr,
        fake'
    ];
}
