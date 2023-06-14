<?php

namespace Database\Seeders;

use App\Models\VehiclePeriod;
use Illuminate\Database\Seeder;

class VehiclePeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehiclePeriod::factory()->times(20)->create();
    }
}
