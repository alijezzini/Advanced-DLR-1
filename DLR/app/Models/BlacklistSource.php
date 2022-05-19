<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlacklistSource extends Model
{
    protected $fillable = ['sender_id'];
    use HasFactory;
}
