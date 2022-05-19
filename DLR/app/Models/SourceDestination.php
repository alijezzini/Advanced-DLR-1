<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SourceDestination extends Model
{
    protected $fillable = [
        'destination',
        'sender_id',
        'message_id',
        'time_received'
    ];
    use HasFactory;

    public function Messages()
    {
        return $this->hasMany(Message::class);
    }
}
