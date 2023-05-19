<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mailData;

    /**
     * Create a new message instance.
     */
    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $envel = new Envelope();
        $envel->from('tnb.485@gmail.com');
        $envel->subject('Night of Bloom');
        return $envel;
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $content = new Content('emails.demo');
        $content->with(['name' => $this->mailData->name]);
        return $content;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array

     */
    public function attachments(): array
    {
        return [];
    }
}
