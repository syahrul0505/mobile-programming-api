<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $table = 'restaurants';

    protected $guarded = [];

    public function restaurantTag()
    {
        return $this->hasMany(RestaurantTag::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'restaurant_tags', 'restaurant_id', 'tag_id');
    }

    public function restaurantAddOn()
    {
        return $this->hasMany(RestaurantAddOn::class);
    }

    public function restaurantPackage()
    {
        return $this->hasMany(MenuPackagePivots::class);
    }

    public function orderPivot()
    {
        return $this->hasMany(OrderPivots::class);
    }

    public function stockIn()
    {
        return $this->hasMany(StockInProduct::class, 'restaurant_id', 'id');
    }

    public function totalStock($id) {
        $restaurant = Restaurant::where('id', $id)->get();
        $stockIn = StockInProduct::where('restaurant_id', $id)->get();
        $stockOutProduct = StockOutProduct::where('restaurant_id', $id)->get();
        $stockOut = OrderDetail::where('restaurant_id', $id)->get();
        $sum_stock_in = $stockIn->sum('product_in');
        $sum_stock_out_product = $stockOutProduct->sum('product_out');
        $sum_stock_out = $stockOut->sum('qty') + $sum_stock_out_product;

        return $sum_stock_out;

    }

}
