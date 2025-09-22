<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forgot password page
        Fortify::requestPasswordResetLinkView(function () {
            return view('livewire.auth.forgot-password');
        });

        // Reset password page
        Fortify::resetPasswordView(function ($request) {
            return view('livewire.auth.reset-password', ['request' => $request]);
        });
    }
}
