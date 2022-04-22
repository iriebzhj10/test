<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prevision;
use App\Models\Parametre;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class PrevisionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fournir la liste des type
        // $type_depense = Parametre::where('entreprise',Auth::user()->entreprise_id)
        // ->where('typarametre_id', 10000)->get();   // index du type parametre a definir

        $previsions=Prevision::where('entreprise_id',Auth::user()->entreprise_id)->get();

        return response()->json([
            '$previsions'=>$previsions,
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
            'description' => ['required'],
            'montant' => ['required'],
            'date_debut ' => ['required'],
            'date_fin' => ['required'],
        ]);

        $prevision=Prevision::create([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'montant'=>$request->montant,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'status'=>$request->status,

            'entreprise_id'=>Auth::user()->entreprise_id,
            'type_depense_id '=>$request->type_depense_id ,
            'created_user'=>auth()->user()->id,
        ]);
        return response()->json([
            $prevision,
        ]);
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
            'description' => ['required'],
            'montant' => ['required'],
            'date_debut ' => ['required'],
            'date_fin' => ['required'],
        ]);

        $prevision=Prevision::find($request->id)->update([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'montant'=>$request->montant,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'status'=>$request->status,

            'entreprise_id'=>Auth::user()->entreprise_id,
            'type_depense_id '=>$request->type_depense_id ,
            'created_user'=>auth()->user()->id,
        ]);

        return response()->json([
            'message'=> 'prevision enregistré avec success',
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

        Prevision::find($request->id)->delete();
        return response()->json([
            'message'=> 'prevision supprimée avec success',
        ]);
    }
}
