<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($articles)
    {
        //
        $this->data = $articles;


    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()

    {
        return  $this->from('developpeur@qenium.com')
                     -> Subject('Mon objet personnalisé')
                     -> view('mail.SendMail');
                    //  -> render('mail.mail');


    }

}
