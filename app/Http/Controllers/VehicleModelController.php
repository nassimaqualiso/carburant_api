<?php

namespace App\Http\Controllers;

use App\Traits\CrudTrait;
use App\Models\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = VehicleModel::class;
    }
    public function getList()
    {
        $data = VehicleModel::select('id', 'name', 'vehicle_brand_id')->get();
        return sendResponse($data, 'success');
    }
}
