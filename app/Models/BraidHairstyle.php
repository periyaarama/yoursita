<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BraidHairstyle extends Model
{
    use HasFactory;
     protected $table = 'braidhairstyle'; // Custom table name
    protected $fillable = ['url'];
}
