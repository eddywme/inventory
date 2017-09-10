<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApiSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("API Subscription Confirmation")
                    ->markdown('emails.rest.api-subscription-mail')
                    ->with([
                        'token'  => $this->token,
                        'user'  => $this->user
                    ]);
    }
}
