<?php

namespace App\Imports;

use App\Models\Forfait;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportForfait implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Forfait([
            'reference' => $row[0],
            'name' => $row[1],
            'price' => $row[2],
            'data_car_id' => $row[3],
            'nature_id' => $row[4],
            'sub_nature_id' => $row[5],
        ]);
    }
}
