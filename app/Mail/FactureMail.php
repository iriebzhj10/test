<?php

namespace App\Mail;

use App\Models\Entreprise;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FactureMail extends Mailable
{
    use Queueable, SerializesModels;

   public $pdf ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pdf)
      
    {
        //
        $this->pdf = $pdf;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        
        // $entreprise_id= DB::table('factures')->select('entreprise_id')->where('id',$details_facture->id)->get(); // liste des articles du pivot
        // $entreprise = Entreprise::where('id',$entreprise_id[0]->entreprise_id)->first();
    
        // $entreprise_id=Auth::user()->entreprise_id;
        // $entreprise= Entreprise::where('id',$entreprise_id)->get();

        // $entreprise_id=Auth::user()->entreprise_id;
        $entreprise = Entreprise::where('id', 1)->first();

        // $entreprise= Entreprise::where('id',$entreprise_id)->select('email')->get();


        return $this->from($entreprise->email)
                    ->view('my-pdf-file',$pdf);
                     
                   
    }
}
