<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Remboursement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RemboursementController extends Controller
{
    //
        public function index()
    {
        //
        $emprunt = DB::table('Emprunts')->where('entreprise_id',Auth::user()->entreprise_id)->get();


        activity()
        //->performedOn($web)
       ->log('Remboursement-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
           'emprunt'=>$emprunt,


        ]);

       // return Inertia::render('Comptes/Emprunts/Emprunt');
    }







    public function store(Request $request)
    {
        //validation emprunt
        $request->validate([
            'libelle' => ['required'],
            'montant_verse' => ['required'],
            'emprunt_id' => ['required'],
            'date_remboursement' => ['required'],
        ]);

        // $montant_mois_remboursement = Remboursement::where('entreprise_id',Auth::user()->entreprise_id )
        //                         ->whereMonth('date_remboursement', $request->date_remboursement)
        //                         ->whereRaw("SUM(montant) as total_solde")->get();

        //     if($montant_mois_remboursement->montant_verse == $request->montant_verse  ) //$montant_mois_remboursement->total_solde
        //     {
        //         $status= 'solde';
        //     }
        //     elseif($montant_mois_remboursement->montant_verse > $request->montant_verse ){
        //         $status= 'partiel';
        //     }elseif($montant_mois_remboursement->montant_verse < $request->montant_verse ){
        //         $status= 'solde';
        //     }
        //     else{
        //         $status= 'a_payer';
        //     }

            Remboursement::Create([
                'libelle' => $request->libelle,
                'description' => $request->description,

                'montant_remboursement'=> $request->montant_remboursement,
                'montant_verse'=> $request->montant_verse,
                'date_remboursement'=>$request->date_remboursement,

                'status'=> $request->status,
                'emprunt_id'=> $request->emprunt_id,
                'entreprise_id'  => Auth::user()->entreprise_id,
            ]);


        activity()
        //->performedOn($web)
       ->log('Remboursement-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Remboursement enregistrer avec success',
        ]);

    }







    public function update(Request $request)
    {
        //
        // $request->validate([
        //     'libelle' => ['required'],
        //     'montant_verse' => ['required'],
        //     'emprunt_id' => ['required'],
        //     'date_remboursement' => ['required'],
        // ]);

        // $montant_mois_remboursement = Remboursement::where('entreprise_id',Auth::user()->entreprise_id )
        // ->whereMonth('date_remboursement', $request->date_remboursement)
        // ->whereRaw("SUM(montant) as total_solde")->get();

        // if($montant_mois_remboursement->montant_verse == $request->montant_verse  ) //$montant_mois_remboursement->total_solde
        // {
        //      $status= 'solde';
        // }
        // elseif($montant_mois_remboursement->montant_verse > $request->montant_verse ){
        //     $status= 'partiel';
        // }elseif($montant_mois_remboursement->montant_verse < $request->montant_verse ){
        //     $status= 'solde';
        // }
        // else{
        //     $status= 'a_payer';
        // }

        // Remboursement::find($request->id)->update([
        //     'libelle' => $request->libelle,
        //     'description' => $request->description,

        //     'montant_remboursement'=> $request->montant_remboursement,
        //     'montant_verse'=> $request->montant_verse,
        //     'date_remboursement'=>$request->date_remboursement,

        //     'status'=> $request->status,
        //     'emprunt_id'=> $request->emprunt_id,
        //     'entreprise_id'  => Auth::user()->entreprise_id,
        // ]);


        for($i=0;$i<$request->count;$i++)
        {


            Remboursement::find($request->item[$i]['id'])->update([
                // 'libelle' => $request->libelle,
                // 'description' => $request->description,
    
                // 'montant_remboursement'=> $request->montant_remboursement,
                // 'montant_verse'=> $request->montant_verse,
                // 'date_remboursement'=>$request->date_remboursement,
    
                'status'=> $request->item[$i]['status']['status'],
                // 'emprunt_id'=> $request->emprunt_id,
                // 'entreprise_id'  => Auth::user()->entreprise_id,
            ]);
        }


        activity()
        //->performedOn($web)
       ->log('Emprunt-Update')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Compte Modifié avec success',
        ]);
    }






    public function destroy(Request $request)
    {
        //
        $emprunts=Remboursement::find($request->id)->delete();

        activity()
        //->performedOn($web)
       ->log('Remboursement-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Remboursement Supprimé avec success',
        ]);
    }

}



// $emprunt1 = DB::table('users')
// ->join('entreprise_user', 'entreprise_user.user_id', '=', 'users.id')
// ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
// ->where('entreprises.id',Auth::user()->entreprise_id)
// ->whereNotNull('users.type_user_creancier')
// ->select('users.*')
// ->get();
