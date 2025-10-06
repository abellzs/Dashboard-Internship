<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class ChangePassword extends Component
{
    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function render()
    {
        return view('livewire.user.change-password');
    }

    public function updatePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->current_password, $user->password)) {
            $this->addError('current_password', 'Password lama tidak sesuai.');
            return;
        }

        if ($this->new_password === $this->current_password) {
            $this->addError('new_password', 'Password baru tidak boleh sama dengan password lama.');
            return;
        }

        if ($this->new_password !== $this->new_password_confirmation) {
            $this->addError('new_password_confirmation', 'Konfirmasi password baru tidak sesuai.');
            return;
        }

        try {
            // Update password
            $user->password = Hash::make($this->new_password);
            $passwordUpdated = $user->save(); // save() returns boolean

            if ($passwordUpdated) {
                // Reset form
                $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

                // Flash success message
                session()->flash('status', 'Password berhasil diubah!');
            } else {
                session()->flash('error', 'Gagal mengubah password. Coba lagi.');
            }
        } catch (\Exception $e) {
            // Jika ada error saat save
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
