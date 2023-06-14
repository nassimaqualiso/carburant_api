<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PackFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference' => 'PAC-' . time(),
            "name" => $this->faker->word(),
            "price" => 1000,
        ];
    }
}
