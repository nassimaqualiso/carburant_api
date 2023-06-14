<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\VehicleBrand;
use App\Models\VehicleEnergy;
use App\Models\VehicleLength;
use App\Models\VehicleModel;
use App\Models\VehiclePeriod;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        do {
            $customer_id = Customer::inRandomOrder()->first()->id;
            $registration_car = $this->faker->regexify('[A-Z]{2}[0-10]{9}');
            $chassis_no = $this->faker->regexify('[0-10]{9}');
            $date_mce = $this->faker->date();
            $model = VehicleModel::inRandomOrder()->first();
            $energy = VehicleEnergy::inRandomOrder()->first();
            $period = VehiclePeriod::inRandomOrder()->first();
            $length = VehicleLength::inRandomOrder()->first();
        } while (
            Vehicle::where('customer_id' , $customer_id)
                    ->where(function ($q) use ($registration_car, $chassis_no) {
                        return $q->where('registration_car', $registration_car)
                                ->orWhere('chassis_no', $chassis_no);
                    })->exists()
        );

        return [
            'customer_id' => $customer_id,
            'registration_car' => $registration_car,
            'chassis_no' => $chassis_no,
            'date_mce' => $date_mce,
            'vehicle_brand_id' => $model->vehicle_brand_id,
            'vehicle_model_id' => $model->id,
            'vehicle_energy_id' => $energy->id,
            'vehicle_period_id' => $period->id,
            'vehicle_length_id' => $length->id,
        ];
    }
}
