<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dompdf\Renderer;
use Inertia\Inertia;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Facade\FlareClient\Http\Client;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str;

class ClientController extends Controller
{

    // public function __construct(){
    //     $this->middleware('auth');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

                //
        // $user_id=Auth::user()->id;
        // $clients=User::Where("created_user",$user_id)->get();
        $clients = User::where('entreprise_id',Auth::user()->entreprise_id)
        ->where('status_user','client')
        ->where('delete_update_at',0)
        ->get();

        return response()->json([
            $clients ,
            'Collecter avec success',
        ],200 );
        // return Inertia::render('CRM/Clients/client')->with([
        //     'clients'=>$clients,
        //     'clients_edit'=>$clients
        // ]);

    }

    public function customer_filter(Request $request){
        
        $urlWithQueryString = $request->fullUrl();

        $client = Str::contains($urlWithQueryString, 'acheteur');
        $prospect = Str::contains($urlWithQueryString, 'prospect');

      
        
        if($client == true){

            $acheteur =   User::where('entreprise_id',Auth::user()->entreprise_id)
            ->where('status_user','client')
            ->where('delete_update_at',0)
            ->get();

            return response()->json([ 
                 'acheteur'=>$acheteur,
                 'message'=>'clients'
                    //  'client_url'=>$request->fullUrlWithQuery(array_merge($request->all(),['type'=>'acheteur']))  ,
                    //  'client'=>     $urlWithQueryString,
                    //  '$client'=>$client,
                 
                 ] );
        }elseif($prospect == true){
            $acheteur =   User::where('entreprise_id',Auth::user()->entreprise_id)
            ->where('status_user','prospect')
            ->where('delete_update_at',0)
            ->get();

            return response()->json([ 
                'acheteur'=>$acheteur,
                'message'=>'prospects'
            ] );
        }else{
            $acheteur =   User::where('entreprise_id',Auth::user()->entreprise_id)
            ->whereIn('status_user',['prospect', 'client'])
            ->where('delete_update_at',0)
            ->get();

            return response()->json([ 
                'acheteur'=>$acheteur,
                'message'=>'fussion des deux'
            ] );
        }
    }



    public function ajoutDeCommentaire(Request $request)
    {
       $request->validate([
           'id'=> 'required',
           'commentaire'=> 'required',
       ]);

       // $facture = User::find($request->id);

             $sol = Commentaire::create([
                'id' =>  $request->id,
                'commentaire' =>  $request->commentaire,
               // 'facture_id' => $request->id,
               // 'employee_id' => $request->employee_id,
                'client_id' => $request->client_id,
                'created_user' => Auth::user()->id,
                'entreprise_id' => Auth::user()->entreprise_id,
             ]);

             /**************************************************/


        return response()->json([
            'commentaire'=>$sol,
            'message'=>'Enregistrement effectu2 avec success'
         ,
        ]);


    }



     //Ajouter commentaire sur la facture
     public function CollectDeCommentaireClient(Request $request)
     {

       // $web = Commentaire::find($request->id);

         $comment =  DB::table('commentaires')
         ->where('entreprise_id',Auth::user()->entreprise_id)
         ->where('client_id',$request->client_id)
         ->get();




         return response()->json([
            'commentaire'=>$comment,
         ]);




     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        // $clients = User::where('created_user',Auth::user()->id)->get();
        return Inertia::render('CRM/Clients/client_form');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            // 'email' => 'required|unique:users',
            'contact' =>'required',
            'indicateur' =>'required',
        //    'localiation' =>'required',
            'type_client' =>'required',
        ]);

        $client=User::create([

            'nom'=>$request->nom,
            'prenoms'=>$request->prenoms,
            'email'=>$request->email,
            'indicateur'=>$request->indicateur,
            'numero_fixe'=>$request->numero_fixe,
            'contact'=>$request->contact,
            'localisation' =>$request->localisation,
            'status_user'=>'client',
            'type_client'=>$request->type_client,
            'created_user'=>$request->user()->id,
            'entreprise_id'=> Auth::user()->entreprise_id,
            'adresse_ip'=>$request->ip(),


        ]);

        DB::table('entreprise_user')->insert([
            'entreprise_id'=> Auth::user()->entreprise_id,
             'user_id'=> $client->id,
         ]);




     // return back()->with( 'message' , 'Client enregistré avec success' );


      $response=[
        'client'=>$client,
        'message'=>'enregistrer avec sucess',
         ];

          return response($response,201);

    }


    public function client_facture(){

        $client= Client::all();
        if ($request('client')) {
           $client_facture = Client::where('id',request('client'))->get();
        }

        $response=[
            'clients_facture'=>$clients_facture,
            'message'=>'collecté avec succes',
        ];

        return response($response,201);

        //dd( $client_facture);
        // return Inertia::render('Factures/facture/facture_add',[

        //     'clients_facture'=> $clients_facture,

        //  ]);

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
        //Fonction pour modifier utilisateur
        $clients  = User::find($id);

        $response=[
            $clients,
            'collecté avec succes',
        ];

        return response($response,201);


        // dd($clients);
        // return Inertia::render('CRM/Clients/client_form')->with('clients',$clients);

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
        $request->validate([
            'nom' => 'required',
            // 'prenoms'=>'',
            'contact' =>'required',
            'indicateur' =>'required',
            'localisation' =>'required',
            'type_client' =>'required',
        ]);
        $client_update=User::find($request->id)->update($request->all());

        $response=[
            'client_update'=>$client_update,
            'message'=>'modifié avec succes',
        ];

        return response($response,201);



        // dd($request->all());
        // return back()->with('message','Modifier');
    }




    // public function update(Request $request)
    // {

    //     $request->validate([
    //         'nom' => 'required',
    //         'prenoms'=>'required',
    //         'contact' =>'required',
    //         'indicateur' =>'required',
    //         'localisation' =>'required',
    //         'type_client' =>'required',
    //     ]);

    //     Entreprise::find($request->id)->update([
    //         'nom' => $request->nom,
    //         'prenoms' => $request->prenoms,
    //         'contact' => $request->contact,
    //         'indicateur' => $request->indicateur,
    //         'localisation' => $request->localisation,
    //         'email' => $request->email,
    //         'type_cient' => $request->type_cient,

    //         // 'description' => $data['description'],
    //     ]);


    //     $response=[
    //         'message'=>'Modifié avec succes',
    //     ];

    //     return response($response,201);
    // }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $client=User::find($request->id)->get();
                if ($client) {
                    $client_up = User::whereId($request->id)->update(['delete_update_at'=>1]);
                }
        $response=[
            'message'=>'supprimé avec succes',
        ];

        return response($response,201);

        //return back()-> with( 'message' , 'Client supprimé avec success' );

    }


    public function historique(Request $request)
    {
        //
        $client_historique =  DB::table('activity_log')
            ->where('subject_id',$request->subject_id)
            ->where('subject_type','=',  'App\Models\User')
            //
            ->orderBy('id','desc')
            ->take(20)
            ->get();

        $response=[
            'historique' => $client_historique,
            'message'=>'supprimé avec succes',
        ];

        return response($response,201);

        //return back()-> with( 'message' , 'Client supprimé avec success' );

    }



}
