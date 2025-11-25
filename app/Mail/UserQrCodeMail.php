<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserQrCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $qrPath;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $qrPath)
    {
        $this->user = $user;
        $this->qrPath = $qrPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Qr Code Keanggotaan Anda! | Rey Fitnes',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.user_qr',
            with: [
                'user' => $this->user,
                'qrPath' => $this->qrPath,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(storage_path('app/public/' . $this->qrPath))
                ->as('membership-qr.png')
                ->withMime('image/png'),
        ];
    }
}