<?php

namespace App\Http\Controllers;

use App\Models\VehicleEnergy;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class VehicleEnergyController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = VehicleEnergy::class;
    }

    public function getList() {
        $data = VehicleEnergy::pluck('name', 'id');
        return sendResponse($data, 'success');
    }
}
