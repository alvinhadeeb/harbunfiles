<?php

namespace App\Http\Controllers\Minda;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KompresController extends Controller
{
    public function index()
    {
        return view('minda.kompres.index');
    }
}
