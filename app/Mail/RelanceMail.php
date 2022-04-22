<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
//use Inertia\inertia;

//use App\User; 

class RelanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $clients = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $clients)
    {
        //
        $this->clients = $clients;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('developpeur@qenium.com')
                    ->subject('solo')
                    ->view('mail/RelanceMail');


       // return $this->view('mail/RelanceMail');
        //return Inertia::render('mail/RelanceMail');
    }
}
