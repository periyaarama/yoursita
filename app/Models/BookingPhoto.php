<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingPhoto extends Model
{
    use HasFactory;

protected $fillable = [
    'booking_id',
    'photo_path',
    'file_name', 
];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
