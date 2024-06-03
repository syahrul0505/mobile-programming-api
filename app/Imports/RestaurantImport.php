<?php

namespace App\Imports;

use App\Models\Restaurant;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class RestaurantImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return new Restaurant([
            'name' => $row[1] ?? '-',
            'modal' => $row[2] ?? 0,
            'price' => $row[3] ?? 0,
            'status' =>'active',
        ]);
    }
}
