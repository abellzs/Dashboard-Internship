<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\MagangApplication;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CheckAttendance
{
    public function handle(Request $request, Closure $next)
    {
        // Skip jika user belum login atau di halaman presensi
        if (!Auth::check() || $request->is('change-password*')) {
            return $next($request);
        }

        $user = Auth::user();
        $userId = $user->id;

        // Cek apakah password masih default (password123)
        if (Hash::check('password123', $user->password)) {
            return redirect()->route('change-password')
                ->with('warning', 'Silakan ubah password default Anda terlebih dahulu untuk keamanan akun.');
        }
        
        // Cek apakah user memiliki magang on_going
        $hasOnGoingMagang = MagangApplication::where('user_id', $userId)
            ->where('status', 'on_going')
            ->exists();
        
        if ($hasOnGoingMagang) {
            // Cek apakah sudah absen hari ini
            $alreadyCheckedIn = Attendance::where('user_id', $userId)
                ->whereDate('date', Carbon::today())
                ->exists();

            if (!$alreadyCheckedIn && !$request->is('presensi*')) {
                return redirect('/presensi')->with('warning', 'Silakan lakukan presensi terlebih dahulu.');
            }
        }

        return $next($request);
    }
}