<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DetailProductController extends Controller
{
    public function index()
    {
        return view('pages.app.p_detail.index');
    }
}
