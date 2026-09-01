<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resetLink;
    public $type;

    public function __construct($resetLink, $type = 'admin')
    {
        $this->resetLink = $resetLink;
        $this->type = $type;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset your StudyPal Password',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.resetPasswordLink',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
