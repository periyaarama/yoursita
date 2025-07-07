<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PastBooking extends Model
{
    use HasFactory;

    protected $fillable = [
    'user_id',
    'service',
    'price',
    'quantity',
    'name',
    'phoneNumber',
    'address',
    'state',
    'city',
    'postcode',
    'deposit',
    'full_payment',
    'transport_fee',
    'selectedDate',
    'selectedTime',
    'notes',
    'transaction_id',
    'status',
    'cancel_reason',
   
];


}
