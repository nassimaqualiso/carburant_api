<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [

            'employees' => ['index', 'store', 'show', 'update', 'destroy', 'export', 'import'],
            'customers' => ['index', 'store', 'show', 'update', 'destroy', 'export', 'import'],
            'branches' => ['index', 'store', 'show', 'update', 'destroy', 'export', 'import'],
            'companies' => ['index', 'store', 'show', 'update', 'destroy', 'export', 'import'],
            'articles' => ['index', 'store', 'show', 'update', 'destroy', 'export', 'import'],
            'roles' => ['index', 'update'],
        ];

        foreach ($permissions as $table => $actions) {
            foreach ($actions as $action) {
                Permission::create(['guard_name' => 'api', 'name' => $table . '.' . $action, 'group_name' => $table]);
            }
        }

        $role = Role::find(2);
        $role->givePermissionTo([
            'customers.index',
            'customers.store',
            'customers.show',
            'customers.update',
            'customers.destroy',
            'customers.export',
            'customers.import',
            'employees.index',
            'employees.store',
            'employees.show',
            'employees.update',
            'employees.destroy',
            'employees.export',
            'employees.import'
        ], );
    }
}
