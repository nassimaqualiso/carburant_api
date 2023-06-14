<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'cnss'=> $this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'date'=>$this->faker->date(),
            'idfiscale'=>$this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'trade_registry'=>$this->faker->regexify('[A-Z]{5}[0-4]{3}'),
            'is_active'=> $this->faker->boolean(),
            'is_franchise'=>true,

        ];
    }
}
