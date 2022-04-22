<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Depense;
use App\Models\User;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DailyQuote extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quote:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(Request $request)
    {
        

        $date_jour = Carbon::now()->day; 
        // $depense = Depense::all();
        // $user = Auth::user()->id;
        $depense_recurrente = Depense::whereNotNull('date_recurrente')
      ->where('date_recurrente', $date_jour)
      ->with([
          'comptes',
          'media'
      ])->get();
       
      foreach ($depense_recurrente as $depenseR ) {
        $id = $depenseR->id;
        $data[]  = $id;
      if ($depenseR->date_recurrente==$date_jour) {
           $replique= Depense::find($depenseR->id)->replicate();
           $replique->save();
           $update = Depense::where('date_recurrente', $date_jour)->where('created_at',Carbon::now())->update(['status'=>'à payer']);

            }
       }
       \Log::info('dupliqué');
    //    return response()->json( $depense_recurrente);
    }
}
