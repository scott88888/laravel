<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class mfrMall extends Mailable
{
    use Queueable, SerializesModels;
    public $dueNumlist;
    public $subject;

    public function __construct($dueNumlist, $subject)
    {
        $this->dueNumlist = $dueNumlist;
        $this->subject = $subject;
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }
    public function content(): Content
    {
        return new Content(
            view: 'emails.mfr_mail',
        );
    }
    public function attachments(): array
    {
        return [];
    }
}
