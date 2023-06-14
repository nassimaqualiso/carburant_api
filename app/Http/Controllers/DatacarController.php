<?php

namespace App\Http\Controllers;

use App\Models\DataCar;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DataCarController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = DataCar::class;
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_brand_id' => 'required',
            'vehicle_model_id' => 'required',
            'vehicle_energy_id' => 'required',
            'vehicle_period_id' => 'required',
            'vehicle_length_id' => 'required',
        ]);

        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);
        if (DataCar::where([
                'vehicle_brand_id' => $request->get('vehicle_brand_id'),
                'vehicle_model_id' => $request->get('vehicle_model_id'),
                'vehicle_energy_id' => $request->get('vehicle_energy_id'),
                'vehicle_period_id' => $request->get('vehicle_period_id'),
                'vehicle_length_id' => $request->get('vehicle_length_id'),
            ])->exists())
                return sendError('Validation Error.', 'This datacar is already exists', 422);

        DB::transaction(function () use ($request) {

            $datacar = new Datacar();
            $datacar->fill($request->all());
            $datacar->save();

            return sendResponse($datacar, 'datacar created successfully');
        });

    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'vehicle_brand_id' => 'required',
            'vehicle_model_id' => 'required',
            'vehicle_energy_id' => 'required',
            'vehicle_period_id' => 'required',
            'vehicle_length_id' => 'required',
        ]);

        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);

        if (DataCar::where([
            'vehicle_brand_id' => $request->get('vehicle_brand_id'),
            'vehicle_model_id' => $request->get('vehicle_model_id'),
            'vehicle_energy_id' => $request->get('vehicle_energy_id'),
            'vehicle_period_id' => $request->get('vehicle_period_id'),
            'vehicle_length_id' => $request->get('vehicle_length_id'),
        ])->where('id', '<>', $id)->exists())
            return sendError('Validation Error.', 'This datacar is already exists', 422);

        DB::transaction(function () use ($request, $id) {
            $datacar = DataCar::findOrFail($id);
            $datacar->fill($request->all());
            $datacar->save();
            return sendResponse($datacar, 'datacar updated successfully');
        });

    }

}
