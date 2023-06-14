<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = Vehicle::class;
    }

    public function getCustomerList() {
        $data = Customer::selectRaw("TRIM(CONCAT( COALESCE(first_name, ''), ' ', COALESCE(last_name, ''), ' ', COALESCE(corporate_name, '') )) as customer_name")
                          ->addSelect('id')
                          ->pluck('customer_name', 'id');
        return sendResponse($data, 'customer List');
    }
    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'registration_car' => 'required',
            'chassis_no' => 'required',
            'date_mce' => 'required',
            'vehicle_brand_id' => 'required',
            'vehicle_model_id' => 'required',
            'vehicle_energy_id' => 'required',
            'vehicle_period_id' => 'required',
            'vehicle_length_id' => 'required',
        ]);

        if ($validator->fails()) return sendError('Validation Error.', $validator->errors(), 422);
        if (
            Vehicle::where('customer_id' , $request->get('customer_id'))
                    ->where(function ($q) use ($request) {
                        return $q->where('registration_car', $request->get('registration_car'))
                                ->orWhere('chassis_no', $request->get('chassis_no'));
                    })->exists()
            ) return sendError('Validation Error.', 'This vehicle already exists for this customer', 422);

        DB::transaction(function () use ($request) {

            $vehicle = new Vehicle();
            $vehicle->fill($request->all());
            $vehicle->save();

            return sendResponse($vehicle, 'Vehicle created successfully');
        });

    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'customer_id' => 'required',
            'registration_car' => 'required',
            'chassis_no' => 'required',
            'date_mce' => 'required',
            'vehicle_brand_id' => 'required',
            'vehicle_model_id' => 'required',
            'vehicle_energy_id' => 'required',
            'vehicle_period_id' => 'required',
            'vehicle_length_id' => 'required',
        ]);

        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);

        if (Vehicle::where('customer_id' , $request->get('customer_id'))
                    ->where(function ($q) use ($request) {
                        return $q->where('registration_car', $request->get('registration_car'))
                                ->orWhere('chassis_no', $request->get('chassis_no'));
                    })->where('id', '<>', $id)->exists()
        )   return sendError('Validation Error.', 'This vehicle already exists for this customer', 422);

        DB::transaction(function () use ($request, $id) {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->fill($request->all());
            $vehicle->save();
            return sendResponse($vehicle, 'Vehicle updated successfully');
        });

    }

}
