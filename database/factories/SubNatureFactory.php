<?php

namespace Database\Factories;

use App\Models\Nature;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubNatureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name' => $this->faker->randomElement([
                'v1',
                'v2',
                'v3',
                'v4',
                'v5',
                'v6',
            ]),
            'nature_id' => $this->faker->randomElement([1, Nature::inRandomOrder()->first()->id]),

        ];
    }
}
