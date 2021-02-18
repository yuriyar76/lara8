<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPostsend extends Mailable
{
    use Queueable, SerializesModels;
    protected $username;
    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mess, $name)
    {
         $this->username = $name;
         $this->message = $mess;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view(env('THEME') . '.email');
    }
}
