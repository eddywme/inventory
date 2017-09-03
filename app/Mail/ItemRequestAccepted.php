<?php

namespace App\Mail;

use App\ItemRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ItemRequestAccepted extends Mailable
{
    use Queueable, SerializesModels;

    protected $itemRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ItemRequest $itemRequest)
    {
        $this->itemRequest = $itemRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $item = \App\Item::where('id', $this->itemRequest->item_id)->first();
        $user = \App\User::where('id', $this->itemRequest->user_id)->first();


        return $this->view('emails.request-accepted')
            ->with([
                'item' => $item,
                'user' => $user
            ]);
    }
}
