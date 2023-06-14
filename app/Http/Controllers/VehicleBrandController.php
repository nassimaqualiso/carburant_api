<?php

namespace App\Http\Controllers;

use App\Models\VehicleBrand;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;

class VehicleBrandController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = VehicleBrand::class;
    }

    public function getList()
    {
        $data = VehicleBrand::pluck('name', 'id');
        return sendResponse($data, 'success');
    }
}
