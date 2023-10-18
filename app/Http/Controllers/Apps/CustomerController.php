<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    //customer index
    public function index()
    {
        //get customers
        $customers = Customer::when(request()->q, function ($customers) {
            $customers = $customers->where('name', 'like', '%' . request()->q . '%');
        })->paginate(10);

        $salesRole = Role::where('name', 'Sales')->first();
        $users = User::whereHas('roles', function ($query) use ($salesRole) {
            $query->where('role_id', $salesRole->id);
        })->get();

        return view('pages.app.customers.index', compact('customers', 'users'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'klasifikasi' => 'required',
            'no_telp' => ['nullable', 'regex:/^(0|\+62|\05)[0-9]{9,12}$/'],
            'nomor' => 'required',
            'user_id' => 'required',
        ]);

        // dd($request->all());

        $customer = Customer::create([
            'name' => $request->name,
            'klasifikasi' => $request->klasifikasi,
            'address' => $request->address,
            'no_telp' => $request->no_telp,
            'nomor' => $request->nomor,
            'user_id' => $request->user_id
        ]);

        if ($customer) {
            //redirect dengan pesan sukses
            return redirect()->route('app.customers.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.customers.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
}
