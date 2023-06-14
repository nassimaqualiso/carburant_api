<?php

namespace Database\Factories;

use App\Models\DataCar;
use App\Models\VehicleBrand;
use App\Models\VehicleEnergy;
use App\Models\VehicleLength;
use App\Models\VehicleModel;
use App\Models\VehiclePeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataCarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $brand = VehicleBrand::inRandomOrder()->first();
            $model = VehicleModel::inRandomOrder()->first();
            $energy = VehicleEnergy::inRandomOrder()->first();
            $period = VehiclePeriod::inRandomOrder()->first();
            $length = VehicleLength::inRandomOrder()->first();
        } while (
            DataCar::where('vehicle_brand_id',$brand->id)
                    ->where('vehicle_model_id',$model->id)
                    ->where('vehicle_energy_id',$energy->id)
                    ->where('vehicle_period_id',$period->id)
                    ->where('vehicle_length_id',$length->id)
                    ->exists()
        );

        return [
            'vehicle_brand_id' => $brand->id,
            'vehicle_model_id' => $model->id,
            'vehicle_energy_id' => $energy->id,
            'vehicle_period_id' => $period->id,
            'vehicle_length_id' => $length->id,
        ];
    }
}
