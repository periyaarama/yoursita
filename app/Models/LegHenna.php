<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LegHenna extends Model
{
    use HasFactory;
    protected $fillable = ['url'];
    protected $table = 'leg_hennas'; // ✅ match your table name
    
}
