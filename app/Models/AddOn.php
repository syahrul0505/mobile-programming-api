<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddOn extends Model
{
    use HasFactory;

    public function detailAddOn()
    {
        return $this->hasMany(AddOnDetail::class);
    }
}
