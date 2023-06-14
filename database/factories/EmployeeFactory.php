<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'company_id'=>Company::inRandomOrder()->first()->id,
            'last_name' => $this->faker->lastName,
            'CIN' => $this->faker->regexify('[A-Z]{1}[0-10]{9}'),
            'registration_number' => $this->faker->regexify('[A-Z]{8}[0-10]{2}'),
            'CNSS' => $this->faker->regexify('[A-Z]{8}[0-10]{7}'),
            'sex' => $this->faker->randomElement(['M', 'F']),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            // 'birth_date', "2000-01-01",
            // 'birth_place', "TANGER"
            // 'birth_date', $this->faker->date("Y-m-d"),
            // 'birth_place', $this->faker->city()
        ];
    }
}
