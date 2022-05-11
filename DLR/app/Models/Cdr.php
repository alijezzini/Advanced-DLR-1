<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cdr extends Model
{
    use HasFactory;
    protected $fillable = ['message_id,client,sender_id,message_text,status,
    destination_phone_number,operator,country,delivery_status,terminator_message_id,date_recieved,date_sent,date_dlr,fake'];
}
