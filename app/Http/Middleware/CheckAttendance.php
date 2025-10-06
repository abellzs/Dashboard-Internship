<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\MagangApplication;
use Carbon\Carbon;

class CheckAttendance
{
    public function handle(Request $request, Closure $next)
    {
        // Skip jika user belum login atau di halaman presensi
        if (!Auth::check() || $request->is('presensi*')) {
            return $next($request);
        }

        $userId = Auth::id();
        
        // Cek apakah user memiliki magang on_going
        $hasOnGoingMagang = MagangApplication::where('user_id', $userId)
            ->where('status', 'on_going')
            ->exists();
        
        if ($hasOnGoingMagang) {
            // Cek apakah sudah absen hari ini
            $alreadyCheckedIn = Attendance::where('user_id', $userId)
                ->whereDate('date', Carbon::today())
                ->exists();

            if (!$alreadyCheckedIn) {
                return redirect('/presensi')->with('warning', 'Silakan lakukan presensi terlebih dahulu.');
            }
        }

        return $next($request);
    }
}