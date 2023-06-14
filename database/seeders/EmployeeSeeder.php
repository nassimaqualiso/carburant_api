<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Exception;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::factory()->times(20)->create()->each(function ($employee) {
          try{
            $user = User::create([
                'name' => $employee->first_name,
                'email' => $employee->email,
                'password' => Hash::make('password')
            ]);
            $employee->user_id = $user->id;
            $employee->save();
          }catch(Exception $e){
            dd($e);
          }

        });

    }
}
