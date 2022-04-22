<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Departement;
use App\Models\User;
use App\Models\Commentaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartementController extends Controller
{

    function __construct()
    {
        //    //les permissions
        //    $this->middleware('permission:index-departement', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-departement', ['only' => ['index']]);
        //    $this->middleware('permission:create-departement', ['only' => ['store']]);
        //    $this->middleware('permission:update-departement', ['only' => ['update']]);
        //    $this->middleware('permission:delete-departement', ['only' => ['destroy']]);

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

        $auth = Auth::user()->entreprise_id;
        $departement = Departement::where('entreprise_id',$auth )->get();

        return response()->json([
            $departement,
            'Liste des departements'
        ]);

    }

    // liste user sans departement
    public function index1(){

        $user_dep_less = DB::table('departement_user')
        ->join('users','departement_user.user_id','=','users.id')
        ->where('users.entreprise_id',Auth::user()->entreprise_id)
        ->select('users.id','users.nom','users.prenoms')
        ->get();
       

        return response()->json([
            'user' => $user_dep_less,
            'Liste des departements'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $auth = Auth::user()->entreprise_id;
        $departement = Departement::where('entreprise_id',$auth )->get();
        //$departement = Departement::all();

        return response()->json([
            'message' => 'Liste des departements',
            'departement' => $departement,

        ]);


    }

    /**
     * Store a newly createddepartement_user resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $auth = Auth::user()->entreprise_id;
        $departement = Departement::where('entreprise_id',$auth );

        $request->validate([
            'libelle' => ['required'],
            //'nombre_employe' => ['required'],
            // 'contact' => ['required','min:8','max:15'],
            //'description' => ['required'],
            // 'email' => ['required','unique:entreprises'],
        ]);

        $departement=Departement::create([

            'libelle'=>$request->libelle,
            'nombre_employe'=>$request->nombre_employe,
            'contact'=>$request->contact,
            'email'=>$request->email,
            'description'=>$request->description,
            'entreprise_id' =>  $auth ,

            //'created_user'=>$request->user()->entreprise_id
        ]);

     //   $departement->users()->attach($request->user_id);

         //  remplissage de la table pivot
         if(count($request->user_id)>0){
             for($i=0;$i<count($request->user_id);$i++ ){
                 $pivot = DB::table('departement_user')->insert([
                    'departement_id' =>  $departement->id, 
                    'user_id' =>  $request->user_id[$i], 
                    'updated_at'=>now(),
                    'created_at' =>now()
                 ]);
             }
           
         }
           



        return response()->json([
            'message' => 'Enregistré avec success',
            'departement' => $departement,
            'entreprise_id' =>  $auth ,

        ]);

        return back()->with('message','Compte crée avec success');
        //Inertia::render('Comptes/departements/departement')->with('message','Compte crée avec success');
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
            'libelle' => ['required'],
            //'nombre_employe' => ['required'],
            // 'contact' => ['required','min:8','max:15'],
            //'description' => ['required'],
            // 'email' => ['required'],
        ]);

        Departement::find($request->id)->update([
            'libelle'=>$request->libelle,
            'nombre_employe'=>$request->nombre_employe,
            'contact'=>$request->contact,
            'description'=>$request->description,
           // 'entreprise_id'=>$auth,
            'email'=>$request->email,
        ]);
        return back()-> with( 'message' , 'Departement Modifié avec success' );
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
        Departement::find($request->id)->delete();
        return response()->json([
            'message' => 'Supprimé avec success',
        ]);
        return back()-> with( 'message' , 'Departement supprimé avec success' );
    }










      //Ajouter des fichiers relatif a une facture
      public function ajoutDeFichierDepartement(Request $request)
      {

        $request->validate([
            'id'=> 'required', // departement_id
            //'commentaire'=> 'required',
        ]);

          $input = $request->all();
          // return response()->json([ 'input'=>$input  ,  'id' => Auth::user()->entreprise_id ]);

    
  
          $dep = Departement::find($request->id);
        
        //  return response()->json([  $input  ]) ;
  
     
              if($request->has('avatar'))
              {
  
                  //version 2
                 $fact = $dep->addMedia($request->file('avatar'))
                              ->withManipulations( ['commentaire' => ['message' => $request->message ] ] )  
                              ->toMediaCollection('avatar');        
                              
               }
  
               $sol = Commentaire::create([
                  'libelle' =>  'fichierDepartement',
                  'commentaire' =>  $request->commentaire,
                  'facture_id' => $request->id,
                 // 'employee_id' => $request->employee_id,
                 // 'client_id' => $request->client_id,
                  'created_user' => Auth::user()->id,
                  'entreprise_id' => Auth::user()->entreprise_id,
                  'departement_id' => $request->id,
               ]);
  
  
  
  
               //details de l'enregistrement
  
               $dep_stored = Departement::with( ['commentaire' ] )
                                     //->where('libelle','fichier')
                                     ->where('id',$request->id)->with('media')->get(); //with('commentaires')->
  
  
  
  
             // $jojo = Facture::find(66)->getFirstMedia();
  
  
                  activity()
                  ->performedOn($dep)
                  ->log('DEPARTEMENT-ajoutDeFichierDepartement');
  
  
  
          return response()->json([
              //isset($request->image),
             // 'media'=>$jojo ,
             // ' $sol'=>$sol,
              //'commentaire'=>$request->commentaire,
              //'facture'=>$facture,
              'departement_stored' => $dep_stored ,
          ]);
  
  
      }
  
  






  
       //Ajouter commentaire sur la facture
       public function ajoutDeCommentaireDepartement(Request $request)
       {
          $request->validate([
              'id'=> 'required', // departement_id
              'commentaire'=> 'required',
          ]);
  
           $dep = Departement::find($request->id);
  
                $sol = Commentaire::create([
                   'facture_id' =>  $request->id,
                   'libelle' =>  'commentaireDepartement',
                   'commentaire' =>  $request->commentaire,
                  // 'facture_id' => $request->id,
                  // 'employee_id' => $request->employee_id,
                  // 'client_id' => $request->client_id,
                   'created_user' => Auth::user()->id,
                   'entreprise_id' => Auth::user()->entreprise_id,
                   'departement_id' => $request->id,
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
                    ->performedOn($dep)
                  ->log('Departement-ajoutDecommentaire');
  
  
  
  
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
                ->log('Departement-SuppressionDeFichier');




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
            'id' => 'required',
         ]);

        $web = Departement::find($request->id);
        
        //return response()->json([ $dep]) ; 

         $comment =  DB::table('commentaires')
         ->where('entreprise_id',Auth::user()->entreprise_id)
         ->where('libelle','commentaireDepartement')
         ->where('departement_id',$request->id)
         ->get();

         //return response()->json([ $web ,  $comment ]) ; 

         if( isset($comment)){
            for($i=0;$i<count($comment);$i++){
                  $user[$i] = User::where('id',$comment[$i]->created_user)->with('roles')->first();
            }
         }

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
                 ->log('DEPARTEMENT-collectDeCommentaire');

              






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



        //collect des fichiers relatif a une facture
        public function collectDeFichierDepartement(Request $request)
        {
          $request->validate([ 
              'id' => 'required',
           ]);
  
           // $input = $request->all();
  
            $Images =Departement::find($request->id);
  
            $dep = Departement::with( ['commentaire' ] )
                                  //->where('libelle','fichier')
                                  ->where('id',$request->id)->with('media')->get(); //with('commentaires')->
  
                  activity()
                  ->performedOn($Images)
                   ->log('Facture-collectDeFichier');
  
  
  
  
  
            return response()->json([
                'departement'=>$dep,
                'message'=>'realise avec sucess' ,
            ]);
  
  
        }





}
