<?php

namespace App\Http\Controllers;

use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqList = Faq::where('aktif', true)->orderBy('urutan')->orderBy('created_at', 'desc')->get();
        return view('faq', compact('faqList'));
    }
}
