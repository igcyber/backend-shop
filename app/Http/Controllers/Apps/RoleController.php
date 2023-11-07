<?php

namespace App\Http\Controllers\Apps;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function index()
    {
        //get roles
        $roles = Role::when(request()->q, function ($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->q . '%');
        })->with('permissions')->latest()->paginate(10);

        //get permission all
        $permissions = Permission::all();

        return view('pages.app.roles.index', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        //validate request Role Form
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required'
        ]);

        //create role
        $role = Role::create(['name' => $request->name]);

        //assign permissions to role
        $role->givePermissionTo($request->permissions);

        if ($role) {
            //redirect dengan pesan sukses
            return redirect()->route('app.roles.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.roles.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        //get role
        $role = Role::with('permissions')->findOrFail($id);
        //get all permissions
        $permissions = Permission::all();
        //redirect back to roles page
        return view('pages.app.roles.edit', compact('role', 'permissions'));
    }


    public function update(Request $request, Role $role)
    {
        //validate request updated form
        $this->validate($request, [
            'name' => 'required',
            'permissions' => 'required'
        ], [
            'name.required' => 'Nama Hak Akses Harus Diisi',
        ]);

        //update role
        $role->update([
            'name' => $request->name
        ]);

        //sync permissions to role
        $role->syncPermissions($request->permissions);

        //redirect back to roles page
        if ($role) {
            //redirect dengan pesan sukses
            return redirect()->route('app.roles.index')->with(['success' => 'Data Berhasil Diperbarui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.roles.index')->with(['error' => 'Data Gagal Diperbarui!']);
        }
    }


    public function destroy($id)
    {
        //find role by id
        $role = Role::findOrFail($id);
        //delete role
        $role->delete();
        //check for status destroy
        if ($role) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
