<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function stockIn()
    {
        return $this->hasMany(StockIn::class, 'material_id', 'id');
    }
    
    public function stockOut()
    {
        return $this->hasMany(StockOut::class, 'material_id', 'id');
    }

    public function totalStock($id) {
        $material = Material::where('id', $id)->get();
        $stockIn = StockIn::where('material_id', $id)->get();
        $stockOut = StockOut::where('material_id', $id)->get();
        $sum_material = $material->sum('minimal_stock');
        $sum_stock_in = $stockIn->sum('material_in');
        $sum_stock_out = $stockOut->sum('material_out');

        $data = ($sum_material + $sum_stock_in) - $sum_stock_out;

        return $data;

    }

}
