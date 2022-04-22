<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Compte;
use App\Models\Creancier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CreancierController extends Controller
{

    function __construct()
    {
           //les permissions
        //    $this->middleware('permission:index-creancier', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-creancier', ['only' => ['index']]);
        //    $this->middleware('permission:create-creancier', ['only' => ['store']]);
        //    $this->middleware('permission:update-creancier', ['only' => ['update']]);
        //    $this->middleware('permission:delete-creancier', ['only' => ['destroy']]);


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
        // $auth = Auth::user()->entreprise_id;
        $creanciers = user::where('entreprise_id' , Auth::user()->entreprise_id)
                            ->whereNotNull('creancier_id')->get();
        // $creanciers = user::all();

        //$users = User::where("entreprise_id",$auth)->get();


        activity()
        //->performedOn($web)
       ->log('Creancier-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

       return response()->json([
        $creanciers,
        'creancier collecté avec success',
     ]);

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
        //$creancier = Creancier::all();


        activity()
        //->performedOn($web)
       ->log('Creancier-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'auth',$auth,
            'compte',$cmpt,
            'message' => 'creation',
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
            'nom' => ['required'],
            // 'prenoms' => ['required'],
            'contact' => 'required',
            'creancier_id' => ['required'],
            //'ville' => [''],
        ]);

        $creancier = User::create([
            'nom'=> $request->nom,
            'prenoms' => $request->prenoms,
            'contact'=> $request->contact,
            'indicateur'=> $request->indicateur,
            'localisation'=> $request->localisation,
            'creancier_id'=> $request->creancier_id,
            'type_user_creancier'=>'creancier',  // creancier
            'status_user'=>'creancier',  // creancier
        ]);

        $pivot = DB::table('entreprise_user')->insert(
            array(
                'entreprise_id' =>Auth::user()->entreprise_id,
                'user_id' => $creancier->id,
                'created_at'=> Carbon::now(),
                'updated_at'=>Carbon::now(),
            )
        );


        activity()
        //->performedOn($web)
       ->log('Creancier-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            $request->creancier_id,
            'pivot', $pivot,
            'message' => 'Creancier enregistrer avec success',
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
        $edit =  User::find($id);


        activity()
        //->performedOn($web)
       ->log('Creancier-Form-Edit')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'edit' ,$edit ,
            'message','modifier avec success',
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
            'nom' => ['required'],
            'premons' => ['required'],
            'contact' => 'required|numeric',
            'ville' => ['required'],
        ]);

        User::find($request->id)->update([
            'nom'=> $request->nom,
            'premons' => $request->prenoms,
            'contact'=> $request->contact,
            'ville'=> $request->ville,
        ]);


        activity()
        //->performedOn($web)
       ->log('Creancier-Update')
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
        $emprunts=User::find($request->id)->delete();

        activity()
        //->performedOn($web)
       ->log('Creancier-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Creancier supprimé Supprimé avec success',
        ]);
    }
}
