<?php

namespace App\Imports;

use App\Models\Material;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class materialImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // return new Material([
        //     'code' => $row[0],
        //     'nama' => $row[1],
        //     'unit' => $row[2],

        // ]);
        Material::updateOrCreate(
            [
                'code' => $row[0] ?? '-',
            ],
            [
                'nama' => $row[1] ?? '-',
            ],
            [
                'unit' => $row[2] ?? '-',
            ]
        );
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $i => $row) {
            if ($i == 0) {
                continue;
            }
            
            // dd('tes');
            Material::updateOrCreate(
                [
                    'code' => $row[0] ?? '-',
                ],
                // [
                //     'nama' => $row[1] ?? '-',
                // ],
                // [
                //     'unit' => $row[2] ?? '-',
                // ]
            );
        }
    }


}
