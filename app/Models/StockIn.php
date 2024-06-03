<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_ins';
    
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
}
