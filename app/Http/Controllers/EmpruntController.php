<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Compte;
use App\Models\Emprunt;
use App\Models\Parametre;
use Illuminate\Http\Request;
use App\Models\Remboursement;
use App\Models\TypeParametre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmpruntController extends Controller
{
    function __construct()
    {
        //    //les permissions
        //    $this->middleware('permission:index-emprunt', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-emprunt', ['only' => ['index']]);
        //    $this->middleware('permission:create-emprunt', ['only' => ['store']]);
        //    $this->middleware('permission:update-emprunt', ['only' => ['update']]);
        //    $this->middleware('permission:delete-emprunt', ['only' => ['destroy']]);

        //     //les roles
        //    $this->middleware('role:gestionnaire', ['only' => ['store','index','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
        $emprunt = Emprunt::with([
            'remboursements',
        ])
        ->where('entreprise_id',Auth::user()->entreprise_id)->get();

        $remboursements = Remboursement::with([
            'emprunt',
        ])
        ->where('entreprise_id',Auth::user()->entreprise_id)->get();

        // $emprunt1 = DB::table('emprunts')
        // ->join('remboursements', 'emprunts.id', '=', 'remboursements.emprunt_id')
        // //->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        // ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        // ->select('emprunts.,remboursements.')
        // ->get();


        $user = DB::table('users')
        ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
        ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        ->select('users.*',)
        ->get();





        $auth = Auth::user()->entreprise_id;
        $comptes = Compte::where("entreprise_id",$auth)->get();
        //$users = User::where("entreprise_id",$auth)->get();
        $creanciers = User::whereNotNull('creancier_id')
                    ->where('entreprise_id',$auth );

        //  $type_creancier = Parametre::where('type_parametre_id',11)->get();

        // $type_creancier= TypeParametre::where('libelle',"TypeCreancier")
        // ->first();
        // $id_typecreancier=$type_creancier->id;
        // $type_creancier= Parametre::where("type_parametre_id",$id_typecreancier)->get();

        $TypeCreancier = TypeParametre::whereLibelle('type creancier')->first();
        $TypeCreancierId = $TypeCreancier->id;

        $creancierList = Parametre::where('type_parametre_id',$TypeCreancierId)
        ->whereStatus('admin')
        // ->orWhere('entreprise_id',Auth::user()->entreprise_id,)
        ->get();

        //  $creanciers = DB::table('users')
        //     ->join('entreprise_user', 'entreprise_user.user_id', '=', 'users.id')
        //     ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        //     ->where('entreprises.id',Auth::user()->entreprise_id)
        //     ->whereNotNull('users.type_user_creancier')
        //     ->select('users.*')
        //     ->get();

            // $emprunt = DB::table('emprunts')->where('entreprise_id',Auth::user()->entreprise_id)->get();


        activity()
        //->performedOn($web)
       ->log('Emprunt-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
           'entreprise_connecte'=> Auth::user()->entreprise_id,
            'remboursements'=>$remboursements,
            // 'emprunt'=>$emprunt,
            'user'=>$user,
            'creanciers'=>$creanciers,
            'type_creancier'=>$creancierList,
            'auth'=>$auth,
            'compte'=>$comptes,
            // 'users'=>$users,
            'emprunts'=>$emprunt,
            'message' => 'Emprunts collecté avec success',
        ]);

       // return Inertia::render('Comptes/Emprunts/Emprunt');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $auth = Auth::user()->entreprise_id;
        $cmpt = Compte::where("entreprise_id",$auth)->get();
        $emprunts = Emprunt::all();

        $TypeCreancier = TypeParametre::whereLibelle('type creancier')->first();
        $TypeCreancierId = $TypeCreancier->id;

        $creancierList = Parametre::where('type_parametre_id',$TypeCreancierId)
        ->whereStatus('admin')
        // ->orWhere('entreprise_id',Auth::user()->entreprise_id,)
        ->get();

        activity()
        //->performedOn($web)
       ->log('Emprunt-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            Auth::user()->entreprise_id,
            'creancierList'=>$creancierList,
            'compte'=>$cmpt,
            'auth'=>$auth,
            'emprunts'=>$emprunts,
            'message' => 'Emprunts collecté avec success',
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validation emprunt
        $request->validate([
            'libelle' => ['required'],
            'montant' => ['required'],
            // 'taux' => ['required'],
            // 'delai' => ['required'],
            'date_emprunt' => ['required'],
            // 'date_remboursement' => [],
            'creancier_id'  => ['required'],
            'entreprise_id'  => ['required'],
            'compte_id'  => ['required']
        ]);
                $montant = $request->montant;
                $taux = $request->taux;
                $mt =  $montant * (1+$taux/100);

        $emprunt = Emprunt::firstOrCreate([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant'=>$mt,
            'taux'=> $request->taux,
            'delai'=> $request->delai,
            'date_emprunt'=>$request->date_emprunt,
            'date_remboursement'=>$request->date_remboursement,
            'creancier_id'  => $request->creancier_id,
            'entreprise_id'  =>Auth::user()->entreprise_id,
            'compte_id'  => $request->compte_id,
            'status'  => 'à rembourser',
        ]);

        for($i=0;$i<$request->count;$i++)
        {
            Remboursement::Create([
                // 'libelle' => $request->libelle_remboursement[$i],
                // 'description' => $request->description_remboursement,

                'montant_remboursement'=> $request->item[$i]['montant'],
                // 'montant_verse'=> $request->montant_verse,
                'date_remboursement'=>$request->item[$i]['date'],
                'status'=>$request->item[$i]['status'],

                'emprunt_id'=> $emprunt->id,
                'entreprise_id'  => Auth::user()->entreprise_id,
            ]);
            $dateR = Emprunt::find($emprunt->id)->update([
                'date_remboursement'=> $request->item[0]['date'],
            ]);
        }


        // $remboursements = Emprunt::withSum('remboursements','montant_remboursement')->get();
        // for ($i=0; $i <count($remboursements) ; $i++) { 
        //     $impaye = $remboursements[$i]->montant - $remboursements[$i]->remboursements_sum_montant_remboursement;
        //                         $paye = $remboursements[$i]->remboursements_sum_montant_remboursement;
                              
        //                         if ($remboursements[$i]->montant == $remboursements[$i]->remboursements_sum_montant_remboursement) {
        //                             $status = Emprunt::where('id',$remboursements[$i]->id)->update([
        //                                 // 'status'=>'réglé',
        //                                 'impaye'=> $impaye,
        //                                 'paye'=> $paye,
        //                             ]);
        //                            }

        //                            if ($remboursements[$i]->montant !== $remboursements[$i]->remboursements_sum_montant_remboursement) {
        //                             $status = Emprunt::where('id',$remboursements[$i]->id)->update([
        //                                 // 'status'=>'à payer',
        //                                 'impaye'=> $impaye,
        //                                 'paye'=> $paye,
        //                             ]);
        //                            }

        //                            if ($remboursements[$i]->remboursements_sum_montant_remboursement == null) {
        //                             $status = Emprunt::where('id',$remboursements[$i]->id)->update([
        //                                 // 'status'=>'à payer',
        //                                    'impaye'=> $impaye,
        //                                 'paye'=> $paye,
        //                             ]);
        //                            }

        // }

        





           //if compte does not existe  2




        activity()
        //->performedOn($web)
       ->log('Emprunt-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Emprunt enregistrer avec success',
        ]);

    }

    public function remboursement(Request $request){
        for($i=0;$i<$request->count;$i++)
        {
            Remboursement::Create([
                'emprunt_id'=> $request->emprunt_id,
                'montant_remboursement'=> $request->item[$i]['montant'],
                'date_remboursement'=>$request->item[$i]['date'],
                'entreprise_id'  => Auth::user()->entreprise_id,
            ]);
            // $dateR = Emprunt::find($emprunt->id)->update([
            //     'date_remboursement'=> $request->item[0]['date'],
            // ]);
        }  
        
        // $remboursements = Emprunt::withSum('remboursements','montant_remboursement')->get();
        // for ($i=0; $i <count($remboursements) ; $i++) { 
        //     $impaye = $remboursements[$i]->montant - $remboursements[$i]->remboursements_sum_montant_remboursement;
        //                         $paye = $remboursements[$i]->remboursements_sum_montant_remboursement;
                              
        //                         if ($remboursements[$i]->montant== $remboursements[$i]->remboursements_sum_montant_remboursement) {
        //                             $status = Emprunt::where('id',$remboursements[$i]->id)->update([
        //                                 // 'status'=>'réglé',
        //                                 'impaye'=> $impaye,
        //                                 'paye'=> $paye,
        //                             ]);
        //                            }

        //                            if ($remboursements[$i]->montant !== $remboursements[$i]->remboursements_sum_montant_remboursement) {
        //                             $status = Emprunt::where('id',$remboursements[$i]->id)->update([
        //                                 // 'status'=>'partiel',
        //                                 'impaye'=> $impaye,
        //                                 'paye'=> $paye,
        //                             ]);
        //                            }

        //                            if ($remboursements[$i]->remboursements_sum_montant_remboursement == null) {
        //                             $status = Emprunt::where('id',$remboursements[$i]->id)->update([
        //                                 // 'status'=>'à payer',
        //                                    'impaye'=> $impaye,
        //                                 'paye'=> $paye,
        //                             ]);
        //                            }

        // }

            return response()->json( ['message'  =>'remboursement effectué avec success']);
    }



    public function updateStatut(Request $request){
        
        $updateStatus = Remboursement::whereId($request->id)->update(['status'=>$request->status]);
          
        $remb = Remboursement ::whereId($request->id)->first();
        $empId =  $remb->emprunt_id;

        //montant cliqué pour le remboursement
        $montant_remb = $remb->montant_remboursement;

        $emprunt = Emprunt::whereId($empId)->get();

        for ($i=0; $i <count($emprunt) ; $i++) { 
            $paye =   $emprunt[$i]->paye;
            $impaye = $emprunt[$i]->impaye;
            //montant de l'emprunt
            $montant_emprunt = $emprunt[$i]->montant;
             //on additionne paye(0) + montant du remboursement
             $somme_paye = $paye + $montant_remb;
                //on recupere la somme restant a rembourser
            $somme_impaye = $montant_emprunt - $somme_paye;

             if ($somme_paye < $montant_emprunt) {
                //  $statut = 'partiel';
                 $emprunt_up = Emprunt::whereId($emprunt[$i]->id)->update([
                    'paye'=>$somme_paye,
                    'impaye'=>$somme_impaye,
                    'status'=>'partiel',
                ]);
             }

             if ($somme_impaye == 0) {
                // $statut = 'remboursé';
                $emprunt_up = Emprunt::whereId($emprunt[$i]->id)->update([
                    'paye'=>$somme_paye,
                    'impaye'=>$somme_impaye,
                    'status'=>'remboursé',
                ]);
             }

          
        }
            


           

             

            
         
            

     


        // return response()->json([$remb,   $empId, $montant_remb,  $emprunt,   $paye, $somme_paye, $somme_impaye,$montant_emprunt]);
        return response()->json('Status changé avec success');
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $edit =  Emprunt::find($id);

        activity()
        //->performedOn($web)
       ->log('Emprunt-Form-Edit')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'edit' =>  $edit ,
            'message' => 'modifier avec success',
        ]);


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $request->validate([
            'libelle' => ['required'],
            //'description' => ['required'],
            'montant' => ['required'],
            'taux' => ['required'],
            'delai' => ['required'],
            'date_emprunt' => ['required'],
            'date_remboursement' => ['required'],
            'creancier_id'  => ['required'],
            'entreprise_id'  => ['required'],
            'compte_id'  => ['required']
        ]);

       $emprent= Emprunt::find($request->id)->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant'=> $request->montant,
            'taux'=> $request->taux,
            'delai'=> $request->duree,
            'date_emprunt'=>$request->date_emprunt,
            'date_remboursement'=>$request->date_rembourssement,
            'creancier_id'  => $request->creancier_id,
            'entreprise_id'  => Auth::user()->entreprise_id,
            'compte_id'  => $request->compte_id,
            'status'  => $request->status,
        ]);

        // for($i=0;$i<$request->count;$i++)
        // {

        //     Remboursement::find($request->remboursement_id[$i])->update([
        //         'libelle' => $request->libelle_remboursement[$i],
        //         'description' => $request->description_remboursement, //remove for test[$i]

        //         'montant_remboursement'=> $request->montant_remboursement,
        //         'montant_verse'=> $request->montant_verse,
        //         'date_remboursement'=>$request->date_remboursement, //[$i],
        //         'status'=>$request->status[$i],// [$i],

        //         //'emprunt_id'=> $emprunt->id,
        //        // 'entreprise_id'  => Auth::user()->entreprise_id,
        //     ]);

        //     // return response()->json([
        //     //     'message' => 'Compte Modifié avec success bbbb',
        //     // ]);


        // }


        // Remboursement::find($emprent->id)->update([
        //     'libelle' => $request->libelle,
        //     'description' => $request->description,

        //     'montant_remboursement'=> $request->montant_remboursement,
        //     'montant_verse'=> $request->montant_verse,
        //     'date_remboursement'=>$request->date_remboursement,

        //     'emprunt_id'=> $request->emprunt_id,
        //     'entreprise_id'  => Auth::user()->entreprise_id,
        // ]);


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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $emprunts=Emprunt::find($request->id)->delete();

        activity()
        //->performedOn($web)
       ->log('Emprunt-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Compte Supprimé avec success',
        ]);
    }
}
