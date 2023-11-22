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
        $validatedData = $request->validate([
            'name' => 'required|max:100|unique:categories,name',
            'status' => 'required',
        ], [
            'name.required' => 'Data Wajib Diisi',
            'name.max' => 'Data Terlalu Panjang',
            'name.unique' => 'Data Sudah Terdaftar',
            'status.required' => 'Data Wajib Diisi',
        ]);

        $category = Category::create([
            'name' => $validatedData['name'],
            'status' => $validatedData['status'],
            'slug' => Str::slug($validatedData['name']),
        ]);

        $message = $category ? 'Data Berhasil Disimpan!' : 'Data Gagal Disimpan!';

        return redirect()->route('app.categories.index')->with([$category ? 'success' : 'error' => $message]);
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('pages.app.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:100|unique:categories,name,' . $category->id,
            'status' => 'required',
        ], [
            'name.required' => 'Data Wajib Diisi',
            'name.max' => 'Data Terlalu Panjang',
            'name.unique' => 'Data Sudah Terdaftar',
            'status.required' => 'Data Wajib Diisi',
        ]);

        $category->update([
            'name' => $validatedData['name'],
            'status' => $validatedData['status'],
        ]);

        $message = $category ? 'Data Berhasil Diperbarui!' : 'Data Gagal Diperbarui!';

        return redirect()->route('app.categories.index')->with([$category ? 'success' : 'error' => $message]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $status = $category->delete() ? 'success' : 'error';
        return response()->json(['status' => $status]);
    }

    public function changeStatus(Request $request)
    {
        $category = Category::findOrFail($request->id);
        $category->status = $request->status == 'true' ? 1 : 0;
        $category->save();
        return response(['message' => 'Status Has Been Updated']);
    }
}
