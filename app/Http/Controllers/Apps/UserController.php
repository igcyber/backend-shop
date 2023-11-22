<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /**
     * Show list of users and search functionality
     *
     * @return void
     */
    public function index()
    {
        $users = User::when(request()->q, function ($users) {
            $users = $users->where('name', 'like', '%' . request()->q . '%');
        })
            ->with('roles')
            ->latest()
            ->paginate(10);

        $roles = Role::all();

        return view('pages.app.users.index', compact('users', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:150',
            'username' => 'required|max:150|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ], [
            'name.*' => 'Data :attribute Wajib Diisi',
            'username.*' => 'Data :attribute Wajib Diisi',
            'email.*' => 'Data :attribute Wajib Diisi',
            'password.*' => 'Data :attribute Wajib Diisi',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        //assign role to user
        $user->assignRole($request->roles);

        //redirect back to roles page
        $message = $user ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';

        return redirect()->route('app.users.index')->with(['success' => $message]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('pages.app.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:200',
            'username' => 'required|max:200|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        // Assign roles to user
        $user->syncRoles($request->roles);

        // Redirect back to users page
        $message = $user ? 'Data Berhasil Diperbarui!' : 'Data Gagal Diperbarui!';

        return redirect()->route('app.users.index')->with(['success' => $message]);
    }

    public function destroy($id)
    {

        $user = User::findOrFail($id);

        // Check if there are related records in the 'customers' table
        if ($user->sales()->exists() || $user->outlet()->exists()) {
            return response()->json(['status' => 'error']);
        }

        // Perform the delete
        if ($user->delete()) {
            return response()->json(['status' => 'success']);
        }
    }
}
