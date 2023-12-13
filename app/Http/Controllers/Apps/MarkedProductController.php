<?php

namespace App\Http\Controllers\Apps;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\MarkedProduct;
use App\Http\Controllers\Controller;

class MarkedProductController extends Controller
{
    public function markProduct($detailId, $user)
    {
        // Check if product is already marked
        $user = User::find($user);
        if (!$user) {
            return back()->with(['error' => 'User not found']);
        }

        // Check if product is already marked
        // $existingCart = MarkedProduct::where('detail_id', $detailId)->where('outlet_id', $user)->first();
        $existingCart = $user->markedProducts()->where('detail_id', $detailId)->first();

        if ($existingCart) {
            return back()->with(['warning' => 'Barang Sudah Anda Pesan']);
        }

        // Create a new cart entry using Eloquent relationships
        $user->markedProducts()->create([
            'detail_id' => $detailId,
        ]);

        return back()->with(['success' => 'Product successfully marked']);
    }
}
