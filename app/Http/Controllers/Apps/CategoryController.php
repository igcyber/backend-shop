<?php

namespace App\Http\Controllers\Apps;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\CategoryDataTable;

class CategoryController extends Controller
{
    //
    public function index(CategoryDataTable $dataTable)
    {
        return $dataTable->render('pages.app.categories.index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:categories,name',
            'status' => 'required'
        ], [
            'name.required' => 'Data Wajib Diisi',
            'name.max' => 'Data Terlalu Panjang',
            'name.unique' => 'Data Sudah Terdaftar',
            'status.required' => 'Data Wajib Diisi'
        ]);

        $category = Category::create([
            'name' => $request->name,
            'status' => $request->status,
            'slug' => Str::slug($request->name)
        ]);

        if ($category) {
            //redirect dengan pesan sukses
            return redirect()->route('app.categories.index')->with(['success' => 'Data Berhasil Disimpan!']);
        } else {
            //redirect dengan pesan error
            return redirect()->route('app.categories.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }
}
