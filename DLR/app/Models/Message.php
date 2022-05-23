<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $fillable = [
        'message_id
        sender_id,
        message_text,
        destination,
        delivery_status,
        status,
        terminator_message_id,
        date_received,
        date_sent,
        date_dlr,
        fake'
    ];
    protected $casts = [
        'delivery_status' =>\App\Enum\StatusEnum::class,
    ];
}
