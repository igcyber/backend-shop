<?php

namespace App\Http\Controllers\Apps;

use App\Models\Vendor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\DataTables\VendorDataTable;
use App\Http\Controllers\Controller;

class VendorController extends Controller
{
    public function index(VendorDataTable $dataTable)
    {
        return $dataTable->render('pages.app.p_vendors.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:vendors,name',
            'status' => 'required'
        ], [
            'name.required' => 'Data Wajib Diisi',
            'name.max' => 'Data Terlalu Panjang',
            'name.unique' => 'Data Sudah Terdaftar',
            'status.required' => 'Data Wajib Diisi'
        ]);

        $vendor = Vendor::create([
            'name' => $request->name,
            'status' => $request->status,
            'slug' => Str::slug($request->name)
        ]);

        if ($vendor) {
            //redirect dengan pesan sukses
            return redirect()->route('app.vendors.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.vendors.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('pages.app.p_vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        // dd($request->all());
        $this->validate($request, [
            'name' => 'required|max:100|unique:vendors,name,' . $vendor->id,
            'status' => 'required'
        ], [
            'name.required' => 'Data Wajib Diisi',
            'name.max' => 'Data Terlalu Panjang',
            'name.unique' => 'Data Sudah Terdaftar',
            'status.required' => 'Data Wajib Diisi'
        ]);

        $vendor->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        if ($vendor) {
            //redirect dengan pesan sukses
            return redirect()->route('app.vendors.index')->with(['success' => 'Data Berhasil Diperbarui!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.vendors.index')->with(['error' => 'Data Gagal Diperbarui!']);
        }
    }

    public function destroy($id)
    {
        //find user
        $vendor = Vendor::findOrFail($id);

        //delete user
        $vendor->delete();

        //check for status destroy
        if ($vendor) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }

    public function changeStatus(Request $request)
    {
        $vendor = Vendor::findOrFail($request->id);
        $vendor->status = $request->status == 'true' ? 1 : 0;
        $vendor->save();
        return response(['message' => 'Status Has Been Updated']);
    }
}
