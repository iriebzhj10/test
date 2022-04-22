<?php

namespace App\Http\Controllers;

use App\Mail\RelanceMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Facture;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Echeancier;
use Inertia\inertia;
use Carbon\Carbon;
use Illuminate\Http\Response;


class EcheancierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $currentDateTime = Carbon::now();

        //STATUS=======>DONE
        $auth = Auth::user()->entreprise_id;
        $facture = Facture::where('entreprise_id',$auth )->get();
        $echeancier = Facture::with('echeancier')->get();



        return response()->json([
            'facture' =>  $facture ,
            'facture_edit' =>  $facture ,
            'echeancier' =>  $echeancier ,
            'echeancier_edit' =>  $echeancier ,

            'message' => 'Collecter avec success',
        ]);







        // $newDateTime = Carbon::now()->addDays(7);
        //dd($currentDateTime);
        //dd($newDateTime);
        //  $facture=Echeancier::where('status', 0 )
        //  ->where('date_echeance', $currentDateTime )->get();
        //  dd($facture);

        // $auth = Auth::user()->entreprise_id;
        // $entreprise_user= Entreprise::where('id',$auth)->first();
        // dd($entreprise_user);

        //  $users = User::where('id',4)->get();
        //  $clients = User::where('created_user',auth()->user()->id)->get();
        //  dd($clients[0]->email);














        //$echeancier = Echeancier::where('facture_id',$facture );
        //dd( $echeancier);


        // return Inertia::render('Comptes/echeancier/echeancier_home')-> with( ['echeancier' => $echeancier ,'echeancier_edit' => $echeancier ,]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $currentDateTime = Carbon::now();

        //STATUS=======>DONE
        $auth = Auth::user()->entreprise_id;
        $facture = Facture::where('entreprise_id',$auth )->get();
        $echeancier = Facture::with('echeancier')->get();



        return response()->json([
            'facture' =>  $facture ,
            'facture_edit' =>  $facture ,
            'echeancier' =>  $echeancier ,
            'echeancier_edit' =>  $echeancier ,

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
        //STATUS=======>DONE
        $request->validate([
            'libelle'=>['required'],
            'description'=>['required'],
            'date_echeance'=>['required'],
            'montant'=>['required','numeric'],
        ]);


        //$auth = Auth::user()->entreprise_id;//entreprise_id
        //$agence = Agence::where('entreprise_id',$auth ); //agence_id
   
            for($i=0; $i<count($request->montant); $i++)
            {

                    if($request->montant > 0){
                        $echeancier = Echeancier::Create([
                        'libelle'=>$request->libelle[$i],
                        'description'=>$request->description[$i],
                        'montant'=>$request->montant[$i],
                        'date_echeance'=>$request->date_echeance[$i],
                        'facture_id'=>$request->facture_id[$i],
                        'status'=> 0 ,  // non reglé
                    ]);
                 }
                else{ $echeancier = Echeancier::Create([
                        'libelle'=>$request->libelle[$i],
                        'description'=>$request->description[$i],
                        'montant'=>$request->montant[$i],
                        'date_echeance'=>$request->date_echeance[$i],
                        'facture_id'=>$request->facture_id[$i],
                        'status'=> 1 , // reglé
                     ]);
                 }

                return response()->json([
                        'message' => 'Enregistreé avec success',
                    ]);

                    // return back()-> with( 'message' , 'Facture enregistré avec success' );

            }

 
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
        $echeance_edit =  Echeancier::find($id);
        return response()->json([
            'message' => 'collecté avec success',
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
        //DONE
       // dd($request->all());
       $request->validate([
        'libelle'=>['required'],
        'description'=>['required'],
        'date_echeance'=>['required'],
        'montant'=>['required','numeric'],
          ]);

        $auth = Auth::User()->Entreprise_id;
        $finds =Echeancier::find($id);

        if($finds->montant < $request->montant )
           { Echeancier::find($request->id)->update([
                'libelle'=>$request->libelle,
                'description'=>$request->description,
                'montant'=>$request->montant,
                'date_echeance'=>$request->date_echeance,
                ' status'=> 1 ,
                //'facture_id'=>$request->date,
            ]);
        }else
            {Echeancier::find($request->id)->update([
                'libelle'=>$request->libelle,
                'description'=>$request->description,
                'montant'=>$request->montant,
                'date_echeance'=>$request->date_echeance,
                ' status'=> 0 ,
                //'facture_id'=>$request->date,
            ]);

            }

            return response()->json([
                'message' => 'Modifié avec success',
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
        //STATUS ===== DONE
        $facture=Echeancier::find($id)->delete();

        return response()->json([
            'message' => 'echeancier a été supprimé avec success',
        ]);

        // return back()-> with( 'message' , 'echeancier a été supprimé avec success' );
    }







      /**
     * envoie auto the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function checkenvoi()
    {
        //STATUS ===== DONE
        $currentDateTime = Carbon::now();
        $newDateTime = Carbon::now()->addDays(7);


        $facture=Echeancier::where('status', 0 )
        //->where('date_echeance', $newDateTime )
        ->whereBetween('date_echeance',[$currentDateTime,$newDateTime]);

        //dd($facture);
        //dd($newDateTime);

        if($facture)
        {
            return response()->json([
                'facture' => $facture ,
                'message' => 'echeancier a été collecté avec success',
            ]);

            // return Inertia::render('Comptes/echeancier/echeancier_home')-> with( ['facture' => $facture ,'facture' => $facture ,]);

        }else{
            return response()->json([
                'message' => "Vous n'avez pas d'arrieré",
            ]);
            // return Inertia::render('Comptes/echeancier/echeancier_home')-> with( 'message' ,"Vous n'avez pas d'arrieré");
        }



    }





    public function envoiauto(Request $request,$id )
    {
        //
        $facture=Echeancier::find($id);

       //jour j et jour j-7
       $currentDateTime = Carbon::now();
       //$facture = Carbon::now()->addDays(7);

       //Information de l'entreprise connecté
       $auth = Auth::user()->entreprise_id;
       $entreprise_user= Entreprise::where('id',$auth)->first();

       //Liste des clients de l'utilisateur connecté
       $users = User::where('id',4)->get();
       $clients = User::where('created_user',auth()->user()->id)->get();
       //dd($clients[]->email);

       if($facture)
       {
           for($i=0;$i<count($clients);$i++)
           {
               Mail::to($clients[$i]->email)->send(new RelanceMail($clients));
           }
       }

       return response()->json([
        'message' => "echeancier a été envoyé avec success",
    ]);


        // $facture=Echeancier::find($id);
        // //Information de l'entreprise connecté
        // $auth = Auth::user()->entreprise_id;
        // $entreprise_user= Entreprise::where('id',$auth)->first();
        // //Liste des clients de l'utilisateur connecté
        // $users = User::where('id',4)->get();
        // $clients = User::where('created_user',auth()->user()->id)->get();

        // //dd($entreprise_user->email);

        // if($facture)
        // {
        //     for($i=0;$i<count($clients->id);$i++)
        //     {
        //         Mail::to($clients->email)->send(new RelanceMail($clients));
        //     }
        // }



        // return back()-> with( 'message' , 'echeancier a été supprimé avec success' );
    }



      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {


        Echeancier::find($id)->update([ ' status'=> 1 , ]);

        return response()->json([
            ' status'=> $id ,
            'message' =>  'echeancier a deja été respecté'
        ]);

         //
       // $finds =Echeancier::find($id)->update([  ' status'=> 1 , ]);
        // return back()-> with( 'message' , 'echeancier a deja été respecté' );
    }
}






// public function store(Request $request)
// {
//     //STATUS=======>DONE
//     $request->validate([
//         'libelle'=>['required'],
//         'description'=>['required'],
//         'date_echeance'=>['required'],
//         'montant'=>['required','numeric'],
//     ]);


//     //$auth = Auth::user()->entreprise_id;//entreprise_id
//     //$agence = Agence::where('entreprise_id',$auth ); //agence_id

//         for($i=0; $i<count($request->montant); $i++)
//         {

//                 if($request->montant > 0){
//                     $echeancier = Echeancier::Create([
//                     'libelle'=>$request->libelle,
//                     'description'=>$request->description,
//                     'montant'=>$request->montant,
//                     'date_echeance'=>$request->date_echeance,
//                     'facture_id'=>$request->facture_id,
//                     'status'=> 0 ,  // non reglé
//                 ]);
//              }
//             else{ $echeancier = Echeancier::Create([
//                     'libelle'=>$request->libelle,
//                     'description'=>$request->description,
//                     'montant'=>$request->montant,
//                     'date_echeance'=>$request->date_echeance,
//                     'facture_id'=>$request->facture_id,
//                     'status'=> 1 , // reglé
//                  ]);
//              }

//             return response()->json([
//                     'message' => 'Enregistreé avec success',
//                 ]);

//                 // return back()-> with( 'message' , 'Facture enregistré avec success' );

//         }


// }