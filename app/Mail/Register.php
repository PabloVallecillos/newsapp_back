<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Register extends Mailable
{
    use Queueable, SerializesModels;

    private $user;
    public $view;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user, String $view)
    {
        $this->user = $user;
        $this->view = $view;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__('email.register_new_user').' '.$this->user->name)
            ->to($this->user->email)
            ->view($this->view)
            ->with(['user' => $this->user]);
    }
}
