<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $manager = User::updateOrCreate(
            ['email' => 'manager@crm.test'],
            [
                'name' => 'Обычный менеджер',
                'password' => Hash::make('password'),
            ]
        );

        $manager->assignRole('manager');

        $admin = User::updateOrCreate(
            ['email' => 'admin@crm.test'],
            [
                'name' => 'Админ',
                'password' => Hash::make('password'),
            ]
        );

        $admin->assignRole('admin');
    }
}
