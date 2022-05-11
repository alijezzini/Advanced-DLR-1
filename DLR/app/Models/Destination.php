<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    protected $fillable = ['id', 'destination', 'sender_id', 'message_id', 'time_received'];
    use HasFactory;
}
