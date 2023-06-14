<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehiclePeriodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $number = $this->faker->unique()->numberBetween(1, 20);
        $start_date = $this->faker->dateTimeBetween("-$number years", 'now');
        $end_date = $this->faker->dateTimeBetween('now', "+$number years");
        $name = 'Between ' . $start_date->format('Y') . ' and ' . $end_date->format('Y');

        return [
            'name' => $name,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
