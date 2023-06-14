<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use App\Models\VehicleBrand;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'code' => $this->faker->randomDigit(),
            'qty' => $this->faker->numberBetween(100, 1000),
            'alert_quantity' => 100,
            'type' => 'standard',
            'barcode_symbology' => '1D',
            'product_category_id' => ProductCategory::inRandomOrder()->first()->id,
            'cost' => $this->faker->numberBetween(1500, 6000),
            'price' => $this->faker->numberBetween(1500, 6000),
            'product_details'=>$this->faker->text()

        ];
    }
}
