<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BunHairstyle extends Model
{
    use HasFactory;
    protected $table = 'bunhairstyles';
    protected $fillable = ['url'];  

}
