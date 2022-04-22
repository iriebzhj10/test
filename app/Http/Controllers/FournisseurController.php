<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FournisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fournisseur = User::where('entreprise_id',Auth::user()->entreprise_id)
        ->where('status_user','fournisseur')
        ->get();

        return response()->json([
            $fournisseur ,
            'Collecter avec success',
        ],200 );
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
            'nom' => 'required',
            'contact' =>'required',
            'indicateur' =>'required',
            // 'localisation' =>'required',
            'type_client' =>'required',
        ]);

        $fournisseur=User::create([
            'nom'=>$request->nom,
            'email'=>$request->email,
            'indicateur'=>$request->indicateur,
            'numero_fixe'=>$request->numero_fixe,
            'contact'=>$request->contact,
            'localisation'=>$request->localisation,
            'status_user'=>'fournisseur',
            'type_client'=>$request->type_client,
            'created_user'=>$request->user()->id,
            'entreprise_id'=> Auth::user()->entreprise_id,
            'adresse_ip'=>$request->ip(),
        ]);
        return response()->json([$fournisseur,"mesage"=>'insertion reussi']);

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
    public function update(Request $request)
    {
        //
        $request->validate([
            'nom' => 'required',
            'contact' =>'required',
            // 'localisation' =>'required',
            'type_client' =>'required',
        ]);
        $fournisseur=User::find($request->id)->update($request->all());

        $response=[
            'fournisseur'=>$fournisseur,
            'message'=>'modifié avec succes',
        ];

        return response($response,201);
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
        $fournisseur=User::find($request->id)->delete();

        $response=[
            'message'=>'supprimé avec succes',
        ];

        return response($response,201);

    }
}
