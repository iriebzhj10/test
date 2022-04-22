<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Depense;
use App\Models\Compte;
use App\Models\Emprunt;
use App\Models\Versement;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    //
    public function index()
    {
   
        $depenses = Depense::where('entreprise_id',Auth::user()->entreprise_id)->with('comptes')->get();
        $versements = Versement::with(['factures', 'comptes'])->where('entreprise_id',Auth::user()->entreprise_id)->get();
        $emprunts = Emprunt::with('compte')->where('entreprise_id',Auth::user()->entreprise_id)->get();
        $transfert = Depense::where('entreprise_id',Auth::user()->entreprise_id)->where('status_depense','transfert')->get();
        return response()->json([
            'depenses' => $depenses,
            'versements' => $versements,
            'emprunts' => $emprunts,
            'transfert'=>$transfert

         ]);
    }
  

}
