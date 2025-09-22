<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;

class LowonganController extends Controller
{
    // Menampilkan semua lowongan
    public function index()
    {
        $lowongans = Lowongan::latest()->get();

        return view('lowongan.index', compact('lowongans'));
    }

    // Menampilkan detail satu lowongan
    public function show($id)
    {
        $lowongan = Lowongan::findOrFail($id);

        return view('lowongan.show', compact('lowongan'));
    }
}
