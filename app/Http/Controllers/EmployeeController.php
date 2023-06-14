<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = Employee::class;
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'centers' => 'required',
            'is_franchise' => 'required|boolean',
            'password' => 'string|min:6',

        ]);


        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);



        DB::transaction(function () use ($request) {
            $employee = new Employee();
            $employee->fill($request->all());
            $user = User::create([
                'name' => $employee->first_name . '  ' . $employee->last_name,
                'email' => $employee->email,
                'password' => Hash::make($request->password)
            ]);

            $user->assignRole('employee');

            $employee->user_id = $user->id;
            if (!$request->is_franchise) {
                $employee->company_id = 1;
            }

            $employee->save();
            $employee->centers()->attach($request->centers);


            return sendResponse($employee, 'employee created successfully');

        });
    }
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
            'centers' => 'required',
            'is_franchise' => 'required|boolean',
            'password' => 'string|min:6',

        ]);


        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);


        $employee = Employee::findOrFail($id);


        $employee->fill($request->all());

        if (!$request->is_franchise) {
            $employee->company_id = 1;
        }
        $employee->save();
        $employee->centers()->sync($request->centers);


        return sendResponse($employee, 'employee updated successfully');



    }
}
