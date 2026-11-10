<?php

namespace App\Mail;

use App\Models\PartnerApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PartnerApplicationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PartnerApplication $partnerApplication)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Partner Application: ' . $this->partnerApplication->full_name,
            replyTo: [new Address($this->partnerApplication->email, $this->partnerApplication->full_name)],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.partner-application-received',
        );
    }

    /**
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
