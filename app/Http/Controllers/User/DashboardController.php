<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;
use App\Models\MagangApplication;
use Illuminate\Http\Request;

/**
 * DashboardController handles the user dashboard functionalities.
 */

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil pendaftaran terakhir user
        $magang = $user->magangApplication()->latest()->first();

        // Kalau belum daftar atau status terakhirnya "reject", arahkan ke form pendaftaran
        if (!$magang || $magang->status === 'reject') {
            return redirect()->route('pendaftaran');
        }

        return view('dashboard', compact('user', 'magang'));
    }

    public function detail($id)
    {
        $magang = MagangApplication::findOrFail($id);
        return view('user.dashboard.detail', compact('magang'));
    }
}
