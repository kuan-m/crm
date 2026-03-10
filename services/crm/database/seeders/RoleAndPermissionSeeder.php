<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // TODO: вынести в Enum
        $permissions = [
            'Смотреть тикеты',
            'Управлять тикетами',
            'Доступ к статистике',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $role = Role::findOrCreate('manager');
        $role->givePermissionTo(Permission::all());

        $adminRole = Role::findOrCreate('admin');
        $adminRole->givePermissionTo(Permission::all());
    }
}
