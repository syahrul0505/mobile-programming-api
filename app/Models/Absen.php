<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Add 'add_on_id' to the $fillable array
        'date',
        'start_time',
        'end_time',
    ];
}
