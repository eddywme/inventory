<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RestServiceMail extends Mailable
{
    use Queueable, SerializesModels;


    protected $footer = null;
    protected $header = null;
    protected $message;
    protected $origin;
    protected $destination;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message, $origin, $destination, $header = null, $footer = null)
    {
        $this->subject = $subject;
        $this->message = $message;
        $this->origin = $destination;
        $this->destination = $destination;
        $this->header = $header;
        $this->footer = $footer;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from($this->origin)
            ->to($this->destination)
            ->subject($this->subject)
            ->markdown('emails.rest.generic-mail')
            ->with([
                'message_text'  => $this->message,
                'origin'  => $this->origin,
                'footer_text'  => $this->footer,
                'header_text'  => $this->header,
            ]);
    }
}
