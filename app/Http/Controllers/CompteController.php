<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Compte;
use App\Models\Depense;
use App\Models\Transfert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CompteController extends Controller
{

    function __construct()
    {
        //    les permissions
        //    $this->middleware('permission:index-compte', ['only' => ['index']]);  //
        //    $this->middleware('permission:show-compte', ['only' => ['index']]);
        //    $this->middleware('permission:create-compte', ['only' => ['store']]);
        //    $this->middleware('permission:update-compte', ['only' => ['update']]);
        //    $this->middleware('permission:delete-compte', ['only' => ['destroy']]);


            // les roles
         //  $this->middleware('role:gestionnaire', ['only' => ['store','index','update','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $auth = Auth::user()->entreprise_id;
        $comptes = Compte::where('entreprise_id',Auth::user()->entreprise_id)
        ->where('delete_update_at',0)
        ->get();


        activity()
        //->performedOn($web)
       ->log('Compte-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
           $comptes,
            // 'comptes_edits'=>$comptes,
           'Compte collecté avec success',
        ]);

        //$comptes = DB::table('comptes')->get();
        //dd($comptes);

        // return Inertia::render('Comptes/Compte/compte_home')->with(['comptes'=> $comptes,'comptes_edits'=> $comptes]);
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
        $comptes = Compte::all();


        activity()
        //->performedOn($web)
       ->log('Compte-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'comptes'=>$comptes,
            'comptes_edits'=>$comptes,
            'message' => 'Compte collecté avec success',
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

        //dd($request->all());
          $request->validate([
            'numero_compte' => 'required',
            'libelle' => 'required',
            // 'description' => ['required'],
            'solde'  =>['required']
        ]);
        $auth = Auth::user()->entreprise_id;

        //$similaire = Compte::where('libelle',$request->libelle)->first();

        // if(!$similaire)
        // {
            $compte = Compte::create([
                'numero_compte' => $request->numero_compte,
                'libelle' => $request->libelle,
                'description'=> $request->description,
                'solde'=> $request->solde,
                'entreprise_id'=>$auth,
            ]);

            $id = $compte->id;
            $comptes = Compte::where('id',$id)
                        ->where('entreprise_id', Auth::user()->entreprise_id)
                         ->get();
            activity()
            //->performedOn($web)
            ->log('Compte-Store')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

            return response()->json([
                'comptes' =>$comptes,
                // 'compte'=>$compte,
                'message' => 'Compte enregistrer avec success',
            ]);
        // }
        //return back()->with('message', 'Enregistrement effectué avec success.');

       // return Inertia::render('Comptes/Compte/compte_home')->with('message', 'Enregistrement effectué avec success.');

    }


    public function transfert(Request $request){

        $montant = $request->montant;
        $compteDebit = $request->compteDebit; 
        $compteCredit = $request->compteCredit;

            //compte qui reçoit l'argent
        $compte_recev = Compte::whereId($compteCredit)->first();
        $solde =  $compte_recev->solde;

        //compte qui envoi de l'argent
        $compte_debit = Compte::whereId($compteDebit)->first();
        $solde2 =  $compte_debit->solde;

        if ($compte_recev &&   $compte_debit) {
            $montant_add = $solde + $montant;
            $montant_sous = $solde2 - $montant;
            $compte_add = Compte::whereId($compteCredit)->update(['solde'=>$montant_add]);
            $compte_sous= Compte::whereId($compteDebit)->update(['solde'=>$montant_sous]);
        }
        $tranfert = Depense::create(
            [
                'libelle'=>'transfert' ,
                'montant_depense'=>$montant,
                'entreprise_id'=>Auth::user()->entreprise_id,
                'status_depense'=>'transfert',
                'date_emission'=>Carbon::now()
            ]
        );

        $transaction = Transfert::create([
            'montant'=>  $montant ,
            'compte_crediteur'=> $compteCredit,
            'compte_debiteur'=>$compteDebit,
            'entreprise_id'=>Auth::user()->entreprise_id,
            'created_user'=>Auth::user()->id,
        ]);


        return response()->json([$montant_add,  $montant_sous, $solde2]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $edit =  Compte::find($request->id);

        activity()
        //->performedOn($web)
       ->log('Compte-Form-Edit')
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
            'numero_compte' => ['required'],
            'libelle' => 'required',
            // 'description' => ['required'],
            'solde' => ['required','regex:/^\d+(\.\d{1,2})?$/',]
        ]);

        Compte::find($request->id)->update([
            'numero_compte'=>$request->numero_compte,
            'libelle'=>$request->libelle,
            'solde'=>$request->solde,
            'description'=>$request->description,
           // 'entreprise_id'=>$auth,
            //'facture_id'=>$request->date,
        ]);


        $comptes = Compte::where('entreprise_id',Auth::user()->entreprise_id)->get();

        activity()
        //->performedOn($web)
       ->log('Compte-Update')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([

            $comptes,
            'Compte Modifié avec success',
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
        $compte=Compte::find($request->id)->get();
        if ($compte) {
            $compte_up = Compte::whereId($request->id)->update(['delete_update_at'=>1]);
        }

        activity()
        //->performedOn($web)
        ->log('Compte-destroy')
        // ->causedBy(Auth::user()->id)
        ->subject(2)
        ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Compte Supprimé avec success',
        ]);

        // return back()-> with( 'message' , 'Compte supprimé avec success' );

    }
}
