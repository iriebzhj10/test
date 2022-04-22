<?php

namespace App\Http\Controllers;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use App\Models\Taxe;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Article;
use App\Models\Parametre;
use App\Models\Facture;
use App\Models\Commentaire;
use App\Models\Versement;
use App\Mail\FactureMail;
use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade as PDF;
// use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
//use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Arr;




class FactureController extends Controller
{
        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
         */

    function __construct()
    {
        //  $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        // //  $this->middleware('permission:product-create', ['only' => ['create','store']]);
        //  $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        //    $this->middleware('permission:edit-facture', ['only' => ['update']]);
        //    $this->middleware('permission:index-facture', ['only' => ['index']]);
        //    $this->middleware('permission:create-facture', ['only' => ['store']]);
        //    $this->middleware('permission:delete-facture', ['only' => ['destroy']]);



           //$this->middleware('role:employee', ['only' => ['store']]);nn
    }



    public function index()
    {
        //    $activity = DB::table('activity_log')->where('description','like','%Emprunt%')
        //    ->where('entreprise_id',Auth::user()->entreprise_id)
        //    ->get();

        //    return response()->json([
        //     $activity
        //    ]);
       // $activity = Facture::all();

        $brouillon = Facture::whereEtat('Brouillon')->get();
        $termine = Facture::whereEtat('Termine')->get();
        $Valide = Facture::whereEtat('Valide')->get();

        $entreprise_id=Auth::user()->entreprise_id;

        $facture = Facture::with([
            'client',
            'articles' ,
            'versements',
            'taxes',
            'entreprise',
            'media'
        ])
        ->where('entreprise_id',$entreprise_id)->get();

        $liste_versement = Facture::with([
            'versements',
        ])
        ->where('entreprise_id',$entreprise_id)->get();
      //  ->whereBetween('created_at',[$dateSsem,$dateEsem])//




        // $entreprise= Entreprise::where('id',$entreprise_id)->first();

        // $facture = Facture::where('entreprise_id',$entreprise_id)->get();
        $vendeur = User::where('id',Auth::user()->entreprise_id)->first();
        // $client = User::where('id',$facture->user_id)->first();
        $pivot_article = DB::table('article_facture')->get();

        //relance
        $date2sem = Carbon::now()->addDays(30)->isoFormat('YYYY-MM-DD');
        $date1sem = Carbon::now()->addDays(1)->isoFormat('YYYY-MM-DD');
        $date1jr = Carbon::now()->addDays(1)->isoFormat('YYYY-MM-DD');

        // listes des factures a relancer
        $relance = DB::table('factures')
        //->join('versements', 'factures.id', '=', 'versements.facture_id')
        // ->join('echeanciers', 'echeanciers.facture_id', '=', 'factures.id')
        ->join('users', 'users.id', '=', 'factures.client_id')
        ->where('factures.entreprise_id',Auth::user()->entreprise_id)
        ->where('factures.state','apayer')

        //->orWhere('factures.state','partiel')

        ->select('factures.id as facture_id','factures.code','factures.total_ttc','factures.total_ht','factures.total_ht','factures.date_echeance','factures.description','users.id as user_id','users.nom','users.prenoms','users.email',)//'users.*'
        ->whereBetween('factures.date_echeance', [$date1sem,$date2sem])
       // ->orderBy('factures.date_echeance', 'asc')
        ->get();


        $versements = DB::table('factures')
        ->join('versements', 'factures.id', '=', 'versements.facture_id')
        // ->join('echeanciers', 'echeanciers.facture_id', '=', 'factures.id')
        ->join('users', 'users.id', '=', 'factures.client_id')
        ->where('factures.entreprise_id',Auth::user()->entreprise_id)
        ->where('factures.state','<>','solde') // apayer , solde , impayer
        //->where('factures.code',$request->code_facture)
        //->orWhere('factures.state','partiel')
        ->select('factures.code','versements.facture_id','factures.total_ttc','factures.total_ht','factures.total_ht','factures.date_echeance','factures.description','versements.montant','users.id','users.nom','users.prenoms','users.email',)//'users.*'  'versements.*',
        ->whereBetween('factures.date_echeance', [$date1sem,$date2sem]) //'factures.*','versements.*',
        // ->orderBy('factures.date_echeance', 'asc')
        ->get();











          if(isset($relance) ) //isset($versements) &&
          {

            for($i=0;$i<count($relance);$i++)
            {
                $total_versement[$i] = 0;
                $relance_sub = [];
               // return response()->json([ 'versement'=>$versements, 'relancwe' =>$relance ]);
                for($j=0;$j<count($versements);$j++ ){
                    //return response()->json([ $versements[$j]->facture_id, $relance[$i]->facture_id ]);
                        if($relance[$i]->facture_id == $versements[$j]->facture_id )
                        {
                            $total_versement[$i] = $total_versement[$i] + $versements[$j]->montant;
                        }
                }

            }


            for($i=0;$i<count($relance);$i++){
                if( isset($versements[$i]->total_ttc) > isset($total_versement))
                {
                    $diff_montant[$i] =  $relance[$i]->total_ttc - $total_versement[$i];
                    $relance1[$i] = Arr::add(['relance'=>$relance[$i]], 'montant', $diff_montant[$i]);
                }
                else{
                    $diff_montant[$i] =  $relance[$i]->total_ttc - $total_versement[$i];
                    $relance1[$i] = Arr::add(['relance'=>$relance[$i]], 'montant', $diff_montant[$i]);
                }
            }

            // return response()->json([
            //     'diff_montant'=>$diff_montant,
            //     'total_versement'=>$total_versement,
            //     'versements'=>$versements,
            //      ]);

                 //count($relance),
                //  'versement'=> $versements,
                //  'relance'=>$relance1,
                //  '$versement'=>$versements,

            // return response()->json([
            //     'count'=>count($relance1),
            //      $relance1,//['relance']->code
            //      'code'=>$relance1[0]['relance']->code,
            // ]);  if (isset($var))

                if(isset($relance1)){
                    $relance_value = [];
                    for($i=0;$i<count($relance1);$i++){
                        $j = [
                            'code'=>$relance1[$i]['relance']->code,
                            "total_ttc"=> $relance1[$i]['relance']->total_ttc,
                            "total_ht"=> $relance1[$i]['relance']->total_ht,
                            "date_echeance"=> $relance1[$i]['relance']->date_echeance,
                            "description"=> $relance1[$i]['relance']->description,
                            "id"=> $relance1[$i]['relance']->facture_id,
                            "nom"=> $relance1[$i]['relance']->nom,
                            "prenoms"=> $relance1[$i]['relance']->prenoms,
                            "email"=> $relance1[$i]['relance']->email,
                            'montant_restant'=>$diff_montant[$i]
                        ];
                        array_push($relance_value,$j);
                    }

                //      return response()->json([

                //     'relance1'=>$relance1,
                //     'relance'=> $relance_value,

                // ]);




                        activity()
                            //->performedOn($web)
                        ->log('Index-Facture')
                        // ->causedBy(Auth::user()->id)
                        ->subject(2)
                        ->withProperties(['test' => 'value']);


                    return response()->json([
                        'brouillon'=> $brouillon,
                        'termine'=>$termine,
                        'Valide'=>$Valide,
                        'liste_versement'=>$liste_versement,
                        'total_versements'=>$versements,
                        // Auth::user()->entreprise_id,
                        // $facture,$pivot_article,$vendeur,
                        //'relance_q'=>$relance1,
                        'relance'=>$relance_value,
                        'relanceq1'=>$relance,
                        'relance_q'=>$relance1,

                        'facture'=>$facture,
                        'pivot_article'=>$pivot_article,
                        'vendeur'=>$vendeur,
                    ]);

                }







          }








        return response()->json([
            'brouillon'=> $brouillon,
            'termine'=>$termine,
            'Valide'=>$Valide,
            'liste_versement'=>$liste_versement,
            'total_versements'=>$versements,

            'relance'=>$relance,
            'facture'=>$facture,
            'pivot_article'=>$pivot_article,
            'vendeur'=>$vendeur,
            'message'=>"toutes les factures ont ete regle2",
        ],200);




    }

    //reglement dun facture specific pour Diomande
    public function reglementFacture(Request $request)
    {

        $versement_facture = Facture::with([
            'versements',
        ])
        ->where('id',$request->id)->get();

        $facture = Facture::find($request->id);
        activity()
        ->performedOn($facture)
        ->log('Facture-reglementFacture');


        return response()->json([
            $versement_facture,
        ]);


    }

    public function listFactureClient(Request $request)
    {
        $request->validate([
                'client_id'=> 'required',
                // 'facture_id'=> 'required',

        ]);

        $facture = User::find($request->client_id);

        $list_facture_client = Facture::with('versements')->
         where('client_id',$request->client_id)
        ->where('entreprise_id',Auth::user()->entreprise_id)
        ->where('status','facture')
        ->get();

        $list_devis_client = Facture::where('client_id',$request->client_id)
       ->where('entreprise_id',Auth::user()->entreprise_id)
       ->where('status','devis')
       ->get();

        activity()
        ->performedOn($facture)
        ->log('Facture-listFactureClient');



        return response()->json([
            Auth::user()->entreprise_id,
            'list_devis_client'=>$list_devis_client,
            'list_facture_client'=>$list_facture_client,
        ]);

    }

    //Ajouter des fichiers relatif a une facture
    public function ajoutDeFichier(Request $request)
    {
        $input = $request->all();
        // return response()->json([ 'input'=>$input  ,  'id' => Auth::user()->entreprise_id ]);

        $facture = Facture::find($request->id);

   
            if($request->has('avatar'))
            {

                //version 2
               $fact = $facture->addMedia($request->file('avatar'))
                            ->withManipulations( ['commentaire' => ['message' => $request->message ] ] )  
                            ->toMediaCollection('avatar');        
                            
             }

             $sol = Commentaire::create([
                'facture_id' =>  $request->id,
                'libelle' =>  'fichier',
                'commentaire' =>  $request->commentaire,
                'facture_id' => $request->id,
               // 'employee_id' => $request->employee_id,
               // 'client_id' => $request->client_id,
                'created_user' => Auth::user()->id,
                'entreprise_id' => Auth::user()->entreprise_id,
             ]);




             //details de l'enregistrement

             $facture_stored = Facture::with( ['commentaires' ] )
                                   //->where('libelle','fichier')
                                   ->where('id',$request->id)->with('media')->get(); //with('commentaires')->




           // $jojo = Facture::find(66)->getFirstMedia();


                activity()
                ->performedOn($facture)
                ->log('Facture-ajoutDeFichier');



        return response()->json([
            //isset($request->image),
           // 'media'=>$jojo ,
           // ' $sol'=>$sol,
            //'commentaire'=>$request->commentaire,
            //'facture'=>$facture,
            'facture_stored' => $facture_stored ,
        ]);


    }


    
     //Ajouter commentaire sur la facture
     public function ajoutDeCommentaire(Request $request)
     {
        $request->validate([
            'id'=> 'required',
            'commentaire'=> 'required',
        ]);

         $facture = Facture::find($request->id);

              $sol = Commentaire::create([
                 'facture_id' =>  $request->id,
                 'libelle' =>  'commentaire',
                 'commentaire' =>  $request->commentaire,
                // 'facture_id' => $request->id,
                // 'employee_id' => $request->employee_id,
                // 'client_id' => $request->client_id,
                 'created_user' => Auth::user()->id,
                 'entreprise_id' => Auth::user()->entreprise_id,
              ]);



              /**************************************************/


              if( isset($sol)){
                       $user = User::where('id',$sol->created_user)->with('roles')->first();
              }

            //   return response()->json([
            //     $sol->created_user,
            //     $user->id
            // ]);

            $id = $sol->id;
            $comment = $sol->commentaire;



              $historique = [];
              $sol = [];

               $sol1 = [
                 "user_id"=> $user->id,
                // "subject_type"=> "Facture",
                 "user_nom"=> $user->nom,
                 "user_prenoms"=> $user->prenoms,
                 "user_contact"=> $user->contact,

                 "comment_id"=>   $id  ,
                 "commentaire"=>   $comment  ,
                 "user_role"=> $user->roles,
                 "photo_user"=>$user->profile_photo_url
               ];

            //  }


          //  }
           array_push($historique,$sol1);


              /**************************************************/






                 activity()
                  ->performedOn($facture)
                ->log('Facture-ajoutDecommentaire');




         return response()->json([
             //isset($request->image),
            // 'media'=>$jojo ,
             'commentaire'=>$sol1,
             'message'=>'Enregistrement effectu2 avec success',
             //'commentaire'=>$request->commentaire,
             //'commentairessssss'=>$request->historique,
             //'facture'=>$sol,
         ]);


     }


     //update commentaire sur la facture
     public function updateDeCommentaire(Request $request)
     {
        $request->validate([
           // 'facture_id'=> 'required',
            'id'=> 'required',
        ]);

        $comment = Commentaire::find($request->id);


            $sol = DB::table('commentaires')->whereId($request->id)
            ->update([
                 'commentaire' =>  $request->commentaire,
                 'employee_id' => $request->employee_id,
                 'client_id' => $request->client_id,
                 'created_user' => Auth::user()->id,
                 'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            if($sol)
            {
                return response()->json([
                    //isset($request->image),
                   // 'media'=>$jojo ,
                   // ' $sol'=>$sol,
                    'commentaire'=>$request->commentaire,
                    'facture'=>$sol,
                ]);
            }else{
                return response()->json([
                    'error'=>'Pas de commentaire disponible',
                ]);
            }



             activity()
                 ->performedOn($comment)
             ->log('Facture-ajoutDeFichier');

        //     activity()
        //     //->performedOn($web)
        //    ->log('Facture-ajoutDeFichier')
        //    ->causedBy(Auth::user()->id)
        //    ->subject(2)
        //    ->withProperties(['test' => 'value']);



         return response()->json([
             //isset($request->image),
            // 'media'=>$jojo ,
            // ' $sol'=>$sol,
             'commentaire'=>$request->commentaire,
             'facture'=>$sol,
         ]);


     }


       //Delete commentaire sur la facture
    public function deleteDeCommentaire(Request $request)
    {
        $request->validate([
            // 'facture_id'=> 'required',
            'id'=> 'required',
        ]);

        $comment = Commentaire::find($request->id);


            $sol = DB::table('commentaires')->whereId($request->id)->delete();
            //->whereFacture_id($request->id)



                   activity()
                   ->performedOn($comment)
               ->log('Facture-ajoutDeFichier');




        return response()->json([
            //isset($request->image),
            // 'media'=>$jojo ,
            // ' $sol'=>$sol,
            //deleteDeCommentaire
            //      'facture'=>$sol,
            'commentaire'=>$request->commentaire,
            'message'=> 'commentaire a ete supprim2 avec success',
        ]);


    }




     //Ajouter commentaire sur la facture
     public function collectDeCommentaire(Request $request)
     {
         $request->validate([ 
            'facture_id' => 'required',
         ]);

        $web = Facture::find($request->facture_id);

         $comment =  DB::table('commentaires')
         ->where('entreprise_id',Auth::user()->entreprise_id)
         ->where('libelle','commentaire')
         ->where('facture_id',$request->facture_id)
         ->get();

         if( isset($comment)){
            for($i=0;$i<count($comment);$i++){
                  $user[$i] = User::where('id',$comment[$i]->created_user)->with('roles')->first();
            }
         }


        //  for($i=0;count($comment);$i++){
        //      if($comment->id == $user->id){
        //          $collectcomment[$i] = ;
        //      }
        //  }

         $historique = [];
            $sol = [];

          for($i=0;$i<count($comment);$i++){
            if($comment[$i]->created_user == $user[$i]->id){


             $sol[$i] = [
               "user_id"=> $user[$i]->id,
              // "subject_type"=> "Facture",
               "user_nom"=> $user[$i]->nom,
               "user_prenoms"=> $user[$i]->prenoms,
               "user_contact"=> $user[$i]->contact,


               "comment_id"=>   $comment[$i]->id  ,
               "commentaire"=>   $comment[$i]->commentaire  ,
               "user_role"=> $user[$i]->roles,
               "photo_user"=>$user[$i]->profile_photo_url
             ];



            }


          }
         array_push($historique,$sol);



          activity()
                ->performedOn($web)
                 ->log('Facture-collectDeCommentaire');

              






         return response()->json([
           // 'jojo'=>$jojo,
            'commentaire'=>$historique,
             'comment' => $comment,
            // 'user' =>$user,
         ]);












         return response()->json([
             //isset($request->image),
            // 'media'=>$jojo ,
            // ' $sol'=>$sol,
            'commentaires'=>$historique,
            'user'=>$user,
            'commentaire'=>$request->commentaire,
            // 'comment'=>$comment,
         ]);


     }

         //Ajouter des fichiers relatif a une facture
        public function deleteDeFichier(Request $request)
        {
            $request->validate([
                'image_id' => 'required',
            // 'facture_id' => 'required'
            ]);

            //$image = Facture::find($request->image_id);

                $imagedelete =Media::find($request->image_id);
                //return response()->json([ $image ]);

            $image = DB::table('media')->where('id',$request->image_id)->delete();

            activity()
                ->performedOn($imagedelete)
                    ->log('Facture-deleteDeFichier');


            if(isset($image)){
                return response()->json([ 'message'=>'supprimer avec succes',$image]);
            }else{
                return response()->json([ 'message'=>"ce fichier n'existe pas",$image]);
            }




            // $jojo = $image->clearMediaCollection();



            //  return response()->json([
            //      //isset($request->image),
            //     // 'media'=>$jojo ,
            //   // $jojo,
            //      ' $image'=>$image,
            //      'commentaire'=>$request->commentaire,
            //    //  'facture'=>$facture,
            //  ]);


        }




      //Ajouter des fichiers relatif a une facture
      public function updateDeFichier(Request $request)
      {
            $request->validate([
                'image_id' => 'required',
            // 'facture_id' => 'required'
            ]);

         // $image = Media::find($request->image_id);

         $image = DB::table('media')->whereId($request->image_id)->first();

         $web=Facture::find($request->id);

         //$web=Facture::where('id',$request->id)->with('media')->get();

          if ($image) {

            if ($request->has('avatar')) {
                $image->clearMediaCollection('images');
                $image->addMediaFromRequest('image')->toMediaCollection('images');

                return response()->json([
                    'operation effectue avec success'
                ]);


            }
        }

        activity()
                ->performedOn($web)
                 ->log('Facture-updateDeFichier');

          return response()->json([
              //isset($request->image),
             // 'media'=>$jojo ,
              ' $image'=>$image,


              'commentaire'=>$request->commentaire,
            //  'facture'=>$facture,
          ]);


      }


      //collect des fichiers relatif a une facture
      public function collectDeFichier(Request $request)
      {
        $request->validate([ 
            'id' => 'required',
         ]);

         // $input = $request->all();

          $Images =Facture::find($request->id);

          $facture = Facture::with( ['commentaires' ] )
                                //->where('libelle','fichier')
                                ->where('id',$request->id)->with('media')->get(); //with('commentaires')->

                //   $test = DB::table('factures')
                //   ->join('factures', 'factures.id', '=', 'commentaires.facture_id')
                //   ->where('entreprises.id',Auth::user()->entreprise_id)
                //   ->where('factures.id',$request->id)
                //   ->select('factures.*','commentaires.*')
                //   ->first();


                //  $jojo1 = $facture->getMedia('images')->first()->getUrl('thumb');
                // $jojo1 = Facture::whereId($request->id)->with('media');

                activity()
                ->performedOn($Images)
                 ->log('Facture-collectDeFichier');





          return response()->json([
              'facture'=>$facture,
              'message'=>'realise avec sucess' ,
          ]);


      }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $users = User::where('id',4)->get();
        $clients = User::where('created_user',auth()->user()->id)->get();
        $articles = Article::where('created_user',auth()->user()->id)->get();
        $taxes = Taxe::where('created_user',auth()->user()->id)->get();
        $entreprise_id=Auth::user()->entreprise_id;
        $entreprise= Entreprise::where('id',$entreprise_id)->get();

         return response()->json([
            $users,
            $entreprise,
            $clients,
            $taxes,
            $articles,
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

       // return response()->json([ $request->all() ]);


        // $request->validate([
        //     'date_echeance' => ['required'],
        //     'date_emission' => ['required'],
        //      'client' => ['required'],
        //      'total_ttc' => ['required'],
        //     //  'entreprise_id'=> ['required'],
        //      'prix'=> ['required'],
        //       'quantite'=> ['required'],
        // ]);


        $entreprise_id = Auth::user()->entreprise_id;
        $last_id = Facture::where('entreprise_id',Auth::user()->entreprise_id)->count();
         //$last_id1 =  DB::statement('SELECT count(id) FROM `factures` WHERE 1');
         //DB::table('factures')->select('SELECT count(id) FROM `factures` WHERE 1');  //('id',Auth::user()->entreprise_id)->count();

        $code_facture = IdGenerator::generate([
            'table' => 'factures',
            'field' => 'code',
            'length' => 8,
            'prefix' => 'Fact',
            'suffix' => $last_id+1,
            'reset_on_prefix_change' => true,

        ]);

        // $client = User::where('created_user',auth()->user()->id)->get();
        $client = User::where('id',$request->client)->first();

        //  for($i=0;$i< $request->nombre_article ;$i++ )
        //  {
            $facture = Facture::create([
                'libelle'=>$request->libelle,
                'date_echeance'=>$request->date_echeance,
                'date_emission'=>$request->date_emission,

                'client_id'=>$client->id,

                'description'=>$request->description,

                'remise'=>$request->remise,
                'total_ht'=>$request->total_ht,
                'total_taxe'=>$request->total_taxe,
                'total_ttc'=>$request->total_ttc,

                //'type_facture_id'=>0, //0=modifiable facture ----1=pour non modifiable facture
                'status'=>$request->type_facture, //0=Devis , 1= FACTURE , bon de commande
                'state'=>  'apayer', //solde , apayer ,partial
                'etat'=> $request->etat,

                'entreprise_id'=>auth()->user()->entreprise_id,
                'user_id'=>auth()->user()->id,
                'created_user'=>$request->user()->id,
            ]);



            $vendeur = User::where('id',Auth::user()->id)->first()  ;


            $article = Article::where('entreprise_id',Auth::user()->entreprise_id)  ;
                                    //  ->where('libelle',$request->items)->get(); articles_id

            // $facture->articles->attach($request->articles_id);

             for($i=0;$i< $request->nombre_article ;$i++ )
            {
                $pivot = DB::table('article_facture')->insert(
                    array(
                        'facture_id' =>$facture->id,
                        'article_id'  => $request->articles_id[$i],  //id des articles
                        'prix'  =>$request->items[$i]['prix'],      // prix total ===> $request->items[$i]['prix']
                        'quantite'  =>$request->items[$i]['qte'],  // quantit2 totale =====> $request->items[$i]['qte']
                        'options'  =>$request->options,
                        'taxe_id'  =>$request->taxes_id,

                        'prix_vente'  =>$request->items[$i]['cout'],
                        'qte_un_article'  =>$request->items[$i]['qte'],
                        'prix_total'  =>$request->prix_total,  // quantit2 totale

                        'created_at'=> Carbon::now(),
                        'updated_at'=>Carbon::now(),
                    )
                );
            }

            for($i=0;$i< $request->nombre_article ;$i++ )
            {
                $pivot1 = DB::table('facture_taxe')->insert(
                    array(
                        'facture_id' =>$facture->id,
                        'taxe_id'  => $request->taxes_id,       //$facture->article_id[$i],
                        // 'prix'  =>$request->prix,
                        // 'quantite'  =>$request->qte,
                        'created_at'=> Carbon::now(),
                        'updated_at'=>Carbon::now(),
                    )
                );
            }

              $fact = Facture::where('id', $facture->id )->get();
              for($i=0;$i< $request->nombre_article ;$i++ ){
                // $art[$i] = Article::where('id', $request->articles_id[$i])->get();
              }



              //******************************************* */
              /*conversion des prospect en clients*/

              //update proster en client sous condition
              if($request->type_facture == 'facture')
              { //$client->id ==  $facture->user_id
                    User::find($facture->user_id)->update([
                    'status_user'=> 'client',
                ]);
              }
              /*END conversion des prospect en clients*/
              //******************************************* */

              //******************************************* */


              $facture_created = Facture::with([
                'client',
                'articles' ,
                'versements',
                'taxes',
                'entreprise',
                'media'
            ])
            ->where('id',$facture->id)
            ->where('entreprise_id',$entreprise_id)->get();

              activity()
              ->performedOn($facture)
             ->log('Store-Facture');
             // ->causedBy('Facture')
             //->subject(2)
             //->withProperties(['test' => 'value']);







               // dd($request->all());

                return response()->json([
                    $client,
                    'facture'=> $facture,
                    'req' =>  $request->all(),
                    'ici' => $request->articles_id,
                    // 'user'=>$user,

                    'articles'=> $request->items,

                    'factures' => $fact,
                    'facture_created'=>$facture_created,

                  //  'vendeur'=> $vendeur,
                  //  'code'=> $code_facture,
                  // 'last_id'=> $last_id,
                  //  'entreprise_id' => $entreprise_id ,
                    'client'=> $client,
                    'message'=>'facture enregistré avec success ohhhh'

                    // 'nombre_article'=> $request -> nombre_article,
                    // 'article' =>$article,
                     // 'articles' => $art,
                    // 'client' => $client_email,
                        // 'nombre'=>$request->nombre,
                    // 'length'=> $request->nombre_article,
                       // '$request->type_facture'=>$request->type_facture,
                   // '$facture->user_id'=>$facture->user_id,
                ],200);



                  //  }

        //$request->nombre_article
        // $nombre = $request->nombre_article;
        // $lengt = count($nombre);


         // $last = Facture::last();

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function items(Request $request)
    {

        $entreprise_id=Auth::user()->entreprise_id;
        $entreprise= Entreprise::where('id',$entreprise_id)->first();

        $last = DB::table('factures')->latest()->first();

        // $facture = Facture::where('entreprise_id',$last->id)->first();
        $client = User::where('id',Auth::user()->id)->first();
        // $article = Article::where('id',$request->articles_id)->get();

        // for($i=0;$i<$request->nombre_article;$i++)
        // {
            // $article[$i] = Article::where('id',$request->articles_id[$i])->get();
        // }

        $article =  DB::table('article_facture')->get();
        $taxes =  DB::table('facture_taxe')->get();


        // activity()
        // ->performedOn($article)
        //  ->log('Item-Facture');

       // ->causedBy('Facture')
        //    ->subject(2)
        //    ->withProperties(['test' => 'value']);



        // $facture = Facture::with([
        //             'client',
        //             'articles' ,
        //             'taxes',
        //             'entreprise'
        //         ])
        //         ->where('entreprise_id',$entreprise_id)->get();

        //$client = User::where('id',$facture[0]->user_id)->first();

            return response()->json([
                // 'facture'=>$last,
                'article'=> $article,
                'taxes'=>$taxes,
                // 'client'=>$client,
                //
                // 'user_id'=>$facture[0]->user_id,
            ],200);



        // $entreprise_id=Auth::user()->entreprise_id;
        // $entreprise= Entreprise::where('id',$entreprise_id)->first();

        // // $facture = Facture::where('entreprise_id',$entreprise_id)->get();

        //  $client = User::where('id',Auth::user()->entreprise_id)->first();

        // $facture = Facture::with([
        //     'client',
        //     'articles' ,
        //     'taxes',
        //     'entreprise'
        // ])
        // ->where('entreprise_id',$entreprise_id)->get();







        // $facture_show  = Facture::find($request->id);
        // return response()->json([
        //      'entreprise'=>$entreprise,
        //      'facture'=>$facture,
        //      'client'=>$client,
        //     //  'facture_show'=>$facture_show
        // ],200);

    }







    public function sumVersement(Request $request)
    {

        //

        $sunversement = Versement::where('entreprise_id',Auth::user()->entreprise_id)
                                    ->whereRaw("SUM(montant) as sum_total")->get();

            activity()
            ->performedOn($sunversement)
            ->log('sumVersement-Facture');
            // ->causedBy('Facture')
            // ->subject(2)
            // ->withProperties(['test' => 'value']);

    }




    public function preview($id)
    {
        //


        $facture_preview  = Facture::find($id);

        activity()
        ->performedOn($facture_preview)
       ->log('preview-Facture');
       // ->causedBy('Facture')
       //->subject(2)
       //->withProperties(['test' => 'value']);

        return response()->json([
             'facture_preview'=>$facture_preview
        ],200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        //
        $details_facture =Facture::where('id',$request->id)->first(); // details de la facture a modifier

        $list_articles = DB::table('article_facture')->where('facture_id',$details_facture->id)->get(); // liste des articles du pivot

        $detail_articles= DB::table('article_facture')->select('article_id')->where('facture_id',$details_facture->id)->get(); // liste des articles du pivot
            for ($i=0; $i <  count($detail_articles); $i++) {
                $detail = $detail_articles[$i]->article_id;
                     $detail_article[$i] = Article::where('id','=',  $detail )->get();
                }

        $list_taxes = DB::table('facture_taxe')->where('facture_id',$details_facture->id)->get(); // liste des taxes du pivot
        $detail_taxe= DB::table('facture_taxe')->select('taxe_id')->where('facture_id',$details_facture->id)->get(); // liste des articles du pivot
        for ($i=0; $i <  count($detail_taxe); $i++) {
            $details = $detail_taxe[$i]->taxe_id;
                $detail_taxe[$i] = Taxe::where('id','=',  $details )->get();
            }


            $client_id= DB::table('factures')->select('client_id')->where('id',$details_facture->id)->get(); // liste des articles du pivot

               $client = User::where('id',$client_id[0]->client_id)->first();

        activity()
        ->performedOn($details_facture)
       ->log('edit-Facture');
       // ->causedBy('Facture')
       //    ->subject(2)
       //    ->withProperties(['test' => 'value']);

        return response()->json([
           $client,
            $details_facture,
            'liste_article'=>$list_articles,
            // 'liste_taxe'=>$list_taxes,
            $detail_article,
           $detail_taxe,

        ],200);


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


        // vqlidqtin
        $request->validate([
            'date_echeance' => ['required'],
            'date_emission' => ['required'],
             'client_id' => ['required'],
             'total_ttc' => ['required'],
             'entreprise_id'=> ['required'],
            'articles_id'=> ['required'],
        //               'quantite'=> ['required'],
        ]);



        $client = User::where('id',$request->client_id )->first();

      $facture = Facture::find($request->id)->update([
             'libelle'=>$request->libelle,
             'date_echeance'=>$request->date_echeance,
             'date_emission'=>$request->date_emission,
             // 'code'=>$code_facture,
             'client_id'=>$client->id,

             // 'designation'=>$request->designation,
             'description'=>$request->description,
             // 'quantite'=>$request->quantite,
             // 'remise'=>$request->remise,
             // 'total_ht'=>$request->total_ht[$i],
             'remise'=>$request->remise,
             'total_ht'=>$request->total_ht,
             'total_taxe'=>$request->total_taxe,
             'total_ttc'=>$request->total_ttc,
             'total_taxe'=>$request->total_taxe,
             'total_ttc'=>$request->total_ttc,
             // 'total_livraison'=>$request->total_livraison,

             // 'taxe_id'=>$request->taxe_id,
             // 'devise_id'=>$request->devise_id,
             'entreprise_id'=>auth()->user()->entreprise_id,
             'user_id'=>auth()->user()->id,
             'created_user'=>$request->user()->id,
      ]);


            $vendeur = User::where('id',Auth::user()->id)->first()  ;


            $article = Article::where('entreprise_id',Auth::user()->entreprise_id)  ;
                                    //  ->where('libelle',$request->items)->get(); articles_id

            // $facture->articles->attach($request->articles_id);

        /*update de joel*/

                //  for($i=0;$i< $request->nombre_article ;$i++ )
                // {
                //     $pivot = DB::table('article_facture')
                //     ->where('facture_id',$request->id )
                //     ->update(
                //         array(
                //             //  'facture_id' =>$facture->id,
                //              'article_id'  => $request->articles_id[$i],  //id des articles
                //              'prix'  =>$request->items[$i]['prix'],      // prix total ===> $request->items[$i]['prix']
                //              'quantite'  =>$request->items[$i]['qte'],  // quantit2 totale =====> $request->items[$i]['qte']
                //              'options'  =>$request->options,
                //              'taxe_id'  =>$request->taxes_id,

                //              'prix_vente'  =>$request->items[$i]['cout'],
                //              'qte_un_article'  =>$request->items[$i]['qte'],
                //              'prix_total'  =>$request->prix_total,  // quantit2 totale

                //              'created_at'=> Carbon::now(),
                //              'updated_at'=>Carbon::now(),
                //         )
                //     );
                // }

            /** end update joel */


            /**update davy */


        for($i=0;$i< $request->nombre_article ;$i++ ) {
        $pivot = DB::table('article_facture')->where('facture_id',$request->id )->delete();
        }


        for($i=0;$i< $request->nombre_article ;$i++ )
        {
            $pivot = DB::table('article_facture')->insert(
                array(
                    'facture_id' =>$request->id,
                    'article_id'  => $request->articles_id[$i],  //id des articles
                    'prix'  =>$request->items[$i]['prix'],      // prix total ===> $request->items[$i]['prix']
                    'quantite'  =>$request->items[$i]['qte'],  // quantit2 totale =====> $request->items[$i]['qte']
                    'options'  =>$request->options,
                    'taxe_id'  =>$request->taxes_id,

                    'prix_vente'  =>$request->items[$i]['cout'],
                    'qte_un_article'  =>$request->items[$i]['qte'],
                    'prix_total'  =>$request->prix_total,  // quantit2 totale

                    'created_at'=> Carbon::now(),
                    'updated_at'=>Carbon::now(),
                )
            );
        }

        /**end update davy */


            for($i=0;$i< $request->nombre_article ;$i++ )
            {
                $pivot1 = DB::table('facture_taxe')
                             ->where('facture_id',$request->id )
                             ->update(
                               array(
                                   // 'facture_id' =>$facture->id,
                                     'taxe_id'  => $request->taxes_id,       //$facture->article_id[$i],
                                    // 'prix'  =>$request->prix,
                                    // 'quantite'  =>$request->qte,
                                    'created_at'=> Carbon::now(),
                                    'updated_at'=>Carbon::now(),
                    )
                );
            }


            //   $fact = Facture::where('id', $facture->id )->get();

                return response()->json([
                    'req' =>  $request->all(),
                      'ici' => $request->articles_id,
                    'articles'=> $request->items,
                    // 'factures' => $fact,
                    'vendeur'=> $vendeur,
                    'client'=> $client,
                    'message'=>'facture enregistré avec success ohhhh'
                ],200);



                  //  }

                  activity()
                  //->performedOn($web)
                 ->log('Update-Facture')
                 // ->causedBy('Facture')
                 ->subject(2)
                 ->withProperties(['test' => 'value']);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $destroyFacture =Facture::find($request->id);
        //
        $facture=Facture::find($request->id)->delete();

        activity()
        ->performedOn($destroyFacture)
       ->log('Supprimer-Facture');
       // ->causedBy('Facture')
       // ->subject(2)
       //    ->withProperties(['test' => 'value']);

        return response()->json([
            'message'=>'facture supprimée'
        ]);



    }

    public function devisenfacture(Request $request)
    {

            //
        $facture=Facture::find($request->id)->update([
            'statut'=>1, // facture
        ]);

        activity()
        ->performedOn($facture)
       ->log('Facture-devisenfacture');
       // ->causedBy('Facture')
        //    ->subject(2)
        //    ->withProperties(['test' => 'value']);


       return response()->json([
           'message'=>'devis transformé en facture'
             ]);

    }

    // public function facturePdf(Request $request ,Facture $facture){
    //     $entreprise = Entreprise::where('id', $request->entreprise_id)->with('media')->first();
    //  $devise_id =$entreprise->devise_id;
    //  $devise_name = parametre::whereId($devise_id )->first();
    //  $devise_name = $devise_name->description;
    //     // $img = base64_encode( $img );
    // return response()->json(  $devise_name);
    // }
    


    public function facturePdf(Request $request ,Facture $facture)
    {


            //    $articles =  DB::table('article_facture')->get();
            //    $taxes =  DB::table('facture_taxe')->get();



            //$details_facture =Facture::where('id',4)->first(); // $request->id details de la facture a modifier

            $details_facture =Facture::where('id',$request->id)->first(); //$request->id
            //$entreprise =Entreprise::where('id',4)->first();


            $entreprise_id= DB::table('factures')->select('entreprise_id')->where('id',$details_facture->id)->get(); // recuperation de l'entreprise
            $entreprise_rec = Entreprise::where('id',$entreprise_id[0]->entreprise_id)->first();

            //client
            // $client_id= DB::table('factures')->select('client_id')->where('id',$details_facture->id)->get(); // liste des clients
            // $client = User::where('id',$client_id[0]->client_id)->first();
            $client = User::where('id',$request->client_id)->first(); //$request->client_id
            $entreprise = Entreprise::where('id', $request->entreprise_id)->with('media')->first();
                //recuperation de la devise
            $devise_id =$entreprise->devise_id;
     $devise = parametre::whereId($devise_id )->first();
     $devise= $devise->description;



            //article
            $list_articles = DB::table('article_facture')->where('facture_id',$details_facture->id)->get(); // liste des articles du pivot
            $detail_articles= DB::table('article_facture')->select('article_id','prix','quantite')->where('facture_id',$details_facture->id)->get(); // liste des articles du pivot

            for ($i=0; $i <  count($detail_articles); $i++) {
                    $detail = $detail_articles[$i]->article_id;
                        $detail_article[$i] = Article::where('id','=', $detail )->select('libelle')->get();
                        //  $detail_art[$i] =  $detail_article[$i];
                    }

                    $detail_art = DB::table('article_facture')
                    ->join('articles', 'articles.id', '=', 'article_facture.article_id')
                    ->where('facture_id',$details_facture->id)
                    ->select('articles.libelle','article_facture.prix','article_facture.quantite')
                    ->get();

                    $detail_facture= Facture::where('id',$details_facture->id)->get();
                    // $total_taxe= DB::table('factures')->select('total_taxe')->where('id',$details_facture->id)->get(); // liste des articles du pivot
                    // $total_ttc= DB::table('factures')->select('total_ttc')->where('id',$details_facture->id)->get(); // liste des articles du pivot
                    // $remise= DB::table('factures')->select('remise')->where('id',$details_facture->id)->get(); // liste des articles du pivot
                    // $total_ht= DB::table('factures')->select('total_ht')->where('id',$details_facture->id)->get(); // liste des articles du pivot
                    // $type_facture = Facture::where('id',$details_facture->id)->select('type_facture_id')->get();

                    $data = array([
                        'client'=>$client,
                        'detail_art'=>$detail_art,
                        'details_facture'=>$details_facture,
                        'entreprise'=>$entreprise,
                        'devise'=>$devise
                    ]); 


                    // $pdf = PDF::loadView('my-pdf-file','data'$data)

                    // view()->share(compact('data',$data));
                    $pdf = PDF::loadView('invoice',compact('client','entreprise','devise', 'detail_art','detail_facture'))
                    ->setOptions(["defaultFont" => "Courier",
                    "defaultPaperSize" => "a4",'isHtml5ParserEnabled' => true, 'isRemoteEnabled' => true
                    ]);
                    // return $pdf->download('facture.pdf');
                    // ->setWarnings(false)
                    // // ->save(public_path("storage/documents/fichier.pdf"))
                    // ->stream()

                    if($request->email){
                        $email = $request->email;
                    }else{
                        $email = $client->email;
                    }


                Mail::send('invoicepdf',compact('client','entreprise','devise','detail_facture','detail_art')
                , function ($message) use($entreprise,$client,$pdf,$email){
                    $message->from($entreprise->email);
                    $message->to($email);
                    $message->subject('Votre facture');
                    $message->replyTo($entreprise->email);
                    $message->sender($entreprise->email);
                    $message->attachData($pdf->output(),"facture.pdf");
                    //  $message->cc($entreprise->email);
                    //  $message->bcc($entreprise->email);
                });

                activity()
                //->performedOn($web)
                ->log('facturePdf-Facture')
                // ->causedBy('Facture')
                ->subject(2)
                ->withProperties(['test' => 'value']);



             return view('invoicepdf',compact('client','entreprise','devise','detail_facture','detail_art'));
    }


    public function changerEtatDeFacture(Request $request){
        $request->validate([
            'id'=> 'required',

        ]);

        $change = Facture::find($request->id) ;

        $btnfacture = Facture::find($request->id)->update([
             'etat'=> $request->etat,
        ]);





         activity()
         ->performedOn($change)
         ->log('Facture-changerEtatDeFacture');
        // ->causedBy('Facture')
        //  ->subject(2)
        //  ->withProperties(['test' => 'value']);

        /* conversion du client en prospect */


        /* End conversion du client en prospect */

        return response()->json([
         'message'=>'etat de facture transforme avec success ',
         'modifie'=>$btnfacture
         ]);

     }


    public function btnfacture(Request $request){



       $btnfacture = Facture::find($request->id)->update([
            'status'=>'facture',
            'etat'=> $request->etat,
            'transition'=> $request->transition,

       ]);


        //update proster en client sous condition
        // if($btnfacture->status == 'facture')
        if($btnfacture = Facture::find($request->id))
        { //$client->id ==  $facture->user_id
          User::find($btnfacture->user_id)->update([
              'status_user'=> 'client',
          ]);
        }

        activity()
        ->performedOn($btnfacture)
        ->log('btnfacture-Facture');
       // ->causedBy('Facture')
       //  ->subject(2)
       //  ->withProperties(['test' => 'value']);

       /* conversion du client en prospect */


       /* End conversion du client en prospect */

       return response()->json([
        'message'=>'devis transformé en facture',
        'devis'=>$btnfacture
        ]);

    }


    public function mailRelance(Request $request)
    {


        $name = "james";

         //relance
         $date2sem = Carbon::now()->addDays(30)->isoFormat('YYYY-MM-DD');
         $date1sem = Carbon::now()->addDays(1)->isoFormat('YYYY-MM-DD');
         $date1jr = Carbon::now()->addDays(1)->isoFormat('YYYY-MM-DD');


         $relance = DB::table('factures')
         ->join('users', 'users.id', '=', 'factures.client_id')
         ->where('factures.entreprise_id',1) //Auth::user()->entreprise_id
         ->where('factures.state','<>','solde')
         ->where('factures.code',$request->code)

         ->select('factures.*',)//'users.*'
         ->whereBetween('factures.date_echeance', [$date1sem,$date2sem])

         ->get();

          //->join('versements', 'factures.id', '=', 'versements.facture_id')
         // ->join('echeanciers', 'echeanciers.facture_id', '=', 'factures.id')
           // ->orderBy('factures.date_echeance', 'asc')
               //->orWhere('factures.state','partiel')

         //
        //  if(isset($relance)){
        //     return response()->json([
        //         $request->all(),
        //        // empty($relance),
        //         //(!isset($relance)),
        //         //(isset($relance)),
        //         $relance,
        //         'user'=> Auth::user()->id,
        //         'entreprise'=> Auth::user()->entreprise_id,
        //     'Error'=> "Cette facture ne peux pas etre envoy2 veiller verifier l'authenticite",
        //     ]);
        //  }


         $versements = DB::table('factures')
         ->join('versements', 'factures.id', '=', 'versements.facture_id')
         // ->join('echeanciers', 'echeanciers.facture_id', '=', 'factures.id')
         //->join('users', 'users.id', '=', 'factures.client_id')
         ->where('factures.entreprise_id',Auth::user()->entreprise_id)
         ->where('factures.state','<>','solde') // apayer , solde , impayer
        // ->where('factures.code',$request->code)
         ->select('factures.*','versements.*')//'users.*'  'versements.*',
         ->whereBetween('factures.date_echeance', [$date1sem,$date2sem])
        // ->orderBy('factures.date_echeance', 'asc')
         ->get();


         $total_versement = 0;
         for($i=0;$i<count($versements);$i++ ){
             $total_versement = $total_versement + $versements[$i]->montant;
         }



        $entreprise_name = Entreprise::where('id',1)->select('libelle')->first(); //Auth::user()->entreprise_id



        $emails = $request->email_client;
        $email =$request->email;
        $text = $request->message;
        $montant_restant = $request->montant_restant;





        if( $request->email != null && $request->code != null )
        {
            // for( $i=0; $i<count($request->emailList);$i++ )
            // {
                Mail::send('mailRelance', compact('relance','name','entreprise_name','text','montant_restant'),function ($message)use($relance,$name,$emails,$entreprise_name,$email,$text,$montant_restant) {
                    $message->from('developpeur@ediqia.com');
                    // $message->sender('developpeur@ediqia.com');
                    $message->to($email);  //
                    // $message->cc('john@johndoe.com', 'John Doe');
                    // $message->bcc('john@johndoe.com', 'John Doe');
                    $message->replyTo('developpeur@ediqia.com');
                    $message->subject('Votre code de connexion');
                    // $message->priority(3);
                    // $message->attach('pathToFile');
                });

                return response()->json([
                    'message'=>'send with success avec les mail du frontend',
                   // 'devis'=>$btnfacture
                   ]);
           // }
        }else{

            return response()->json([
                'message'=>'veiller renseigner les mails des destinataires ou selectionner une facture',
               // 'devis'=>$btnfacture
               ]);

               /***************  */
               //veiller renseigner les mails de destinations
            // a returner un response json simple et enlever la function mail


            Mail::send('mailRelance', compact('relance','name'),function ($message)use($relance,$name) {
                $message->from('developpeur@ediqia.com');
                // $message->sender('developpeur@ediqia.com');
                $message->to('iriebzhj1@gmail.com');
                // $message->cc('john@johndoe.com', 'John Doe');
                // $message->bcc('john@johndoe.com', 'John Doe');
                $message->replyTo('developpeur@ediqia.com');
                $message->subject('Votre code de connexion');
                // $message->priority(3);
                // $message->attach('pathToFile');
            });

                activity()
                    //->performedOn($web)
                ->log('mailRelance-Facture')
                // ->causedBy('Facture')
                ->subject(2)
                ->withProperties(['test' => 'value']);

            return response()->json([
                'message'=>'send with success sans',
               // 'devis'=>$btnfacture
               ]);

        }

    }

    //blade du mail de relance facrure
    public function mailRelanceInfo(Request $request)
    {


        $name = "james";

        $date2sem = Carbon::now()->addDays(15);
          $date1sem = Carbon::now()->addDays(7);
          $date1jr = Carbon::now()->addDays(1);

          $relance = DB::table('factures')
          ->join('versements', 'factures.id', '=', 'versements.facture_id')
          ->join('echeanciers', 'echeanciers.facture_id', '=', 'factures.id')
         // ->where('factures.entreprise_id',Auth::user()->entreprise_id)
          ->select('factures.*','echeanciers.*')
          ->whereBetween('echeanciers.date_echeance',[$date2sem,$date1sem])
          ->orderBy('echeanciers.date_echeance', 'desc')
          ->get();



          $entreprise_name = Entreprise::where('id',Auth::user()->entreprise_id)->select('libelle')->first();

          activity()
          //->performedOn($web)
         ->log('Facture-infomail_relance')
         // ->causedBy('Facture')
         ->subject(2)
         ->withProperties(['test' => 'value']);

         $text = $request->message;

        return view('mailRelance', ['name' => "james", 'text'=>$text, 'relance'=> $relance, 'entreprise_name' => $entreprise_name ]);
    }


//article catalogue <<Oumar>>
    public function mailRelance1(Request $request)
    {

        // return response()->json([
        //     count($request->articleList),
        //     'message'=>"json",
        // ]);

        if(count($request->articleList)> 0 )
        {


            for($i=0;$i<count($request->articleList);$i++ ){
                $result[$i] =$articles = Article::where('entreprise_id',Auth::user()->entreprise_id)
                ->where('id',$request->articleList[$i])
                ->get();
            }
            return response()->json([
                'result'=> $result,
                 'message'=>"json",
             ]);

        }

        // return response()->json([
        //     $result,
        //     'message'=>"json",
        // ]);

        return view('catalogueArticle', ['name' => 'James']);
        //return view('catalogueArticle')->with('message') ;
     }

        // historique des event relatif a une facture  <<Diomande>>
        public function factureactivity_log(Request $request){
              

            $status_facture =  DB::table('activity_log')
                                        ->where('subject_id',$request->subject_id)
                                        ->where('subject_type','=',  'App\Models\Facture')
                                        ->orderBy('id','desc')
                                        ->take(20)
                                        ->get();
                                        //'App\Models\User'
                                        

            for($i=0;$i<count($status_facture);$i++){
                $user[$i] = User::whereId($status_facture[$i]->causer_id)->first();
            }
            
            

            //return response()->json( $user) ;

             // $user = User::whereId($status_facture[0]->causer_id)->first();

          $historique = [];

          for($i=0;$i<count($status_facture);$i++){
              $sol[$i] = [
                "description"=> $status_facture[$i]->description,
                "date"=>   $status_facture[$i]->created_at  ,
                "subject_type"=> "Facture",
                "causer_id"=> $user[$i]->id,
                "causer_fname"=> $user[$i]->nom,
                "causer_lname"=> $user[$i]->prenoms,

              ];
          }
          array_push($historique,$sol);

         // return response()->json(['jojo'=>$historique]);
        

            return response()->json([
            // 'count'=>$status_facture,
                //'$user'=>$user,
                //'status_facture'=>$status_facture,
                //$status_facture,



                'historique'=>$historique,
                'message' => "success",
                
            ]);
    }





    }




//     public function factureactivity_log(Request $request){
//         ///App\Models\User

//     $status_facture =  DB::table('activity_log')
//                                 ->where('subject_id',$request->subject_id)
//                                 ->where('subject_type','=',  'App\Models\Facture')
//                                 ->get();
//                                 //'App\Models\User'

//       for($i=0;$i<count($status_facture);$i++){
//         $user[$i] = User::whereId($status_facture[$i]->causer_id)->first();
//       }

//    // $user = User::whereId($status_facture[0]->causer_id)->first();

//       $historique = [];

//       for($i=0;$i<count($status_facture);$i++){
//           $sol[$i] = [
//             "description"=> $status_facture[$i]->description,
//             "date"=>   $status_facture[$i]->created_at  ,
//             "subject_type"=> "Facture",
//             "causer_id"=> $user[$i]->id,
//             "causer_fname"=> $user[$i]->nom,
//             "causer_lname"=> $user[$i]->prenoms,

//           ];
//       }
//       array_push($historique,$sol);


//     return response()->json([
//        // 'count'=>$status_facture,
//         //'$user'=>$user,
//         //'status_facture'=>$status_facture,
//         'historique'=>$historique,
//         'message' => "success",
//        // $status_facture,
//     ]);
// }