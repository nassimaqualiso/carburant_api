<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'address' => $this->faker->address(),
            'is_head_office' => false,
            'is_franchise' => true,
            'company_id' => Company::inRandomOrder()->first()->id,
            'is_active' => $this->faker->boolean(),
        ];
    }
}
