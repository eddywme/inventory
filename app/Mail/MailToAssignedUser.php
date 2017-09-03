<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailToAssignedUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $message;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message, $user)
    {
        $this->message = $message;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.to-assigned-user')
        ->with([
          'user'  => $this->user,
          'message_text'  => $this->message,
    ]);
    }
}
