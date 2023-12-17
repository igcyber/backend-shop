<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Create Users Seeder
         */
        $user = User::create([
            'name' => 'Supervisor 1',
            'username' => 'spv01',
            'email' => 'supervisor@example.com',
            'password' => bcrypt('password'),
        ]);

        /**
         * Get All Permissions
         */
        $permissions = Permission::all();

        /**
         * Get Supervisor Permissions
         */
        $role = Role::where('name', 'Supervisor')->first();

        /**
         * Assign Permissions To Role
         */
        $role->syncPermissions($permissions);

        /**
         * Assign Supervisor To User
         */
        $user->assignRole($role);
    }
}
