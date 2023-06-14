<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        $this->authorize('roles.index', auth()->user());
        return Role::with('permissions')->get();
    }

    public function show($id)
    {
        $this->authorize('roles.index', auth()->user());
        return Role::with('permissions')->findOrFail($id);

    }
    public function update_role_permissions(Request $request, $id)
    {
        $this->authorize('roles.update', auth()->user());

        try {
            $role = Role::findOrFail($id);
            $role->syncPermissions($request->permissions);
            return sendResponse($role, 'updated successfully');
        } catch (Exception $e) {
            return sendError($e, [], 400);

        }

    }
}
