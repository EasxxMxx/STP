<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendApplyCourseEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $student_name;
    public $course_name;
    public $school_name;
    public $submitted_at;
    public $actionUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->student_name = $data['student_name'];
        $this->course_name = $data['course_name'];
        $this->school_name = $data['school_name'];
        $this->submitted_at = $data['submitted_at'];
        $this->actionUrl = $data['actionUrl'];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Application Submitted - StudyPal',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.applyCourseEmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

