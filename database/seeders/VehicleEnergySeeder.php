<?php

namespace Database\Seeders;

use App\Models\VehicleEnergy;
use Illuminate\Database\Seeder;

class VehicleEnergySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleEnergy::factory()->times(4)->create();
    }
}
