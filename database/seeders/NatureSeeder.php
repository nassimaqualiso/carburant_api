<?php

namespace Database\Seeders;

use App\Models\Nature;
use Illuminate\Database\Seeder;

class NatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nature::factory()->times(20)->create();
    }
}
