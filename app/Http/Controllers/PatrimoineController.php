<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patrimoine;

class PatrimoineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        // dd($request->all());
        $request->validate([
            'libelle' => ['required'],
            'contact' => 'required|unique:agences',
            // 'localisation' => ['required']
        ]);




        $patrimoine=Patrimoine::create([
            'libelle' => $request->libelle,
            'type_patrimoine' => $request->description,
            'description' => $request->description,
            'montant' => $request->contact,
            // 'email' => $request->email,

        ]);

          return response()->json([
              $patrimoine,
              'message' => 'Agence créer avec success',
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
    public function update(Request $request, $id)
    {
        //
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
    }
}
