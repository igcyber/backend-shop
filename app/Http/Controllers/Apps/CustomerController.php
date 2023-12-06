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

        return view('pages.app.customers.index', compact('customers'));
    }

    public function create()
    {
        $salesRole = Role::where('name', 'Sales')->first();
        $users = User::role($salesRole->name)->get();

        $outletRole = Role::where('name', 'Outlet')->first();
        $outlets = User::role($outletRole->name)->get();

        $existingOutlets = Customer::pluck('outlet_id')->toArray();
        $existingOutletIds = array_unique($existingOutlets);

        return view('pages.app.customers._create', compact('users', 'outlets', 'existingOutletIds'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'klasifikasi' => 'required',
            'no_telp' => 'nullable',
            'address' => 'required',
            'nomor' => 'required',
            'sales_id' => 'required',
            'outlet_id' => 'required',
        ]);

        $customer = Customer::create([
            'klasifikasi' => $validatedData['klasifikasi'],
            'address' => $validatedData['address'],
            'no_telp' => $validatedData['no_telp'] ?? '-',
            'nomor' => $validatedData['nomor'],
            'sales_id' => $validatedData['sales_id'],
            'outlet_id' => $validatedData['outlet_id'],
        ]);

        $message = $customer ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';
        return redirect()->route('app.customers.index')->with(['success' => $message]);
    }
}
