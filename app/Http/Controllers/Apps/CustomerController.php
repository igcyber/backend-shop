<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomerImport;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    //customer index
    public function index()
    {
        //get customers
        // $customers = Customer::when(request()->q, function ($query, $search) {
        //     $query->orWhereHas('outlet', function ($query) use ($search) {
        //         $query->where('name', 'like', '%' . $search . '%');
        //     });
        // })->with('outlet')->paginate(20);

        $customers = Customer::with('outlet')->paginate(20);

        // Get sales options
        $salesOptions = Role::where('name', 'Sales')->first()->users;

        return view('pages.app.customers.index', compact('salesOptions', 'customers'));
    }

    public function create()
    {
        $salesRole = Role::where('name', 'Sales')->first();
        $sales = User::role($salesRole->name)->get();

        $outletRole = Role::where('name', 'Outlet')->first();
        $outlets = User::role($outletRole->name)->get();

        $existingOutlets = Customer::pluck('outlet_id')->toArray();
        $existingOutletIds = array_unique($existingOutlets);

        return view('pages.app.customers._create', compact('sales', 'outlets', 'existingOutletIds'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'klasifikasi' => 'required',
            'no_telp' => 'nullable',
            'address' => 'nullable',
            'nomor' => 'nullable',
            'sales_id' => 'nullable|exists:users,id',
            'outlet_id' => 'required',
            'hrg_jual' => 'nullable'
        ]);

        $customer = Customer::create([
            'klasifikasi' => $validatedData['klasifikasi'],
            'address' => $validatedData['address'],
            'no_telp' => $validatedData['no_telp'] ?? '-',
            'hrg_jual' => $validatedData['hrg_jual'],
            'nomor' => $validatedData['nomor'],
            'sales_id' => $validatedData['sales_id'] ?? null,
            'outlet_id' => $validatedData['outlet_id'],
        ]);

        $message = $customer ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';
        return redirect()->route('app.customers.index')->with(['success' => $message]);
    }


    public function edit($id)
    {
        $customer = Customer::with('outlet', 'seller')->findOrFail($id);
        // dd($customer);
        return view('pages.app.customers._edit', compact('customer'));
    }


    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->update([
            'hrg_jual' => $request->hrg_jual,
            'no_telp' => $request->no_telp,
            'nomor' => $request->nomor,
            'address' => $request->address,
            'klasifikasi' => $request->klasifikasi,
        ]);

        $message = $customer ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';
        return redirect()->route('app.customers.index')->with(['success' => $message]);
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls|max:2048',
        ]);

        try {
            $file = $request->file('excel_file');
            $import = new CustomerImport();
            Excel::import($import, $file);
            return redirect()->route('app.customers.index')->with(['success' => 'Data imported successfully']);
        } catch (\Exception $e) {
            return redirect()->route('app.customers.index')->with(['error' => 'Error importing data: ' . $e->getMessage()]);
            // return redirect()->route('app.products.index')->with(['error' => 'Terjadi Masalah Silahkan Coba Lagi']);
        }
    }

    public function updateSales($customerId)
    {
        $newSalesId = request('sales_id');
        $customer = Customer::find($customerId);

        if ($customer) {
            $customer->sales_id = $newSalesId;
            $customer->save();

            return response()->json(['newSalesName' => $customer->seller->name]);
        }

        return response()->json(['error' => 'Customer not found'], 404);
    }

    public function destroy($id)
    {
        //find outlet
        $customer = Customer::findOrFail($id);

        //delete user
        $customer->delete();

        //check for status destroy
        if ($customer) {
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
