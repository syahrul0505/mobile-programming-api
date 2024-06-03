<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOnDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'add_on_id', // Add 'add_on_id' to the $fillable array
        'name',
        'harga',
    ];

    public function addOn()
    {
        return $this->belongsTo(AddOn::class);
    }
}
