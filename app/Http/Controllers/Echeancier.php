<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facture;


class Echeancier extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $auth = Auth::user()->entreprise_id;
        //$auth = Auth::Entreprise()->id;
        //dd($auth);
        $facture = Facture::where('entreprise_id',$auth )->get();
        //dd($depense );
        return Inertia::render('Comptes/Depenses/depense')-> with( ['depense' => $depense , 'depense_edits' => $depense]);
    }

 

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'libelle'=>['required'],
            'description'=>['required'],
            'date'=>['required'],
            'montant'=>['required','numeric'],
        ]);


        //$auth = Auth::user()->entreprise_id;//entreprise_id
        //$agence = Agence::where('entreprise_id',$auth ); //agence_id


     
        $depense = Depense::Create([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'montant'=>$request->montant,
            'date'=>$request->date,
        ]);
        
            return back()-> with( 'message' , 'echeancier enregistré avec success' );
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'libelle'=>['required'],
            'description'=>['required'],
            'date'=>['required'],
            'montant'=>['required','numeric'],
        ]);

        $auth = Auth::User()->Entreprise_id;

        Facture::find($request->id)->update([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'montant'=>$request->montant,
            'date'=>$request->date,
            'entreprise_id'=>$auth,
            //'facture_id'=>$request->date,
        ]);
        return back()-> with( 'message' , 'Echeancier Modifié avec success' );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $facture=Facture::find($id)->delete();
    }
}
