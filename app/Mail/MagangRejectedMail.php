<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\MagangApplication;

class MagangRejectedMail extends Mailable
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
                    ->view('emails.magang-rejected')
                    ->with([
                        'name' => $this->magang->user->name,
                    ]);
    }
}
