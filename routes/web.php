<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;
use Mews\Captcha\Facades\Captcha;

// User Controller & Livewire
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\PendaftaranController;
use App\Livewire\PendaftaranForm;
use App\Livewire\User\UserDashboard;
use App\Livewire\DashboardRouter;
use App\Livewire\Profile;

// HC Livewire Components
use App\Livewire\Hc\Dashboard as HcDashboard;
use App\Livewire\Hc\DataPeserta;
use App\Livewire\Hc\TinjauNanti;
use App\Livewire\Hc\DokumenPeserta;
use App\Livewire\Hc\ExportLaporan;
use App\Livewire\Hc\Reminder;
use App\Livewire\Hc\LowonganAvailability;
use App\Livewire\Hc\DataMagang;

use Laravel\Fortify\Fortify;

// Route landing page
Route::get('/', function () {
    return view('Landing');
})->name('home');

Route::view('/forgot-password', 'livewire.auth.forgot-password')
    ->middleware('guest')
    ->name('password.request');


// Route captcha
Route::get('captcha', function () {
    return captcha_img();
});

Route::get('/reload-captcha', function () {
    return response()->json(['captcha' => captcha_img('numeric')]);
});


Route::middleware(['auth', 'role:user'])->group(function () {

    // Pendaftaran form
    Route::get('/pendaftaran', PendaftaranForm::class)->name('pendaftaran');

    // Dashboard & detail
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Edit Profile
    Route::get('/profile', Profile::class)->name('profile');

});

Route::middleware(['auth', 'role:hc'])->prefix('hc')->name('hc.')->group(function () {
    // Dashboard Overview (Statistik)
    Route::get('/dashboard', HcDashboard::class)->name('dashboard');

    // Data Peserta
    Route::get('/data-peserta', DataPeserta::class)->name('data-peserta');

    // Dokumen Viewer
    Route::get('/lowongan-availability', LowonganAvailability::class)->name('lowongan-availability');

    // Data Anak Magang
    Route::get('/data-magang', DataMagang::class)->name('data-magang');

    // Export Data
    Route::get('/export', ExportLaporan::class)->name('export');

    // Reminder / Notifikasi
    Route::get('/reminder', Reminder::class)->name('reminder');
});


require __DIR__.'/auth.php';
