<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use App\Models\Employee;
use App\Traits\CrudTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use CrudTrait;
    public function __construct()
    {
        $this->Model = customer::class;
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'idfiscale' => 'required|string',
            'trade_registry' => 'required|string',
            'patent' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'password' => 'required|string|min:6',

        ]);
        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);


        DB::transaction(function () use ($request) {

            $company_id = 1;
            if (Auth::user()->hasRole('admin')) {
                $company_id = 1;
            } else {
                $employee = Employee::where('user_id', Auth::user()->id)->get()->first();
                $company_id = $employee->company_id;
            }


            $customer = new customer();
            $customer->fill($request->all());
            $user = User::create([
                'name' => $customer->first_name . '  ' . $customer->last_name,
                'email' => $customer->email,
                'password' => Hash::make($request->password)
            ]);

            $user->assignRole('customer');

            $customer->user_id = $user->id;
            $customer->company_id = $company_id;
            $customer->save();

            return sendResponse($customer, 'customer created successfully');
        });

    }
    public function update(Request $request, $id)
    {


        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'idfiscale' => 'required|string',
            'trade_registry' => 'required|string',
            'patent' => 'required|string',
            'email' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',

        ]);


        if ($validator->fails())
            return sendError('Validation Error.', $validator->errors(), 422);



        $customer = Customer::findOrFail($id);
        $customer->update($request->all());


        if ($request->password == null) {

            $customer->user->fill($request->all())->save();


        } else {
            $customer->user->update([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
        }


        return sendResponse($customer, 'employe updated successfully');
    }
}
