<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Activite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ActiviteController extends Controller
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
        $activites = Activite::all();

        //     activity()
        //     ->performedOn($projet)
        //    ->log('Activite-Index');

        return response()->json([
            'auth' => $auth,
            'projet' => $projet,
            'activite' => $activites,
            'message' => 'Activités collectées avec success',

        ]);

        //return Inertia::render('Apermission/apermission')->with('data',$data);
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
        $activites = Activite::all();

        activity()
        //->performedOn($web)
       ->log('Activite-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'auth' => $auth,
            'projet' => $projet,
            'activite' => $activites,
            'message' => 'Activités collectées avec success',

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
            ]);

            $auth = Auth::user()->entreprise_id;
            $projet = Projet::where('entreprise_id',$auth )->get();


            Activite::create([
                'libelle'=>$request->libelle,
                'description'=>$request->description,
                'projet_id' =>$request->projet_id,

            ]);

            activity()
            //->performedOn($web)
           ->log('Activite-Store')
           // ->causedBy(Auth::user()->id)
           ->subject(2)
           ->withProperties(['test' => 'value']);

            return response()->json([
            'message' => 'Activité enregistrée avec success',
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $edit =  Activite::find($id);

        activity()
        //->performedOn($web)
       ->log('Activite-Form-Edit')
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
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'libelle' => ['required'],
            'description' => ['required'],
        ]);


        Activite::find($request->id)->update([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'projet_id' =>$request->projet_id,

        ]);

        activity()
        //->performedOn($web)
       ->log('Activite-Update')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
        'message' => 'Activité Modifiée avec success',
        ]);

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
        $activites=Activite::find($id)->delete();

        activity()
        //->performedOn($web)
       ->log('Activite-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Activite Supprimée avec success',
        ]);
    }
}
