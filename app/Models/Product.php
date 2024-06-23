<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags', 'product_id', 'tag_id');
    }

    public function productTag()
    {
        return $this->hasMany(ProductTag::class);
    }

    public function category()
    {
        return $this->belongsTo(Tag::class);
    }

    public function restaurantTag()
    {
        return $this->hasMany(ProductTag::class);
    }
}
