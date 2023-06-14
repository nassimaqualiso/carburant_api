<?php

namespace Database\Factories;

use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $vehicle_brand = VehicleBrand::inRandomOrder()->first();
        return [
            'name' => $vehicle_brand->name.' ## '.$this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'vehicle_brand_id'=>$vehicle_brand->id,
        ];
    }
}
