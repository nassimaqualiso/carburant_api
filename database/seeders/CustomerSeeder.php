<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()->times(20)->create()->each(function ($customer) {
            $user = User::create([
                'name' => $customer->first_name,
                'email' => $customer->email,
                'password' => Hash::make('password')
            ]);
            $customer->user_id = $user->id;
            $customer->save();

        });
    }
}
