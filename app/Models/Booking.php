<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Booking extends Model
{
    use HasFactory;
  protected $fillable = [
    'user_id',
    'service',
    'price',
    'quantity',
    'photo_path',
    'comment',
    'address',
    'selectedDate',
    'selectedTime',
    'notes',
    'name',
    'phoneNumber',
    'postcode',
    'city',
    'state',
    'customer_name',
    'customer_email',
    'customer_phone',
    'status',
    'is_reward'
];


protected $casts = [
    'selectedDate' => 'date',
    'selectedTime' => 'datetime:H:i',
    'is_reward' => 'boolean',
];




    public function photos()
{
    return $this->hasMany(BookingPhoto::class);
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id'); // confirm foreign key if customized
}

public function service()
{
    return $this->belongsTo(Service::class, 'service_id'); // confirm foreign key if customized
}


}


