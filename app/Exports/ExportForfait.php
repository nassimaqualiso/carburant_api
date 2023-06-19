<?php

namespace App\Exports;

use App\Models\Forfait;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportForfait implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Forfait::all();
    }
    //return Forfait::select('reference', 'name', 'price', 'data_car_id', 'nature_id', 'sub_nature_id')->get();
}
