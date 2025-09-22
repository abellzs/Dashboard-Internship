<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\MagangApplication;

class MagangAcceptedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $magang;

    public function __construct(MagangApplication $magang)
    {
        $this->magang = $magang;
    }

    public function build()
    {
        return $this->subject('Pengumuman Hasil Seleksi Magang')
                    ->view('emails.magang-accepted')
                    ->with([
                        'name' => $this->magang->user->name,
                        'nim' => $this->magang->user->nim_magang,
                        'unit' => $this->magang->unit_penempatan,
                        'durasi_magang' => $this->magang->durasi_magang,
                    ]);
    }
}

