<?php

namespace Database\Seeders;

use App\Models\VehicleLength;
use Illuminate\Database\Seeder;

class VehicleLengthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleLength::factory()->times(5)->create();
    }
}
