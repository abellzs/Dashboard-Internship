<?php

namespace App\Livewire;

use App\Models\Attendance;
use App\Models\MagangApplication;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PresensiMenu extends Component
{
    public $user;
    public $status = '';
    public $userUnit;
    public $keterangan = '';
    public $latitude;
    public $longitude;
    public $today;
    public $currentTime;
    public $alreadyCheckedIn = false;

    public function mount()
    {
        $this->user = Auth::user();
        $this->today = Carbon::now('Asia/Jakarta')->toDateString();
        $this->userUnit = $this->getUserUnit();
        // $this->today = "2025-10-05"; Testing hari libur
        $this->currentTime = Carbon::now('Asia/Jakarta')->format('H:i:s');
        // $this->currentTime = "07:30:00"; // Testing terlambat
        $this->alreadyCheckedIn = $this->alreadyCheckedIn();
    }

    public function render()
    {
        return view('livewire.user.presensi-menu')
            ->layout('components.layouts.app', ['title' => 'Dashboard Presensi']);
    }

    public function presensi()
    {
        if (!$this->user) {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
        $officeStart = '08:01:00';
        $radius = 200;

        // Ambil unit penempatan user
        $unit = $this->userUnit;

        // Default koordinat Kota Baru
        $officeLat = -7.7863;
        $officeLng = 110.3749;
        $userLat = $this->latitude;
        $userLng = $this->longitude;

        // Cek unit penempatan dan ambil koordinat dari tabel lowongans
        if ($unit) {
            $lowongan = \App\Models\Lowongan::where('nama_unit', $unit)->first();
            if ($lowongan !== null) {
                if (
                    str_contains($lowongan->lokasi, 'Bantul') ||
                    str_contains($lowongan->lokasi, 'Sleman') ||
                    str_contains($lowongan->lokasi, 'Gunung Kidul')
                ) {
                    $distance = $this->distance(-7.7863, 110.3749, $userLat, $userLng);
                    if ($distance > $radius) {
                        if (str_contains($lowongan->lokasi, 'Bantul')) {
                            $officeLat = -7.892670;
                            $officeLng = 110.335484;
                        } elseif (str_contains($lowongan->lokasi, 'Sleman')) {
                            $officeLat = -7.715003;
                            $officeLng = 110.356041;
                        } elseif (str_contains($lowongan->lokasi, 'Gunung Kidul')) {
                            $officeLat = -7.967102;
                            $officeLng = 110.602979;
                        }
                    }
                }
            } else {
                $officeLat = -7.7863;
                $officeLng = 110.3749;
            }
        }

        // Cek hari Sabtu/Minggu
        $dayOfWeek = Carbon::parse($this->today)->dayOfWeekIso; // 6=Sabtu, 7=Minggu
        if ($dayOfWeek >= 6) {
            return redirect()->back()->with('error', 'Check-in hanya bisa dilakukan pada hari kerja.');
        }

        // Cek hari libur nasional via API
        $holidayApi = "https://api-harilibur.vercel.app/api";
        try {
            $client = new Client();
            $response = $client->get($holidayApi);
            $holidays = json_decode($response->getBody(), true);
            foreach ($holidays as $holiday) {
                if ($holiday['holiday_date'] === $this->today) {
                    return redirect()->back()->with('error', 'Hari ini adalah hari libur nasional, check-in tidak diperbolehkan.');
                }
            }
        } catch (\Exception $e) {
            // Jika gagal ambil data libur, bisa lanjut atau tampilkan error
            return redirect()->back()->with('error', 'Gagal memeriksa hari libur nasional.');
        }


        $existingAttendance = Attendance::where('user_id', $this->user->id)
            ->whereDate('date', $this->today)
            ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('error', 'Anda sudah melakukan check-in hari ini.');
        }

        // Status Izin dan Tidak Hadir tidak perlu cek lokasi
        if ($this->status === 'Izin' || $this->status === 'Tidak Hadir') {
            Attendance::create([
                'user_id' => $this->user->id,
                'date' => $this->today,
                'check_in' => $this->currentTime,
                'status' => $this->status,
                'keterangan' => $this->keterangan,
            ]);
            return redirect()->back()->with('success', 'Check-in berhasil dengan status: ' . $this->status);
        }

        if (!$userLat || !$userLng) {
            return redirect()->back()->with('error', 'Lokasi tidak terdeteksi.');
        }

        $distance = $this->distance($officeLat, $officeLng, $userLat, $userLng);

        if ($distance > $radius) {
            return redirect()->back()->with('error', 'Anda di luar area, check-in gagal. User lokasi: ' . $userLat . ', ' . $userLng);
        }

        // Cek waktu
        if ($this->currentTime <= $officeStart) {
            $this->status = 'Hadir';
        } else {
            $this->status = 'Terlambat';
        }

        // Simpan presensi
        Attendance::create([
            'user_id' => $this->user->id,
            'date' => $this->today,
            'check_in' => $this->currentTime,
            'status' => $this->status,
            'keterangan' => $this->keterangan,
        ]);
        $this->alreadyCheckedIn = $this->alreadyCheckedIn();
        return redirect()->back()->with('success', 'Check-in berhasil!');
    }

    public function logout()
    {
        Auth::guard('presensi')->logout();
        request()->session()->regenerate();

        return redirect()->route('presensi.login');
    }

    public function distance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // meter
        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLng / 2) * sin($dLng / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c;

        return $distance; // dalam meter
    }

    public function getUserUnit()
    {
        if (!$this->user) {
            return 'User tidak ditemukan';
        }

        // Ambil unit dari MagangApplication berdasarkan user_id
        $magangApplication = MagangApplication::where('user_id', $this->user->id)
            ->where('status', 'on_going') // Hanya yang sudah disetujui
            ->orderBy('tanggal_mulai_usulan', 'desc')
            ->first();

        if (!$magangApplication) {
            return 'Aplikasi magang belum disetujui';
        }

        return $magangApplication->unit_penempatan ?? null;
    }

    public function alreadyCheckedIn()
    {
        $existingAttendance = Attendance::where('user_id', $this->user->id)
            ->whereDate('date', $this->today)
            ->first();

        return $existingAttendance !== null;
    }
}
