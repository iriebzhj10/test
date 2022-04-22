<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Prospection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;




class ProspectionController extends Controller
{
    
    function __construct()
    {
        //  $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        // //  $this->middleware('permission:product-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:product-delete', ['only' => ['destroy']]);

            // $this->middleware('permission:update-prospect', ['only' => ['update']]);
            // $this->middleware('permission:index-prospect', ['only' => ['index']]);
            // $this->middleware('permission:store-prospect', ['only' => ['store']]);
            // $this->middleware('permission:delete-prospect', ['only' => ['destroy']]);
           //$this->middleware('role:employee', ['only' => ['store']]);nn
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $prospections = Prospection::where('entreprise_id',Auth::user()->entreprise_id)
        ->with('prospects')
        ->get();
        return response()->json([
            'prospections'=>$prospections
        ]);
    }

    public function indexProspect()
    {
        //
        $prospects = User::where('entreprise_id',Auth::user()->entreprise_id)
        ->whereIn('status_user',['prospect','client'])
        ->get();

        $prospect_liste = User::where('entreprise_id',Auth::user()->entreprise_id)
        ->where('status_user','prospect')
        ->get();
        return response()->json([
            'prospects'=>$prospects,
            'prospect_liste'=>$prospect_liste,
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
            'libelle'=> 'required',
            // 'description' => 'required',
            'date_debut'=>'required',
            // 'date_fin'=>'required'
        ]);

       $prospection =  prospection::firstOrCreate([
            'libelle'=> $request->libelle,
            'description'=>$request->description,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'entreprise_id'=>Auth::user()->entreprise_id,
            'created_user'=>Auth::user()->id,
        ]);

        for($i=0;$i<$request->count;$i++)
        {
            DB::table('prospection_user')->insert(
                array(
                'prospection_id' =>   $prospection->id,
                'user_id' =>  $request->item[$i]['selectedProspectId'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
                ));

            // $prospection->prospects()->attach($prospection->id,[
            //     // 'prospection_id'=>$prospection->id,
            //    'user_id' =>  $request->item[$i]['selectedProspectId'],
            // ]);
        }

        return response()->json(
            [
                'message'=> 'enregistrer avec sucess',
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
            'libelle'=> 'required',
            // 'description' => 'required',
            'date_debut'=>'required',
            // 'date_fin'=>'required'
        ]);

      prospection::find($request->id)->update([
            'libelle'=> $request->libelle,
            'description'=>$request->description,
            'date_debut'=>$request->date_debut,
            'date_fin'=>$request->date_fin,
            'entreprise_id'=>Auth::user()->entreprise_id,
            // 'employe_id'=>$request->employe->id,
            'created_user'=>Auth::user()->id,
        ]);

        return response()->json([
            'message'=> 'modifier avec sucess',
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
        Prospection::find($request->id)->delete();

        return response()->json([
            'message'=>'supprim2 avec sucess',
        ]);

    }

    public function createProspect(Request $request)
    {
       $request->validate([
        'nom'=>'required',
        // 'prenoms'=>'required',
        'indicateur'=>'required',
        'contact'=>'required',
        // 'email'=>'required',
        ]) ;

       $user = User::firstOrCreate([
            'nom'=>$request->nom,
            'prenoms'=>$request->prenoms,
            'indicateur'=>$request->indicateur,
            'contact'=>$request->contact,
            'status_user'=>'prospect',
            'type_client'=>$request->type_client,
            'email'=>$request->email,
            // 'prospection_id'=>$request->prospection_id,
            // 'prospection_name'=>$request->prospection_name,
            'localisation' =>$request->localisation,
            'created_user'=>Auth::user()->id,
            'entreprise_id'=> Auth::user()->entreprise_id,
            'adresse_ip'=>$request->ip(),
        ]);

        //$user->entreprises()->attach(Auth::user()->entreprise_id);

        DB::table('entreprise_user')->insert([
            'entreprise_id'=> Auth::user()->entreprise_id,
             'user_id'=> $user->id,
         ]);



        return response()->json([
            'user' => $user,
            'message'=>'operation realise avec sucess',
        ]);
    }


    public function addNewProspect(Request $request ){

          

        for($i=0;$i<$request->count;$i++)
        {
            DB::table('prospection_user')->insert(
                array(
                'prospection_id' => $request->prospection_id,
                'user_id' =>  $request->item[$i]['selectedProspectId'],
                'created_at'=>Carbon::now(),
                'updated_at'=>Carbon::now()
                ));

                //     $prospection = Prospection::findOrFail($request->prospection_id);
                // $prospection->prospects()->attach([
                //     'prospection_id' => $request->prospection_id,
                //    'user_id' =>  $request->item[$i]['selectedProspectId'],
                // ]);
        }


        // $user = User::where('entreprise_id',Auth::user()->entreprise_id);
            $newProspect = [];
        for ($i=0; $i <$request->count; $i++) { 
            $new = User::whereId($request->item[$i]['selectedProspectId'])->get();
            array_push($newProspect,  $new);
        }

        return response()->json([
            'newProspect'=>$newProspect,
            'Nouveau prospect ajouté avec success'
        ]);

    }


    public function updateProspect(Request $request)
    {
        $request->validate([
        'nom'=>'required',
        // 'prenoms'=>'required',
        'indicateur'=>'required',
        'contact'=>'required',
        // 'email'=>'required',

        ]);

        User::find($request->id)->update([
            'nom'=>$request->nom,
            'prenoms'=>$request->prenoms,
            'indicateur'=>$request->indicateur,
            'contact'=>$request->contact,
            'status_user'=>'prospect',
            'type_client'=>$request->type_client,
            'email'=>$request->email,
            'prospection_id'=>$request->prospection_id,
            'prospection_name'=>$request->prospection_name,
            'localisation' =>$request->localisation,
            'created_user'=>Auth::user()->id,
            'entreprise_id'=> Auth::user()->entreprise_id,
            'adresse_ip'=>$request->ip(),
        ]);

        return response()->json([
            'message'=>'modification effection avec sucess',
        ]);

    }

    public function deleteProspect(Request $request)
    {
        User::find($request->id)->delete();
        return response()->json([
            'message'=>'supprime avec sucess',
        ]);
    }




}
