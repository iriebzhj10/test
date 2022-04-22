<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Projet;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Depense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;

class ProjetController extends Controller
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
        $projet = Projet::where('entreprise_id',$auth )->get();

        activity()
        //->performedOn($web)
       ->log('Projet-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'projet', $projet ,
          //  'projet_edits',  $projet ,
            'message' ,'Collecter avec success',
        ]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user()->entreprise_id;
        $projet = Projet::where('entreprise_id',$auth )->get();

        activity()
        //->performedOn($web)
       ->log('Projet-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'projet' , $projet ,
           // 'projet_edits' ,  $projet ,
            'message' , 'Collecter avec success',
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
        //

        $request->validate([
            'libelle' => ['required'],
            'budget' => ['required'],
            'date_debut' => ['required'],
            'date_fin' => ['required'],
        ]);

        $projet = Projet::create([
            'libelle'=>$request->libelle,
            'budget'=>$request->budget,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'description'=>$request->description,
            'agence_id'=>$request->agence_id,
            'entreprise_id'=>Auth::user()->entreprise_id,
            'departement_id'=>$request->departement_id,
            //'created_user'=>$request->user()->id
        ]);

        // DB::table('depense_projet')->insert([
        //     'depense_id'=> $request->depense_id,
        //     'projet_id'=>  $projet->id,
        // ]);

        activity()
        //->performedOn($web)
       ->log('Projet-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'projet', $projet ,
            'message' => 'projet crée avec success',
        ]);
        // return Inertia::render('Comptes/Projets/projet')->with('message','Compte crée avec success');
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
        $edit = Projet::find($id);

        activity()
        //->performedOn($web)
       ->log('Projet-Form-Edit')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
        'edit', $edit,
        'message' => 'Collecter avec success',
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
            'budget' => ['required'],
            'date_debut' => ['required'],
            'date_fin' => ['required'],
        ]);

       // $depense = Depense::find($id)->update([

        Projet::find($request->id)->update([
            'libelle'=>$request->libelle,
            'budget'=>$request->budget,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'description'=>$request->description,
            'agence_id'=>$request->agence_id,
            'entreprise_id'=>Auth::user()->entreprise_id,
            'departement_id'=>$request->departement_id,
            //'created_user'=>$request->user()->id
        ]);

        activity()
        //->performedOn($web)
       ->log('Projet-Update')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'projet modifié avec success',
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
        $projets = Projet::find($request->id)->delete();

        activity()
        //->performedOn($web)
       ->log('Projet-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);
        return response()->json([
            'message' => 'Projet supprimé avec success',
        ]);

    }
}
