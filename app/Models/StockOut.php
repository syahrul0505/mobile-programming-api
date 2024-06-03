<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_outs';

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id', 'id');
    }
    
}
