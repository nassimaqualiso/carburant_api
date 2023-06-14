<?php

namespace App\Http\Controllers;

use App\Models\VehiclePeriod;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class VehiclePeriodController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = VehiclePeriod::class;
    }

    public function getList() {
        $data = VehiclePeriod::pluck('name', 'id');
        return sendResponse($data, 'success');
    }
}
