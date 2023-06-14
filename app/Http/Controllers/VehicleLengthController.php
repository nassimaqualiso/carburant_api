<?php

namespace App\Http\Controllers;

use App\Models\VehicleLength;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class VehicleLengthController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = VehicleLength::class;
    }

    public function getList() {
        $data = VehicleLength::pluck('name', 'id');
        return sendResponse($data, 'success');
    }
}
