<?php

namespace App\Imports;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Permission;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        if (empty(array_filter($row))) {
            return null;
        }
        $enc_pass = Hash::make($row['password']);
        $username = generateUsername($row['name']);

        $user = new User([
            'kode' => $row['kode'],
            'name' => $row['name'],
            'username' => $username,
            'password' => $enc_pass,
            'email' => $row['email']
        ]);

        $user->save();

        // Assign role and permissions to the user
        $this->assignRoleAndPermissions($user);

        return $user;
    }

    private function assignRoleAndPermissions(User $user)
    {
        // Get All Permissions
        // $permissions = Permission::all();

        // Get Supervisor Role (Assuming the role name is 'Outlet')
        $role = Role::where('name', 'Outlet')->first();

        // Assign Permissions To Role
        // $role->syncPermissions($permissions);

        // Assign Supervisor Role To User
        $user->assignRole($role);
    }
}
