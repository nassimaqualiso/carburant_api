<?php

namespace App\Http\Controllers;

use App\Models\DataCar;
use App\Models\Forfait;
use App\Models\Nature;
use App\Models\SubNature;
use App\Models\VehicleBrand;
use App\Models\VehicleEnergy;
use App\Models\VehicleLength;
use App\Models\VehicleModel;
use App\Models\VehiclePeriod;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForfaitController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = Forfait::class;
    }

    public function getListNature(){
        $data = Nature::pluck('name','id');
        return sendResponse($data, 'success');
    }
    public function getListSubNature(Request $request){
        if($request->filled('nature_id'))
            $data = SubNature::where('nature_id', $request->get('nature_id'))->pluck('name','id');
        else $data =  [];
        return sendResponse($data, 'success');
    }

    public function getDataCarBrands(Request $request){
        $datacarBrandIds = datacar::select('vehicle_brand_id')->distinct()->pluck('vehicle_brand_id');
        if($datacarBrandIds)
            $data = VehicleBrand::whereIn('id', $datacarBrandIds)->pluck('name','id');
        else $data = [];
        return sendResponse($data, 'success');
    }

    public function getDataCarModels(Request $request){
        if(!$request->filled('brand_id'))
            return sendResponse([], 'success');

        $datacarModelIds = datacar::where('vehicle_brand_id', $request->get('brand_id'))
                                    ->select('vehicle_model_id')->distinct()
                                    ->pluck('vehicle_model_id');
        if($datacarModelIds)
            $data = VehicleModel::whereIn('id', $datacarModelIds)->pluck('name','id');
        else $data = [];
        return sendResponse($data, 'success');
    }

    public function getDataCarEnergies(Request $request){
        if(!$request->filled('model_id'))
            return sendResponse([], 'success');

        $datacarEnergyIds = datacar::where('vehicle_model_id', $request->get('model_id'))
                                    ->select('vehicle_energy_id')->distinct()
                                    ->pluck('vehicle_energy_id');
        if($datacarEnergyIds)
            $data = VehicleEnergy::whereIn('id', $datacarEnergyIds)->pluck('name','id');
        else $data = [];
        return sendResponse($data, 'success');
    }

    public function getDataCarPeriods(Request $request){
        if(!$request->filled('energy_id') OR !$request->filled('model_id'))
            return sendResponse([], 'success');

        $datacarPeriodIds = datacar::where('vehicle_model_id', $request->get('model_id'))
                                    ->where('vehicle_energy_id', $request->get('energy_id'))
                                    ->select('vehicle_period_id')->distinct()
                                    ->pluck('vehicle_period_id');
        if($datacarPeriodIds)
            $data = VehiclePeriod::whereIn('id', $datacarPeriodIds)->pluck('name','id');
        else $data = [];
        return sendResponse($data, 'success');
    }

    public function getDataCarLengths(Request $request){
        if(!$request->filled('energy_id') OR
            !$request->filled('period_id') OR
            !$request->filled('model_id'))
            return sendResponse([], 'success');

        $datacarLengthIds = datacar::where('vehicle_model_id', $request->get('model_id'))
                                    ->where('vehicle_energy_id', $request->get('energy_id'))
                                    ->where('vehicle_period_id', $request->get('period_id'))
                                    ->select('vehicle_length_id')->distinct()
                                    ->pluck('vehicle_length_id');
        if($datacarLengthIds)
            $data = VehicleLength::whereIn('id', $datacarLengthIds)->pluck('name','id');
        else $data = [];
        return sendResponse($data, 'success');
    }
    public function getDataCar(Request $request){
        if(
            !$request->filled('brand_id') OR
            !$request->filled('model_id') OR
            !$request->filled('energy_id') OR
            !$request->filled('period_id') OR
            !$request->filled('length_id')
        ) return sendResponse([], 'error');
        $datacar = datacar::where('vehicle_brand_id', $request->get('brand_id'))
                            ->where('vehicle_model_id', $request->get('model_id'))
                            ->where('vehicle_energy_id', $request->get('energy_id'))
                            ->where('vehicle_period_id', $request->get('period_id'))
                            ->where('vehicle_length_id', $request->get('length_id'))
                            ->with([
                                'vehicleBrand:id,name',
                                'vehicleModel:id,name',
                                'vehicleEnergy:id,name',
                                'vehiclePeriod:id,name',
                                'vehicleLength:id,name',
                            ])
                            ->first();
        $data = [
            $request->get('brand_id')
            , $request->get('model_id')
            , $request->get('energy_id')
            , $request->get('period_id')
            , $request->get('length_id')
        ];
        return sendResponse($datacar, 'success');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'data_car_id' => 'required',
            'nature_id' => 'required',
            // 'sub_nature_id' => 'required',
        ]);
        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);

        $nature = Nature::find( $request->get('nature_id'));
        if ($nature->subNatures()->exists() && !$request->filled('sub_nature_id') && empty($request->get('sub_nature_id'))) {
            return sendError('Validation Error.', "sub nature is required", 422);
        }

        if (Forfait::where([
                'data_car_id' => $request->get('data_car_id'),
                'nature_id' => $request->get('nature_id'),
                'sub_nature_id' => $request->get('sub_nature_id') ?? null,
            ])->exists())
                return sendError('Validation Error.', 'This forfait is already exists', 422);

        DB::transaction(function () use ($request) {

            $forfait = new Forfait();
            $forfait->fill($request->all());
            $forfait->reference = 'FOR-' . time();
            $forfait->save();

            return sendResponse($forfait, 'forfait created successfully');
        });

    }
     /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $model = new $this->Model;
        $this->authorize($model->getTable() . '.show', auth()->user());
        $item = $this->Model::with([
            'dataCar' => function ($query) {
                $query->with([
                    'vehicleBrand:id,name',
                    'vehicleModel:id,name',
                    'vehicleEnergy:id,name',
                    'vehiclePeriod:id,name',
                    'vehicleLength:id,name',
                ]);
            },
        ])->findOrFail($id);
        return sendResponse($item, 'show');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required',
            'data_car_id' => 'required',
            'nature_id' => 'required',
            // 'sub_nature_id' => 'required',
        ]);
        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);

        $nature = Nature::find( $request->get('nature_id'));
        if ($nature->subNatures()->exists() && !$request->filled('sub_nature_id') && empty($request->get('sub_nature_id'))) {
            return sendError('Validation Error.', "sub nature is required", 422);
        }

        if (Forfait::where([
                'data_car_id' => $request->get('data_car_id'),
                'nature_id' => $request->get('nature_id'),
                'sub_nature_id' => $request->get('sub_nature_id'),
            ])->where('id', '<>', $id)->exists())
                return sendError('Validation Error.', 'This forfait is already exists', 422);

        DB::transaction(function () use ($request, $id) {

            $forfait = Forfait::findOrFail($id);
            $forfait->fill($request->all());
            $forfait->save();

            return sendResponse($forfait, 'forfait updated successfully');
        });

    }
}
