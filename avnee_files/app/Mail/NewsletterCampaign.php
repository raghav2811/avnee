<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterCampaign extends Mailable
{
    use Queueable, SerializesModels;

    public string $subject_line;
    public string $body_content;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject_line, string $body_content)
    {
        $this->subject_line = $subject_line;
        $this->body_content = $body_content;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject_line,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.newsletter',
            with: [
                'subject_line' => $this->subject_line,
                'body_content' => $this->body_content,
            ],
        );
    }
}
