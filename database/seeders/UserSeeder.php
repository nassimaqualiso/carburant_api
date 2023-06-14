<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create(
            [
                'name' => 'admin',
                'email' => 'admin@feuvert.com',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');

        $employee = User::create(
            [
                'name' => 'employee',
                'email' => 'employee@feuvert.com',
                'password' => Hash::make('password'),
            ]
        );

        $employee->assignRole('employee');


        $customer = User::create(
            [
                'name' => 'customer',
                'email' => 'customer@feuvert.com',
                'password' => Hash::make('password'),
            ]
        );

        $customer->assignRole('customer');
    }
}
