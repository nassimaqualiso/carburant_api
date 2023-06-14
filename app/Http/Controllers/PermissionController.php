<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {

        return sendResponse(Permission::all(), '');

    }

    public function update_role_permissions(Request $request, $name)
    {
        dd($request->all());

    }
}
