<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => Company::inRandomOrder()->first()->id,
            'type' => 'particular',
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'CIN' => $this->faker->regexify('[A-Z]{1}[0-10]{9}'),
            'sex' => $this->faker->randomElement(['M', 'F']),
            'idfiscale' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'trade_registry' => $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'patent' => $this->faker->regexify('[A-Z]{5}[0-7]{3}'),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),

        ];
    }
}
