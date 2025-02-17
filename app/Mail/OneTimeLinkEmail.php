<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OneTimeLinkEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $signedUrl;
    public function __construct($signedUrl)
    {
        $this->signedUrl = $signedUrl;
    }

    public function build()
    {
        return $this->subject('Your One-Time Access Link')
            ->view('email.one-time-link')
            ->with(['signedUrl' => $this->signedUrl]);
    }
}
