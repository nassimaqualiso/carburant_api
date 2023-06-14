<?php

namespace Database\Seeders;


use App\Models\SubNature;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CompanySeeder::class,
            EmployeeSeeder::class,
            CustomerSeeder::class,
            BranchSeeder::class,
            CenterSeeder::class,
            EmployeeCenterSeeder::class,
            ProductCategorySeeder::class,
                // NatureSeeder::class,
                // SubNatureSeeder::class,
            VehicleBrandSeeder::class,
            VehicleModelSeeder::class,
            VehicleEnergySeeder::class,
            VehicleLengthSeeder::class,
            VehiclePeriodSeeder::class,
            DataCarSeeder::class,
            ProductSeeder::class,
            VehicleSeeder::class,
            PackSeeder::class,

        ]);
    }
}
