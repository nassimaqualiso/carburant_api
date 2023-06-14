<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'company_id' => $this->faker->randomElement([1, Company::inRandomOrder()->first()->id]),
            'name' => $this->faker->name,
            'rc' => $this->faker->regexify('[A-Z]{8}[0-10]{2}'),
            'idfiscale' => $this->faker->regexify('[A-Z]{6}[0-10]{2}'),
            'ICE' => $this->faker->regexify('[A-Z]{8}[0-10]{2}'),
            'patent' => $this->faker->regexify('[A-Z]{3}[0-7]{2}'),
            'email' => $this->faker->email,
            'manager_email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone1' => $this->faker->phoneNumber,
            'phone2' => $this->faker->phoneNumber,
            'manager' => $this->faker->name,
            'manager_phone' => $this->faker->phoneNumber,

        ];
    }
}
