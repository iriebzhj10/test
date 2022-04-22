<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Agence;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgenceController extends Controller
{

     //les permissions
     function __construct()
    {
    //  $this->middleware('permission:index-agence', ['only' => ['index']]);  
    //  $this->middleware('permission:show-agence', ['only' => ['index']]);
    //  $this->middleware('permission:create-agence', ['only' => ['store']]);
    //  $this->middleware('permission:update-agence', ['only' => ['update']]);
    //  $this->middleware('permission:delete-agence', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        //
        $auth = Auth::User()->Entreprise_id;
        $agences = Agence::where('entreprise_id', $auth)->get();

        return response()->json([
            'agences' =>  $agences ,
            'agences_edit' =>  $agences ,
            'message' => 'Collecter avec success',
        ]);

        // return Inertia::render('Factures/Entreprises/Agences/agence_home')->with([
        //         'agences'=>$agences,
        //         'agences_edit'=>$agences
        // ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::User()->Entreprise_id;
        $agences = Agence::where('entreprise_id', $auth)->get();

        return response()->json([
            'agences' =>  $agences ,
            'agences_edit' =>  $agences ,
            'message' => 'Collecter avec success',
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
        // dd($request->all());
        $request->validate([
            'libelle' => ['required'],
            'contact' => 'required|unique:agences',
            // 'localisation' => ['required']
        ]);

        //$res = Entreprise::where('id',$request->libelle)->first();
        // $similaire = Agence::where('libelle',$request->libelle)->first();

        // if(!$similaire)


        // dd($request->all());
        $agence=Agence::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'contact' => $request->contact,
            'email' => $request->email,
            // 'localisation' => $request->localisation,

        ]);

          return response()->json([
            'message' => 'Agence créer avec success',
        ]);


        // return back()-> with( 'message' , 'Agence créer avec success' );
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
        $agences = Agence::find($id);
        return response()->json([
            'message' => 'Agence collectée avec success',
        ]);
        // return Inertia::render('Factures/Entreprises/Agences/agence_home')->with('agences',$agences);

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
        // $libelle_verifier = Agence::where('libelle',$request->libelle)->first();

        // if(!$libelle_verifier)
        //    Agence::find($request->id)->update($request->all());

        //    return redirect()->route('agence')
        //   ->with('message', 'Type parametre edite avec success.');

        $request->validate([
            'libelle' => ['required'],
            'description' => ['required'],
            'contact' => ['required'],
            'email' => ['email'],
            'localisation' => ['required'],
        ]);


        // $agences = Agence::find($id)->update([
        //     'libelle' => $request->libelle,
        //     'description' => $request->description,
        //     'matricule' => $request->matricule,
        //     'contact' => $request->contact,
        //     'email' => $request->email,
        //     'localisation' => $request->localisation,
        //     'adresse' => $request->adresse,
        //     'longitude' => $request->longitude,
        //     'latitude' => $request->latitude,
        // ]);

        // return back()-> with( 'message' , 'votre agence modifié avec success' );
        Agence::find($request->id)->update($request->all());
        // dd($request->all());
        return response()->json([
            'message' => 'Agence Modifier avec success',
        ]);
        // return back()->with('message','Modifier');

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
        // Agence::find($id)->delete($id);
        // return redirect()->route('agence')
        //                  ->with('message', 'Product created successfully.');

        $agence = Agence::find($id)->delete();
        // dd($id);
        return response()->json([
            'message' => 'Agence supprimé avec success',
        ]);
        // return back()-> with( 'message' ,'Agence supprimé' );
    }
}
