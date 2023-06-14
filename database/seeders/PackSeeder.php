<?php

namespace Database\Seeders;

use App\Models\Pack;
use App\Models\PackItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Pack::factory()->times(10)->create()->each(function ($pack) {
            PackItem::create([
                'product_id' => Product::inRandomOrder()->first()->id,
                'pack_id' => $pack->id,
                'quantity' => 1
            ]);

        });

    }
}
