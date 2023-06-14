<?php

namespace Database\Seeders;

use App\Models\DataCar;
use Illuminate\Database\Seeder;

class DataCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DataCar::factory()->times(20)->create();
    }
}
