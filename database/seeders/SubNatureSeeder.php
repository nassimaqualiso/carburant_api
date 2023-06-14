<?php

namespace Database\Seeders;

use App\Models\SubNature;
use Illuminate\Database\Seeder;

class SubNatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubNature::factory()->times(20)->create();

    }
}
