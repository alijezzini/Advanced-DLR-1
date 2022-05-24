<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayConnection extends Model
{
    use HasFactory;

    public $timestamps =false;
    protected $fillable = [
        'username,
        password,
        connection_id,
        api_url'
    ];
    public function infor()
    {
        return $this->hasMany(Message::class);

    }
}
