<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $fillable = ['sender_id','sender_unique_identifier'];
    use HasFactory;
}
