<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeInterval extends Model
{
    protected $fillable = ['time_interval'];
    use HasFactory;
    public $timestamps = false;
}
