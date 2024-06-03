<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOutProduct extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
}
