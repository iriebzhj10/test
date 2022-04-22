<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Taxe;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Compte;
use App\Models\Module;
use App\Models\Depense;
use App\Models\Facture;
use App\Models\Versement;
use App\Models\Parametre;
use App\Models\Abonnement;
//use App\Models\Facture;
use App\Models\Entreprise;
use Illuminate\Http\Request;
 use Illuminate\Bus\Queueable;
 use Illuminate\Mail\Mailable;
 use Illuminate\Queue\SerializesModels;
 use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\TypeParametre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class EntrepriseController extends Controller
{
        // public function __construct(){
        //     $this->middleware('auth');
        // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct(Entreprise $entreprise)
    // {
    //     //$this->middleware("auth");
    //     //$this->entreprise=$entreprise;
    //     $this->aut    authorizeResource(Entreprise::class);
    // }
    // }
    public function index()
    {
        //
        $entreprise = Entreprise::select('email','contact','fixe','libelle')->with('media')->get();
        return response()->json(['entreprise'  => $entreprise],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index1()
    {
        //
        $entre_para = Entreprise::where('id',Auth::user()->entreprise_id)->first();
         $devise =  $entre_para->devise_id;
         $devise = DB::select('select * from parametres where id = ?',  [$devise]);

        $entreprise = Entreprise::where('id',Auth::user()->entreprise_id)->with(['media'])->get();
        $entre_info = DB::table('abonnement_entreprise')->where('entreprise_id',Auth::user()->entreprise_id)->get();

        $abonnement_info = DB::table('abonnements')
        ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
        ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)
        ->select('abonnements.*',)
        ->orderBy('abonnements.created_at', 'desc')
        ->first();

        //******************** */
        $bonnement_entreprise_pivot = DB::table('abonnements')
        ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
        ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)
        ->select('abonnement_entreprise.created_at','abonnement_entreprise.date_final','abonnements.libelle',)
        //->orderBy('abonnements.created_at', 'desc')
        ->first();

        // return response()->json([
        //     Auth::user()->entreprise_id,
        //     $bonnement_entreprise_pivot,
        // ]);

        $date_init = $bonnement_entreprise_pivot->created_at ;
        $date_final = $bonnement_entreprise_pivot->date_final;


       // $diff = Carbon::parse($date_final)->diffInDays( Carbon::parse($date_init));
       if($date_final>Carbon::now()){
        $diff = Carbon::parse($date_final)->diffInDays(Carbon::now()); //
       }else{
        $diff = -(Carbon::parse($date_final)->diffInDays(Carbon::now())); //
       }


        //************************ */


       // $abonnement_info = DB::table('abonnements')->where('entreprise',$entre_info[0]->abonnement_id)->get();
        //$jour_restant=Carbon::now()->diffInDays($abonnement_info->date_buttoire,$abonnement_info->created_at);
        
        // $cover = $entreprise[0]->getFirstMediaUrl('entete','normal');





        // // Get the image and convert into string
        //     $img = file_get_contents( $entreprise[0]->getFirstMediaUrl('logo','normal') );
      
        //     // Encode the image string data into base64
        //     $data = base64_encode($img);


        //$data = base64_encode(file_get_contents( $entreprise[0]->getFirstMediaUrl('logo','normal')  ));
  
    

// $paiement = DB::table('abonnement_entreprise')
// ->where('entreprise_id', Auth::user()->entreprise_id) 
// ->where('abonnement_id', 1) 
// ->get();

        $reponse = [
            // 'paiement' => $paiement,
            'nombre_jour_restant' => $diff,
            'abonnement_entreprise_pivot' => $bonnement_entreprise_pivot,
            // 'nombre_jour_restant' => $jour_restant,
        //    $entre_info,
            'abonnement_info' =>$abonnement_info,
            'entreprise' => $entreprise[0],
            'logo_entreprise'=> $entreprise[0]->getFirstMediaUrl('logo','normal'),
            //'logo'=>$data,
            'entete_entreprise'=> $entreprise[0]->getFirstMediaUrl('entete','normal'),
            'cover_entreprise'=> $entreprise[0]->getFirstMediaUrl('cover'),

            // 'logo_entreprise'=> $entreprise[0]->getMedia('logo')->last()->getUrl('thumb'),
            // 'cover_entreprise'=> $entreprise[0]->getMedia('cover')->last()->getUrl('thumb'),

            // 'entre_para' => $entre_para,
            'devise'=>$devise
        ];

        // $this->getMedia('avatars')->last()->getUrl('thumb')
        // ->defaultUrl('/cover/cover.png')
        return response()->json([
           $reponse,
        ], 200);

        
    }


    public function create()
    {
        //Recupération des domaines d'activié
            $domaine= TypeParametre::where('libelle',"Domaine d'activité")
            ->first();
            $id_domaine=$domaine->id;
            $domaines= Parametre::where("type_parametre_id",$id_domaine)
            ->whereNull('deleted_at')
            ->whereNull('entreprise_id')
            ->whereNull('parent_id')
            ->get();

        //Récupération des tailles de personnel
            $taille= TypeParametre::where('libelle',"Taille de l'entreprise")
            ->first();
            $id_taille=$taille->id;
            $tailles= Parametre::where("type_parametre_id", $id_taille)
            // ->orderBy('id','ASC');
            ->whereNull('deleted_at')
            ->whereNull('entreprise_id')
            ->get();

             //Récupération des devises
             $devise= TypeParametre::where('libelle',"Devise")->first();
             $id_devise=$devise->id;
             $devises= Parametre::where("type_parametre_id",$id_devise
             )
             ->whereNull('deleted_at')
             ->whereNull('entreprise_id')
             ->get();
           

            return response()->json([
                $devises,
                 $tailles,
                 $domaines], 200);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storefavke(Request $request, Entreprise $entreprise, User $user)
    {

        $request->validate([
            'libelle' => ['required'],
            'domaine_id' => ['required'],
            'taille_id' => ['required'],
           'localisation'=> ['required'],
            // 'ville' => ['required'],
            // 'pays' => ['required'],
            'email' => 'required|unique:entreprises',
            'contact' => 'required|unique:entreprises',
        ]);
        // //Récupération de l'id du domaine sélectionné
            // $domaine_id=$request->domaine_id;
            // $domaine= Parametre::where("libelle",$domaine_id)
            // ->first();
            // $domaine_id=$domaine->id;

        // //Récupération de l'id de la taille sélectionné
            // $taille_id=$request->taille_id;
            // $taille= Parametre::where("libelle",$taille_id)
            // ->first();
            // $taille_id=$taille->id;

        $entreprise=Entreprise::create([
            'libelle'=>$request->libelle,
            'domaine_id'=>$request->domaine_id,
            'taille_id'=>$request->taille_id,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'indicateur'=>$request->indicateur,
            'site_internet'=>$request->site_web,
            'fixe'=>$request->fixe,
            'adresse'=>$request->adresse,
            'localisation'=>json_encode($request->localisation),
            'devise_id'=>$request->devise_id,

            // 'ville'=>$request->ville,
            // 'pays'=>$request->pays,
            'created_user'=>auth()->user()->id,
        ]);




           $user = User::where('id',Auth::user()->id)->update(['entreprise_id'=>$entreprise->id]);

            $entreprise_id=Auth::user()->entreprise_id;
            $entreprise_user= Entreprise::where('id',$entreprise_id)->get();

            $entreprise->users()->attach(Auth::user()->id);

        // if($request->file('image'))
        // {
        //     $entreprise->addMediaFromRequest('image')
        //     //->withResponsiveImages()
        //     // ->withManipulations([
        //     //     'thumb' => ['default' => '1'],
        //     // ])
        //     ->toMediaCollection('logo');
        // }

        if($request->file('image'))
        {
            $entreprise->addMediaFromRequest('image')
            ->toMediaCollection('image');
        }

        return response()->json([
            'message'=>'insertion reussi'

        ],200);
    }


public function email(){
    $entreprise_code = Entreprise::latest()->select('code')->first();

    $entreprise_infos = Entreprise::latest()->first();
    Mail::send('entreprisemail', compact('entreprise_infos'),function ($message)use($entreprise_infos) {
        $message->from('developpeur@ediqia.com');
        // $message->sender('developpeur@ediqia.com');
        $message->to($entreprise_infos->email);
        // $message->cc('john@johndoe.com', 'John Doe');
        // $message->bcc('john@johndoe.com', 'John Doe');
        $message->replyTo('developpeur@ediqia.com');
        $message->subject('Votre code de connexion');
        // $message->priority(3);
        // $message->attach('pathToFile');
    });


    // $entreprise_id = Auth::user()->entreprise_id;
    // $entreprise_infos = Entreprise::whereId($entreprise_id)->select('email')->first();
    return response()->json([
        // $entreprise_id,
        $entreprise_infos,
        $entreprise_code
    ],200);
}



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Entreprise $entreprise, User $user)
    {
        $request->validate([
            'libelle' => ['required'],
            'username' => ['required'],// nom d'utilisateur de l'entreprise qui va servir a l'authentifiation
            'domaine_id' => ['required'],
            'taille_id' => ['required'],
            // 'ville' => ['required'],
            'devise_id' => ['required'],
            'localisation'=> ['required'],
            'indicateur'=> ['required'],
            'email' => 'required|unique:entreprises',
            'contact' => 'required|unique:entreprises',
        ]);


        $entreprise_code = Entreprise::latest()->select('code')->first();
        // $host = env('APP_URL');
        // $full_host = $host.'/#/login/'.$entreprise_code->code ;
        //  $url = $request->url ;
        //  $full_host = $url.$entreprise_code->code ;

        //return response()->json([ env('APP_URL') , $jojo ]);

        $username_check = Entreprise::where('username',$request->username)->first();

       // return response()->json([$username_check]);

        if($username_check){

            $error = [
                'path'=> 'username',
                'message' => 'cet username existe deja, Veillez le modifier',
                'error' => True ,

            ] ;

            return response()->json([ 'error'=>$error ]);
        }

        $entreprise=Entreprise::create([
            'libelle'=>$request->libelle,
            'username'=>$request->username,
            'domaine_id'=>$request->domaine_id,
            'taille_id'=>$request->taille_id,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'site_internet'=>$request->site_internet,
            // 'indicateur'=>$request->indicateur,
            'fixe'=>$request->fixe,
            'adresse'=>$request->adresse,
            'localisation'=>$request->localisation,
            'devise_id'=>$request->devise_id,
            // 'ville'=>$request->ville,
            // 'pays'=>$request->pays,

            'created_user'=>auth()->user()->id,
        ]);

        $url = $request->url ;
        $full_host = $url.$entreprise->code ;

 //dupliquer les types depenses

        if ($entreprise) {
            $depense = TypeParametre::whereLibelle('Depense')->first();
            $depenseId = $depense->id;

            $type_depense = parametre::where('type_parametre_id', $depenseId)
            ->whereNull('entreprise_id')
            ->get();


                $data = [];
                for ($i=0; $i <count($type_depense) ; $i++) {
                   $id = $type_depense[$i]->id;

            $replique= Parametre::find($id)->replicate();
       $replique->entreprise_id = $entreprise->id;
                   $replique->save();
                   array_push($data,$id);
                }


                    //creation de taxe par defaut
                $taxe = Taxe::create([
                    'libelle'=>'Tva',
                    'valeur'=>18,
                    'created_user'=>$request->user()->id,
                    'entreprise_id'=>$entreprise->id
                ]);

                //creation de compte (caisse) par defaut

                $compte = Compte::create([
                    'numero_compte' => $entreprise->code,
                    'libelle' => 'Caisse',
                    'description'=> 'compte caisse',
                    'solde'=>0,
                    'entreprise_id'=>$entreprise->id
                ]);
    }


        // return response()->json([
        //     '$request->url'=>$request->url,
        //                               $replique= Parametre::find($id)->replicate();
   // ]);

        //duplication des types depenses
            //     $depense = TypeParametre::whereLibelle('Depense')->first();
            //     $depenseId = $depense->id;
            //     $type_depense = parametre::where('type_parametre_id', $depenseId)
            //     ->where('status','admin')
            //     ->whereNull('entreprise_id')
            //     ->get();

            // foreach ($type_depense as $item) {
            //     $type_depenseId[]=$item->id;
            //     $depense_replicate = Parametre::find($item->id)->replicate();
            //     // $depense_replicate->entreprise_id = $entreprise->id ;
            //     $depense_replicate->save();
            // }




        $user = User::where('id',Auth::user()->id)->update(['entreprise_id'=>$entreprise->id]);

        //info user creator(entreprise)
        $user_connecte = Auth::user()->id;
        $user_createur = Entreprise::where('email', $entreprise->email)->select('created_user','code')->first();
        $info_user_createur = User::where('id', $user_createur->created_user)->get();
        //End info user creator(entreprise

        //ajoux pour authentification
            // $pivot1 = DB::table('users')
            // ->where('id',$info_user_createur[0]->id)
            // ->update(
            // array(
            //         'IdCompte'  =>   $entreprise->code  //$facture->article_id[$i],
            // ));
        //ajoux
           $entreprise_id=Auth::user()->entreprise_id;
           $entreprise_user= Entreprise::where('id',$entreprise_id)->get();

            $entreprise->users()->attach(Auth::user()->id);  // remplissage de la table pivot

            if($request->file('image'))
            {
                $entreprise->addMediaFromRequest('image')
                ->toMediaCollection('logo');
            }


        $entreprise_code = Entreprise::latest()->select('code')->first();


        $entreprise_infos = Entreprise::latest()->first();
        Mail::send('entreprisemail', compact('entreprise_infos','full_host'),function ($message)use($entreprise_infos,$full_host) {
            $message->from('no-reply@ediqia.com','ediqia');
            // $message->sender('developpeur@ediqia.com');
            $message->to($entreprise_infos->email);
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            $message->replyTo('developpeur@ediqia.com');
            $message->subject('Votre code de connexion');
            // $message->priority(3);
            // $message->attach('pathToFile');
        });

        return response()->json([ 
            'entreprise'=>$entreprise,
            'message'=>'operation effectue avec success',
        ]);









        // return response()->json([
        //     'message'=>'insertion reussi',
        // //    'taxes_collect2' =>$taxes,
        // //     'taxes_duplicated'=>$taxes_duplicated,
        //    // 'code entreprise'=>$user->CodeEntreprise,
        //    $user_connecte,
        //    $user_createur,
        //    $user_createur,
        //     $user,
        //     Auth::user()->id,
        //     //$pivot1
        // ],200);
    }



    public function ajoutEntete(Request $request){

        $entreprise = Entreprise::find(Auth::user()->entreprise_id);

        if($request->file('entete'))
        {
            $entreprise->addMediaFromRequest('entete')
            ->toMediaCollection('entete');


            // $entreprise->clearMediaCollection('entete')
            // ->toMediaCollection('entete');

            // $entreprise->addMediaFromRequest('entete')
            // ->toMediaCollection('entete');
        }

        return response()->json([
           'entreprise'=> $entreprise,
           'media'=> $entreprise->getFirstMediaUrl('entete'),
           'message'=>'enregistré avec succès',
        ]);
    }


    public function updateEntete(Request $request){

        $entreprise = Entreprise::find(Auth::user()->entreprise_id);
        if($entreprise)
        {
            if($request->file('entete'))
            {
                $entreprise->clearMediaCollection('entete');
                $entreprise->addMediaFromRequest('entete')->toMediaCollection('entete');

                // return response()->json([
                //     'entreprise'=> $entreprise,
                //     'media'=> $entreprise->getFirstMediaUrl('entete'),

                //     'operation effectue avec success'
                // ]);
            }
        }
        return response()->json([
           'entreprise'=> $entreprise,
           'media'=> $entreprise->getFirstMediaUrl('entete'),
           'message'=>'enregistré avec succès',
        ]);
    }


    public function updateLogo(Request $request){

        $entreprise = Entreprise::find(Auth::user()->entreprise_id);

        // if($request->file('image'))
        // {
        //     $entreprise->addMediaFromRequest('image')
        //     ->toMediaCollection('logo');
        // }

        if($entreprise)
        {
            if($request->file('image'))
            {
                $entreprise->clearMediaCollection('logo');
                $entreprise->addMediaFromRequest('image')->toMediaCollection('logo');

                // return response()->json([
                //     'entreprise'=> $entreprise,
                //     'media'=> $entreprise->getFirstMediaUrl('entete'),

                //     'operation effectue avec success'
                // ]);
            }
        }
        return response()->json([
           'entreprise'=> $entreprise,
           'media'=> $entreprise->getFirstMediaUrl('logo'),
           'message'=>'enregistré avec succès',
        ]);
    }


    public function addCover(Request $request){

        $entreprise = Entreprise::find(Auth::user()->entreprise_id);
        // if($request->file('cover'))
        // {
        //     $entreprise->addMediaFromRequest('cover')
        //     ->toMediaCollection('cover');
        // }

        if($entreprise)
        {
            if($request->file('cover'))
            {
                $entreprise->clearMediaCollection('cover');
                $entreprise->addMediaFromRequest('cover')->toMediaCollection('cover');

                // return response()->json([
                //     'entreprise'=> $entreprise,
                //     'media'=> $entreprise->getFirstMediaUrl('entete'),

                //     'operation effectue avec success'
                // ]);
            }
        }


        return response()->json([
           'entreprise'=> $entreprise,
           'media'=> $entreprise->getFirstMediaUrl('cover'),
           'message'=>'enregistré avec succès',
        ]);
    }


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
        $entreprise_id=Auth::user()->entreprise_id;
        $entreprise_user= Entreprise::where('id',$entreprise_id)->get();
        $entreprise_edit = Entreprise::find($entreprise_user);

        return response()->json($entreprise_edit, 200);
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

        $entreprise_edit = Entreprise::find(Auth::user()->entreprise_id)->update($request->all());


        //logo et nom d'entrepriseem

        return response()->json(['message'=>'update reussi'], 200);
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
        Entreprise::find(Auth::user()->entreprise_id)->delete();
        return response()->json(['message'=>'suppression reussi'], 200);

    }


    public function lien(){

        $entreprise_id=Auth::user()->entreprise_id;
        $entreprise_user= Entreprise::where('id',$entreprise_id)->get();
        $entreprise_code = Entreprise::select('code')->where('id',$entreprise_id)->get();
        $entreprise_hash = Hash::make($entreprise_code);
        return response()->json([
            $entreprise_hash
        ],400);
    }




    public function store1(Request $request, Entreprise $entreprise, User $user)
    {
        $request->validate([
            'libelle' => ['required'],
            'domaine_id' => ['required'],
            'taille_id' => ['required'],
            'ville' => ['required'],
            'pays' => ['required'],
        //    'localisation'=> ['required'],
            'email' => 'required|unique:entreprises',
            'contact' => 'required|unique:entreprises',
        ]);

        $entreprise=Entreprise::create([
            'libelle'=>$request->libelle,
            'domaine_id'=>$request->domaine_id,
            'taille_id'=>$request->taille_id,
            'email'=>$request->email,
            'contact'=>$request->contact,
            'site_internet'=>$request->site_web,
            'fixe'=>$request->fixe,
            'adresse'=>$request->adresse,
            'localisation'=>$request->localisation,
            'ville'=>$request->ville,
            'pays'=>$request->pays,
            'created_user'=>auth()->user()->id,
        ]);



        //info user creator(entreprise)
        $user_connecte = Auth::user()->id;
        $user_createur = Entreprise::where('email', $entreprise->email)->select('created_user','code')->first();
        $info_user_createur = User::where('id', $user_createur->created_user)->get();



        // $entreprise = Entreprise::find(Auth::user()->entreprise_id);
        //     $entreprise->addMediaFromRequest('cover')
        //     ->toMediaCollection('cover')
        //     ->defaultUrl('/cover/cover.png')
        //     ->withFallbackPath('/cover/cover.png');


        //End info user creator(entreprise
        //ajoux pour authentification
            $pivot1 = DB::table('users')
            ->where('id',$info_user_createur[0]->id)
            ->update(
            array(
                    'IdCompte'  =>   $entreprise->code  //$facture->article_id[$i],
            ));
        //ajoux
           $entreprise_id=Auth::user()->entreprise_id;
           $entreprise_user= Entreprise::where('id',$entreprise_id)->get();
        $entreprise->users()->attach(Auth::user()->id);
        if($request->file('image'))
        {
            $entreprise->addMediaFromRequest('image')
            ->toMediaCollection('logo');
        }

        return response()->json([
            'message'=>'insertion reussi',
            //$user->code,
           // 'code entreprise'=>$user->IdCompte,
           $user_connecte,
           $user_createur,
           $user_createur,
            $user,
            Auth::user()->id,
            //$pivot1
        ],200);
    }








    public function analysis(){

        Entreprise::all();

        // $data = Depense::select('*')
        //     ->whereMonth('created_at', Carbon::now()->month)
        //     ->get();


        //     $users = Users::where('status_id', 'active')
        //    ->whereDate( 'created_at', '>', now()->subDays(30))
        //    ->get();

        // $dateS = Carbon::now()->startOfMonth()->subMonth(3);
        // $dateE = Carbon::now()->startOfMonth();
        // $TotalSpent = DB::table('orders')
        // ->select('total_cost','placed_at')
        // ->whereBetween('placed_at',[$dateS,$dateE])
        // ->where(['deleted' => '0', 'delivery_address_id' => $DeliveryAddress->id])
        // ->sum('total_cost');

                $now = Carbon::now();
            // echo $now->year;
            // echo $now->month;
            // echo $now->weekOfYear;


            //* ******************************************
            //Resume
            //*******************************************

            $b=0;
            for($i=$now->month; $i>0; $i--){

                //COMPTES
               $comptes_par_mois[$i] = DB::table('comptes')
               ->where('entreprise_id',Auth::user()->entreprise_id)
               ->where('delete_update_at',0)
               ->whereYear('created_at', Carbon::now()->year)
               ->whereMonth('created_at', Carbon::now()->subMonth($b) )
               ->selectRaw("SUM(solde) as total_solde")->get();
               //->groupBy('libelle')->get();

                         if($comptes_par_mois == null   )
                     { $comptes_par_mois[$i] = 0; }


                //CHIFFRE D'AFFAIRE
               $chiffre_daff_par_mois[$i] = DB::table('versements')
               ->where('entreprise_id',Auth::user()->entreprise_id)
               ->whereYear('created_at', Carbon::now()->year)
               ->whereMonth('created_at', Carbon::now()->subMonth($b) )
               ->selectRaw("SUM(montant) as total_solde")
               ->groupBy('created_at')->get();
                    if($chiffre_daff_par_mois[$i] == null )
                     { $chiffre_daff_par_mois[$i] = 0; }

               //DEPENSES
               $depenses_par_mois[$i] = DB::table('depenses')
               ->where('entreprise_id',Auth::user()->entreprise_id)
               ->whereYear('created_at', Carbon::now()->year)
               ->whereMonth('created_at', Carbon::now()->subMonth($b) )
               ->selectRaw("SUM(montant_depense) as total_solde")->get();

               //DEPENSES
               $emprunts_par_mois[$i] = DB::table('emprunts')
               ->where('entreprise_id',Auth::user()->entreprise_id)
               ->whereYear('created_at', Carbon::now()->year)
               ->whereMonth('created_at', Carbon::now()->subMonth($b) )
               ->selectRaw("SUM(montant) as total_solde")->get();

               //ECHEANCIERS
               $echeanciers_par_mois[$i] = DB::table('echeanciers')
               ->where('entreprise_id',Auth::user()->entreprise_id)
               ->where('state', 0 )
               //->where('date_echeance', '>', Carbon::now()->subMonth($b))
               ->whereYear('created_at', Carbon::now()->year)
               ->whereMonth('created_at', Carbon::now()->subMonth($b) )
               ->whereNotNull('montant')
               ->selectRaw("SUM(montant) as total_solde")->get();




                //Benefice par Mois

               // $benefices_par_mois[$i] = $chiffre_daff_mois[$i] - $depenses_par_mois[$i];

               $b++;
               $cm[$i]=$b;
           }



             //Montant total des devis relanc2
             $echeanciers_par_mois_1[$i] = DB::table('echeanciers')
             ->where('entreprise_id',Auth::user()->entreprise_id)
             //->where('date_echeance', '>', Carbon::now()->subMonth($b))
             ->where('state', 0 )
             ->whereYear('created_at', Carbon::now()->year)
             ->whereMonth('created_at', Carbon::now()->subMonth($b) )
             ->whereNotNull('montant')
             ->selectRaw("SUM(montant) as total_solde")->get();

            //* ******************************************
            //END Resume
            //*******************************************

            //ECHEANCIERS tout
            $echeanciers_global = DB::table('echeanciers')
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->where('state', 0 )
            //->where('date_echeance', '>', Carbon::now()->subMonth($b))
            // ->whereYear('created_at', Carbon::now()->year)
            // ->whereMonth('created_at', Carbon::now()->subMonth($b) )
            ->whereNotNull('montant')
            ->selectRaw("SUM(montant) as total_solde")->get();

            //ECHEANCIERS tout compter
            $echeanciers_global_no = DB::table('echeanciers')
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->where('state', 0 )
            //->where('date_echeance', '>', Carbon::now()->subMonth($b))
            // ->whereYear('created_at', Carbon::now()->year)
            // ->whereMonth('created_at', Carbon::now()->subMonth($b) )
            ->whereNotNull('montant')
            ->selectRaw("SUM(montant) as total_solde")->count();



            // //Chiffre d'affaire Par MOIS
            // $c=0;
            // for($i=$now->month; $i>0; $i--){
            //     $chiffre_daff_mois[$i] = $chiffre_aff_mois_passe = DB::table('versements')
            //      ->where('entreprise_id',Auth::user()->entreprise_id)
            //      ->whereYear('created_at', $now->month )->sum('montant')
            //      ->whereMonth('created_at', Carbon::now()->subMonth($c) )
            //      ->selectRaw("SUM(montant) as total_solde")->get();
            //     // ->groupBy('libelle')->get();;
            //      $c++;
            //  }

              //Depense par Mois
            //   for($i=0;$i<$now->month;$i++){
            //   $depenses_par_mois[$i] = DB::table('depenses')
            //   ->where('entreprise_id',Auth::user()->entreprise_id)
            //   ->whereMonth('created_at', $now->month )->sum('montant');
            //   }

        //






            //* ******************************************
            //CHIFFRE DAFFAIRE
            //*******************************************

          //  Chiffre d'affaire annuelle
                    $chiffre_aff_year = DB::table('versements')
                    ->where('entreprise_id',Auth::user()->entreprise_id)
                    ->whereYear('created_at', Carbon::now()->year)->sum('montant');

           //Chiffre d'affaire semestriel
                            $dateSsem = Carbon::now()->startOfMonth()->subMonth(6); // # months back
                            $dateEsem = Carbon::now()->startOfMonth(); //current month
                    $chiffre_aff_sem = DB::table('versements')
                    ->where('entreprise_id',Auth::user()->entreprise_id)
                    ->whereBetween('created_at',[$dateSsem,$dateEsem])
                    ->whereYear('created_at', Carbon::now()->year)->sum('montant');
            //->whereMonth('created_at', Carbon::now()->subMonth(3))->sum('montant');

           //Chiffre d'affaire trimestriel
                                $dateS = Carbon::now()->startOfMonth()->subMonth(4); // # months back
                                $dateE = Carbon::now()->startOfMonth(); //current month
                    $chiffre_aff_trim = DB::table('versements')
                    ->where('entreprise_id',Auth::user()->entreprise_id)
                    ->whereBetween('created_at',[$dateS,$dateE])
                    ->whereYear('created_at', Carbon::now()->year)->sum('montant');
          // ->whereMonth('created_at', Carbon::now()->subMonth(3))->sum('montant');

            //Chiffre d'affaire du mensuel
                    $chiffre_aff_du_mois = DB::table('versements')
                    ->where('entreprise_id',Auth::user()->entreprise_id)
                    ->whereYear('created_at', Carbon::now()->startOfMonth())->sum('montant');


           //->whereMonth('created_at', Carbon::now()->subMonth(3))->sum('montant');

           //Chiffre d'affaire MOIS PASSE
                    $chiffre_aff_mois_passe = DB::table('versements')
                    ->where('entreprise_id',Auth::user()->entreprise_id)
                    ->whereNull('deleted_at')
                    ->whereMonth('created_at', Carbon::now()->startOfMonth()->subMonth(1) )
                    ->selectRaw("SUM(montant) as total_solde")
                    ->get();

                    if(!$chiffre_aff_mois_passe == null){
                        $chiffre_aff_mois_passe[0]->total_solde = 0;
                    }

                   // ->whereYear('created_at', Carbon::now()->subMonth(1)->toDateTimeString() )->sum('montant');
          // ->whereMonth('created_at', Carbon::now()->subMonth(3))->sum('montant');



            //comptes par Mois





             $datestart = Carbon::now()->startOfMonth()->subMonth(12); // # months back
             $dateend = Carbon::now()->startOfMonth(); //current month





            // for($i=1;$i<=$now->month;$i++){
            //     $c=12;
            //       $comptes_par_mois1[$i] = DB::table('comptes')
            //       ->where('entreprise_id',Auth::user()->entreprise_id)
            //       ->whereYear('created_at', Carbon::now()->year)
            //      // ->whereBetween('created_at',[$datestart,$dateend])
            //       ->whereMonth('created_at', Carbon::now()->subMonth($c) )  //($now->month )
            //       ->selectRaw("SUM(solde) as total_solde")
            //       ->groupBy('libelle')->get();
            //       $c--;
            //   }






            //  ->whereYear('created_at', Carbon::now()->year)
            //->whereYear('created_at', Carbon::now()->subMonth(1))->sum('montant');
           // ->whereMonth('created_at', Carbon::now()->subMonth(3))->sum('montant');

            //* ******************************************
            //END CHIFFRE DAFFAIRE
            //*******************************************




            //* ******************************************
            //DEPENSES
            //********************************************

             //Mois courant
            //  $depenses_du_mois_list = DB::table('depenses')
            //  ->where('entreprise_id',Auth::user()->entreprise_id)
            //  ->whereYear('created_at', Carbon::now()->year)
            //  ->whereMonth('created_at', Carbon::now()->month)->sum('montant_depense')  //;
            //  //->selectRaw("")
            //  ->get();  depenses_year  depenses_du_mois_current  depenses_du_mois_passe



            //Mois courant
            $depenses_du_mois_current = DB::table('depenses')
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)->sum('montant_depense');
             // ->get();

           //Mois passé
           $depenses_du_mois_passe = DB::table('depenses')
           ->where('entreprise_id',Auth::user()->entreprise_id)
           ->whereYear('created_at', Carbon::now()->year)
           ->whereMonth('created_at', Carbon::now()->subMonth(1))->sum('montant_depense');

           //Chiffre d'affaire semestriel
           $dateSdepsem = Carbon::now()->startOfMonth()->subMonth(6); // # months back
           $dateEdepsem = Carbon::now()->startOfMonth(); //current month
            $depenses_sem = DB::table('depenses')
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->whereBetween('created_at',[$dateSdepsem,$dateEdepsem])
            ->whereYear('created_at', Carbon::now()->year)->sum('montant_depense');
            // ->whereMonth('created_at', Carbon::now()->subMonth(3))->sum('montant');

           //Depense trimestriel
           $dateSdep = Carbon::now()->startOfMonth()->subMonth(4); // # months back
           $dateEdep = Carbon::now()->startOfMonth(); //current month
            $depense_trim = DB::table('depenses')
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->whereBetween('created_at',[$dateSdep,$dateEdep])
            ->whereYear('created_at', Carbon::now()->year)->sum('montant_depense');
            // ->whereMonth('created_at', Carbon::now()->subMonth(3))->sum('montant');

               //Depenses annuelle
               $depenses_year = DB::table('depenses')
               ->where('entreprise_id',Auth::user()->entreprise_id)
               ->whereYear('created_at', Carbon::now()->year)->sum('montant_depense');
              // ->whereMonth('created_at', Carbon::now()->subMonth(1))->sum('montant');

            //* ******************************************
            //END DEPENSES
            //********************************************


             //* ******************************************
            //SOLDE DE TOUS LES COMPTES
            //********************************************

               //compte courant du jour
               $comptes_du_jours  = DB::table('factures')
               ->join('versements','versements.facture_id','=','factures.id')
               ->where('factures.entreprise_id',Auth::user()->entreprise_id)
               //->whereYear('created_at', Carbon::now()->year)
               //->whereMonth('created_at', Carbon::now()->subMonth(1))
              // ->selectRaw("SUM(solde) as total_solde,libelle")
              // ->select()
               //->groupBy('libelle')
               ->select('versements.created_at','versements.montant','factures.code','versements.id')
               ->orderBy('versements.montant', 'asc')->take(6)
               ->get();

                   if($comptes_du_jours == null )
                       { $$comptes_du_jours = 0; }

             //Mois courant
             $comptes_mois_current = DB::table('comptes')
             ->where('entreprise_id',Auth::user()->entreprise_id)
             ->where('delete_update_at',0)
             ->whereYear('created_at', Carbon::now()->year)
             ->whereMonth('created_at', Carbon::now()->month)
             ->selectRaw("SUM(solde) as total_solde")
             ->groupBy('libelle')->get();
                    if($comptes_mois_current == null )
                    { $comptes_mois_current = 0; }

              //Mois passé
            $comptes_passe = DB::table('comptes')
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->where('delete_update_at',0)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->subMonth(1))
            ->selectRaw("SUM(solde) as total_solde")
            ->groupBy('libelle')->get();
                if($comptes_passe == null )
                    { $comptes_passe = 0; }

           //Compte semestriel
           $dateSdcomsem = Carbon::now()->startOfMonth()->subMonth(6); // # months back
           $dateEcomsem = Carbon::now()->startOfMonth(); //current month
            $comptes_sem = DB::table('comptes')
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->where('delete_update_at',0)
            ->whereBetween('created_at',[$dateSdcomsem,$dateEcomsem])
            ->whereYear('created_at', Carbon::now()->year)
            ->selectRaw("SUM(solde) as total_solde")
            ->groupBy('libelle')->get();
                    if($comptes_sem == null )
                    { $comptes_sem = 0; }

                //Compte semestriel
             $dateSdcomtrim = Carbon::now()->startOfMonth()->subMonth(4); // # months back
             $dateEcomtrim = Carbon::now()->startOfMonth(); //current month
             $comptes_trim = DB::table('comptes')
             ->where('entreprise_id',Auth::user()->entreprise_id)
             ->where('delete_update_at',0)
             ->whereBetween('created_at',[$dateSdcomtrim,$dateEcomtrim])
             ->whereYear('created_at', Carbon::now()->year)
             ->selectRaw("SUM(solde) as total_solde")
             ->groupBy('libelle')->get();
                  if($comptes_trim == null )
                    { $comptes_trim = 0; }

                //Depenses annuelle groupBy
               $comptes_year = DB::table('comptes')
               ->where('entreprise_id',Auth::user()->entreprise_id)
               ->where('delete_update_at',0)
               ->whereYear('created_at', Carbon::now()->year)
               ->selectRaw("SUM(solde) as total_solde")
               ->groupBy('libelle')->get();
              // ->whereMonth('created_at', Carbon::now()->subMonth(1))->sum('montant');
                if($comptes_year == null )
                { $comptes_year = 0; }

                 //Depenses annuelle
                 $compte_year = DB::table('comptes')
                 ->where('entreprise_id',Auth::user()->entreprise_id)
                 ->where('delete_update_at',0)
                 ->whereYear('created_at', Carbon::now()->year)
                 ->sum('solde');
                    if($compte_year == null )
                    { $compte_year = 0; }



            //* ******************************************
            // END SOLDE DE TOUS LES COMPTES
            //********************************************






            //* ******************************************
            // ECHEANCIER DE TOUS LES COMPTES
            //********************************************


            $devise_id = Entreprise::where('id',Auth::user()->entreprise_id)->select('devise_id')->first();

            $devise = parametre::where('id',$devise_id->devise_id)->select('libelle')->first();




            //* ******************************************
            // ECHEANCIER DE TOUS LES COMPTES
            //********************************************

            //nombre de devis a relancer pour les 7 jours avenir
            $currentDateTime = Carbon::now();
            $newDateTime = Carbon::now()->addDays(7);



             //ECHEANCIERS tout compter
            //  $last_facture = DB::table('factures')
            //  ->join('users','factures.client_id','=','users.id')
            //  ->select('users.nom','factures.montant','facture.code')
            //  ->where('entreprise_id',Auth::user()->entreprise_id)
            //  ->where('state', 1 )
            //  ->whereNotNull('factures.montant')
            //  ->selectRaw("SUM(montant) as total_solde")->get() ; //->count();

            // la liste des 10 dernieres factures
            $list_last_factures = DB::table('factures')
                        ->where('entreprise_id',Auth::user()->entreprise_id)
                        ->where('status',0)
                        ->orderBy('id', 'desc')->take(10)->get();

            // $detail_derniere_facture = DB::table('users')
            //             ->join('users', 'factures.client_id', '=', 'users.id')
            //             ->join('versements', 'versements.facture_id', '=', 'factures.id');

            //liste des versements
            $versements = Versement::whereEntreprise_id(Auth::user()->id);


            config()->set('database.connections.mysql.strict', false);
            //config()->set('database.connections.MariaDB.strict', false);
            $detail_derniere_facture = DB::table('users')
                        ->join('factures', 'factures.client_id', '=', 'users.id')
                        ->join('versements', 'versements.facture_id', '=', 'factures.id')
                        ->where('factures.entreprise_id',Auth::user()->entreprise_id)
                        ->select(
                            'users.id as id_utilisateur','users.code as user_code','users.IdCompte',
                        'users.nom','users.prenoms','users.slug','users.contact','users.indicateur',
                        'users.numero_fixe','users.ville','users.profession','users.type_client',
                        'users.sexe','users.date_naissance','users.lieu_naissance','users.adresse_ip',
                        'users.provider','users.provider_id','users.username', 'users.status_user',
                        'users.email','users.status', 'users.email_verified_at','users.type_user_creancier',
                        'users.creancier_id','users.entreprise_id', 'users.type_appareil_id',
                        'users.type_user','users.pays_id','users.localisation', 'users.created_user',
                        'users.updated_user','users.current_team_id','users.created_at','users.updated_at','users.deleted_at',
                        'users.prospection_id','users.prospection_name', 'users.date_embauche',

                        'factures.id as facture_id','factures.code','factures.libelle','factures.date_echeance',
                        'factures.date_emission','factures.designation','factures.description','factures.quantite',
                        'factures.total_ht', 'factures.total_taxe','factures.total_livraison','factures.remise',
                        'factures.total_ttc','factures.state','factures.etat','factures.transition',
                        'factures.entreprise_id','factures.devise_id','factures.taxe_id','factures.client_id',
                        'factures.user_id','factures.type_facture_id','factures.created_user','factures.updated_user',
                        'factures.status','factures.updated_at as factures_updated_at','factures.deleted_at',


                        'versements.id as versement_id','versements.montant','versements.facture_id',
                       



                         DB::raw('SUM(versements.montant) as total_versement') )
                        ->groupBy('users.id') //factures.client_id
                        ->take(4)->get();

                        $preview = Facture::with([
                            'client',
                            'articles',
                            'versements',
                            'taxes',
                            'entreprise',
                            'media'
                        ])
                        ->where('entreprise_id',Auth::user()->entreprise_id)->orderBy('id','desc')->get();

         //   $detail_derniere_facture1 = DB::select('users')

        //                         SELECT agents.agent_code,agents.agent_name,
        // SUM(orders.advance_amount)
        // FROM agents,orders
        // WHERE agents.agent_code=orders.agent_code
        // GROUP BY agents.agent_code,agents.agent_name
        // ORDER BY agents.agent_code;


                        //->orderBy('factures.id', 'desc')
                        //, 'users.nom','users.prenoms','factures.total_ttc','factures.code','factures.state'
         //->groupBy('factures.client_id')


                        // $top_10_articles_mois = DB::table('factures')
                        // ->join('article_facture', 'factures.id', '=', 'article_facture.facture_id')
                        // ->join('articles', 'articles.id', '=', 'article_facture.article_id')
                        // ->where('factures.entreprise_id',Auth::user()->entreprise_id)
                        // ->selectRaw("SUM(article_facture.quantite) as nombre, SUM(article_facture.prix) as montant, articles.libelle")
                        // ->whereMonth('factures.created_at',Carbon::now()->month)
                        // //->where('article.libelle')
                        // ->groupBy('articles.libelle')->get();

                        //->get();
                          // ->sum('versements.montant')
                          //->selectRaw("Sum(versements.montant) as sommes_total,")

            // $detail_derniere_facture =DB::table('users')
            //                             ->join('factures','factures.client_id', '=', 'users.id')
            //                             ->join('versements','versements.facture_id', '=', 'factures.id')
            //                             ->where('factures.entreprise_id',Auth::user()->entreprise_id)
            //                             ->selectRaw("Sum(versements.montant) as sommes_total,")
            //                             ->get();

                        // return response()->json([  $detail_derniere_facture,]);

            $vers= DB::table('versements')
                        //->join('users', 'factures.client_id', '=', 'users.id')
                        //->where('factures.entreprise_id',Auth::user()->entreprise_id)
                        ->where('entreprise_id',Auth::user()->entreprise_id)
                        ->whereNotNull('facture_id')
                        ->orWhereNotNull('emprunt_id')
                        //->select('users.nom','users.prenoms','factures.total_ttc','factures.code')
                        ->orderBy('id', 'asc')->get();

                    //top 6 comptes entreprise connectees
                    $entrees = DB::table('comptes')->where('entreprise_id',Auth::user()->entreprise_id)
                                    ->where('delete_update_at',0)
                                    // ->whereNull('deleted_at')
                                ->orderBy('solde','desc')->take(6)->get();

                    //Sommes total des comptes de l'entreprise connectees
                    // $sommesTotalEntrees = DB::table('comptes')
                    //                     ->selectRaw("Sum(solde) as sommes_total,")
                    //                     ->where('entreprise_id',Auth::user()->entreprise_id)->get();
                    //                 //->whereNull('deleted_at')
                    //                 //->orderBy('solde','desc')
                    //                 //->raw('SUM(sum_total)')
                    //                // ->groupBy('entreprise_id')

                    //                // ->get();

                                    //raw('SUM(total_commande)'))->groupBy('user_id')

                 //top  depenses entreprise connect2
                $sorties = DB::table('depenses')
                        //->join('users', 'factures.client_id', '=', 'users.id')
                        //->where('factures.entreprise_id',Auth::user()->entreprise_id)
                        ->where('entreprise_id',Auth::user()->entreprise_id)
                       // ->whereNotNull('facture_id')
                        //->orWhereNotNull('emprunt_id')
                        //->select('users.nom','users.prenoms','factures.total_ttc','factures.code')
                        ->orderBy('id', 'asc')->get();


            //top 10 des clients acheteurs(clients)
            //  $top_10_clients  = DB::table('factures')
            // ->join('entreprises', 'factures.entreprise_id', '=', 'entreprises.id')
            // ->join('entreprise_user', 'entreprise_user.entreprise_id', '=', 'entreprises.id')
            // ->join('users', 'entreprise_user.user_id', '=', 'users.id')
            // ->join('factures', 'factures.client_id', '=', 'users.id')
            // ->whereNotNull('factures.client_id')
            // ->where('entreprises.entreprise_id',Auth::user()->entreprise_id)
            // //->whereNotNull('facture_id')
            // //->orWhereNotNull('emprunt_id')
            // //->select('users.nom','users.prenoms','factures.total_ttc','factures.code')
            // //->orderBy('id', 'asc')
            // ->get();

           // $top_10_clients = \DB::select('SELECT users.*, SUM(total_ttc) as somme, client_id FROM factures, users WHERE users.id= factures.client_id GROUP BY(client_id) ORDER BY somme DESC LIMIT 10');


            //$sqlQuery = "SELECT users.*, SUM(total_ttc) as somme, client_id FROM factures, users WHERE users.id= factures.client_id GROUP BY(client_id) ORDER BY somme DESC LIMIT 10";
            //$top_10_clients = DB::select(DB::raw($sqlQuery));

           // $top_10_clients = Facture::select('client_id', DB::raw('SUM(total_ttc) as somme'))->groupBy('client_id')->orderBy('somme','desc')->take(10)->get();


            //select('user_id', DB::raw('SUM(total_commande)'))->groupBy('user_id')
            //Cheick 😼umar Coulibaly, [2021-12-01 4:51 PM]
            //SELECT users.*, SUM(total_ttc) as somme, client_id FROM factures, users WHERE users.id= factures.client_id GROUP BY(client_id) ORDER BY somme DESC LIMIT 2;





            // = DB::table('entreprises')
            // ->join('entreprise_user', 'entreprise_user.entreprise_id', '=', 'entreprises.id')
            // ->join('users', 'entreprise_user.user_id', '=', 'users.id')
            // ->join('factures', 'factures.client_id', '=', 'users.id')->groupBy('client_id')
            // ->whereNotNull('factures.client_id')
            // ->where('entreprises.id',Auth::user()->entreprise_id)
            // ->selectRaw("Sum(total_ttc) as totaux, users.*")
            // ->distinct()
            // ->get();

              //->whereNotNull('facture_id')
            //->orWhereNotNull('emprunt_id') ->selectRaw("SUM(solde) as total_solde")-

           // ->selectRaw("SUM(factures.total_ttc' as total_solde),users.*")

            // ->join('factures', 'entreprise_user.user_id', '=', 'factures.id')
            //->groupBy('factures.tota')

            // $top_10_clients = DB::table('factures')
            // ->groupBy('client_id')->get();
            // //->groupBy('total_ttc')
            // //->get();


                //top 10 des clients acheteurs
            $top_10_clients_depuis_deb = Facture::select('client_id', DB::raw('SUM(total_ttc) as somme'))
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->with(
               [ 'client' =>function($q){
                   $q->where('delete_update_at',0);
                   $q->where('entreprise_id',Auth::user()->entreprise_id);

               } ]
            )
            ->groupBy('client_id')->orderBy('somme','desc')->take(10)
            //->groupBy('client_id')
            //->groupBy('total_ttc')
            ->get();

            $top_10_clients_mois = Facture::select('client_id', DB::raw('SUM(total_ttc) as somme'))
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->with(
                [ 'client' =>function($q){
                    $q->where('delete_update_at',0);
                    $q->where('entreprise_id',Auth::user()->entreprise_id);
                } ]
                )
                ->whereMonth('created_at', Carbon::now()->month)
                ->groupBy('client_id')->orderBy('somme','desc')->take(10)
            ->get();

            $top_10_clients_mois_passe = Facture::select('client_id', DB::raw('SUM(total_ttc) as somme'))
            ->where('entreprise_id',Auth::user()->entreprise_id)
            ->whereMonth('created_at', Carbon::now()->subMonth(1))
            ->with(
                [ 'client' =>function($q){
                    $q->where('delete_update_at',0);
                    $q->where('entreprise_id',Auth::user()->entreprise_id);
                } ]
            )
            ->groupBy('client_id')->orderBy('somme','desc')->take(10)
        ->get();

        $top_10_clients_year = Facture::select('client_id', DB::raw('SUM(total_ttc) as somme'))
        ->where('entreprise_id',Auth::user()->entreprise_id)
        ->whereYear('created_at', Carbon::now()->year)
        ->with(
            [ 'client' =>function($q){
                $q->where('delete_update_at',0);
                $q->where('entreprise_id',Auth::user()->entreprise_id);
            } ]
        )
        ->groupBy('client_id')->orderBy('somme','desc')->take(10)
         ->get();

         //top 10 des articles acheter

         $top_10_articles_mois = DB::table('factures')
         ->join('article_facture', 'factures.id', '=', 'article_facture.facture_id')
         ->join('articles', 'articles.id', '=', 'article_facture.article_id')
         ->where('factures.entreprise_id',Auth::user()->entreprise_id)
         ->selectRaw("SUM(article_facture.quantite) as nombre, SUM(article_facture.prix) as montant, articles.libelle")
         ->whereMonth('factures.created_at',Carbon::now()->month)
         //->where('article.libelle')
         ->groupBy('articles.libelle')->get();

         $top_10_articles_mois_passe = DB::table('factures')
         ->join('article_facture', 'factures.id', '=', 'article_facture.facture_id')
         ->join('articles', 'articles.id', '=', 'article_facture.article_id')
         ->where('factures.entreprise_id',Auth::user()->entreprise_id)
         ->selectRaw("SUM(article_facture.quantite ) as nombre, SUM(article_facture.prix) as montant, articles.libelle")
         ->whereMonth('factures.created_at',Carbon::now()->subMonth(1))
         ->groupBy('articles.libelle')->get();

         $top_10_articles_year = DB::table('factures')
         ->join('article_facture', 'factures.id', '=', 'article_facture.facture_id')
         ->join('articles', 'articles.id', '=', 'article_facture.article_id')
         ->where('factures.entreprise_id',Auth::user()->entreprise_id)
         ->selectRaw("SUM(article_facture.quantite ) as nombre, SUM(article_facture.prix) as montant, articles.libelle")
         ->whereYear('factures.created_at',Carbon::now()->year)
         ->groupBy('articles.libelle')->get();

         $top_10_articles_depuid_deb = DB::table('factures')
         ->join('article_facture', 'factures.id', '=', 'article_facture.facture_id')
         ->join('articles', 'articles.id', '=', 'article_facture.article_id')
         ->where('factures.entreprise_id',Auth::user()->entreprise_id)
         ->selectRaw("SUM(article_facture.quantite) as nombre, SUM(article_facture.prix) as montant, articles.libelle")
         //->whereMonth('created_at',Carbon::now()->month)
         ->groupBy('articles.libelle')
         ->orderBy('nombre','desc')
         ->take(10)->get();


         $list_depenses = DB::table('depenses')
         ->where('entreprise_id',Auth::user()->entreprise_id)
         ->take(10)
         ->get();






            $nbr_a_relancer = DB::table('echeanciers')
            ->where('state', '=', 0)
            //->whereBetween('date_echeance',[$currentDateTime,$newDateTime])
            ->count('id');
                if($nbr_a_relancer == null )
                { $nbr_a_relancer = 0; }

            $sum_a_relancer = DB::table('echeanciers')
            ->where('state', '=', 0)
            //->whereBetween('date_echeance',[$currentDateTime,$newDateTime])
            ->selectRaw("SUM(montant) as total_solde")
            ->get(); //->count('id');
                // if($sum_a_relancer[$i]->total_solde == null )
                // { $sum_a_relancer[$i]->total_solde = 0; }


            $i=0;//
            //'comptes_par_mois'=> $comptes_par_mois[1],

            $stat =    [
            'devise'=>$devise->libelle, //->devise_id
           // 'entreprise_id'=>Auth::user()->entreprise_id,
            'month'=>   Carbon::now()->startOfMonth()->subMonth(),
            'month1'=>   Carbon::now()->startOfMonth(),
            'list_depenses'=>$list_depenses,
            'depenses_du_mois_current'=> $depenses_du_mois_current,
            'depenses_du_mois_passe'=>$depenses_du_mois_passe,
            'depenses_sem' => $depenses_sem,
            'depense_trim' => $depense_trim,
            'depenses_year'=> $depenses_year,

            'top_10_articles_mois'=>$top_10_articles_mois,
            'top_10_articles_mois_passe'=>$top_10_articles_mois_passe,
            'top_10_articles_year'=>$top_10_articles_year,
            'top_10_articles_depuid_deb'=> $top_10_articles_depuid_deb,

          //  'top_10_clients'=>$top_10_clients[0]->client_id,
       
            'top_10_clients_year'=>$top_10_clients_year,
            'top_10_clients_mois_passe'=>$top_10_clients_mois_passe,
            'top_10_clients_mois'=>$top_10_clients_mois,
            'top_10_clients_depuis_deb'=>$top_10_clients_depuis_deb,

            'compte_du_jour'=>$entrees,
          //'sommesTotalEntrees' => $sommesTotalEntrees,
            'sorties'=>$sorties,
            'vers'=>$comptes_du_jours,
          //'devise'=>$devise->libelle,

            'sumTotal_devis_a_relancer'=> $sum_a_relancer,
            'nbr_de_devis_a_relancer'=>$nbr_a_relancer,
            'tete'=>$sum_a_relancer[$i]->total_solde,

            'comptes_par_mois'=> $comptes_par_mois,
            'chiffre_daff_par_mois' => $chiffre_daff_par_mois,
            'depenses_par_mois' =>  $depenses_par_mois,
            'emprunts_par_mois' => $emprunts_par_mois,

            'echeanciers_par_mois'=> $echeanciers_par_mois,
            'echeanciers_global'=>$echeanciers_global,
            'echeanciers_global_no'=>$echeanciers_global_no,




            'chiffre_aff_year'=> $chiffre_aff_year,
            'chiffre_aff_sem' => $chiffre_aff_sem,
            'chiffre_aff_trim' => $chiffre_aff_trim,
            'chiffre_aff_du_mois' => $chiffre_aff_du_mois,
            'chiffre_aff_mois_passe' => $chiffre_aff_mois_passe[0]->total_solde,






            // 'comptes_mois_current'=>$comptes_mois_current,
            // 'comptes_sem'=>$comptes_sem,
            // 'comptes_trim'=>$comptes_trim,
            // 'comptes_year'=>$comptes_year,
            // 'compte_year'=>$compte_year,

            'list_last_factures'=>$list_last_factures,
            'detail_derniere_facture'=>$detail_derniere_facture,
            'versements'=>$versements,
            'preview'=>$preview,
       ];







           return response()->json([

            $stat,

            // "Chiffre d'affaire anuelle"     => $chiffre_aff_year,
            // "chiffre_aff_sem"     => $chiffre_aff_sem,
            // 'chiffre_trim'=>$chiffre_aff_trim,
            // 'chiffre_aff_mois_passe'=>$chiffre_aff_mois_passe,

            // 'depense_courante'     => $depenses_current,
            // 'depense_mois'=>$depenses_passe,
            // 'depenses_sem'=>$depenses_sem,
            // 'depenses_trim'=>$depense_trim,
            // 'depenses_year'=>$depenses_year,

            // '$comptes_current'=>$comptes_current,
            // 'comptes_passe'=>$comptes_passe,
            // 'comptes_sem'=>$comptes_sem,
            // 'comptes_trim'=>$comptes_trim,
            // 'comptes_year'=>$comptes_year,
            // 'compte_year'=>$compte_year,

            // 'echeancier_info'=>$echeancier_info,
            //'mois'=>$now->month,
            //'$chiffre_daff'=>$chiffre_daff,
            //'depenses_par_mois'=>$depenses_par_mois,
            //'benefices_par_mois'=> $benefices_par_mois,



            // $comptes_par_mois,
            // $chiffre_daff_par_mois,
            // $depenses_par_mois,
            // $emprunts_par_mois,
            // $echeanciers_par_mois,



            // $chiffre_aff_year,
            // $chiffre_aff_sem,
            // $chiffre_aff_trim,
            // $chiffre_aff_du_mois,
            // $chiffre_aff_mois_passe,



             $depenses_du_mois_current,
             $depenses_du_mois_passe,
             $depenses_sem,
             $depense_trim,
             $depenses_year,



            // $comptes_mois_current,
            // $comptes_sem,
            // $comptes_trim,
            // $comptes_year,//group
            // $compte_year,













           // 'now'=>$now->month,
           // 'comptes_par_mois1'=> $comptes_par_mois1,
           // 'cm'=>$cm,


        ],200);
    }




}






// 'comptes_par_mois'=> $comptes_par_mois,
// 'chiffre_daff_par_mois' => $chiffre_daff_par_mois,
// 'depenses_par_mois' =>  $depenses_par_mois,
// 'emprunts_par_mois' => $emprunts_par_mois,
// 'echeanciers_par_mois'=> $echeanciers_par_mois,



// 'chiffre_aff_year'=> $chiffre_aff_year,
// 'chiffre_aff_sem' => $chiffre_aff_sem,
// 'chiffre_aff_trim' => $chiffre_aff_trim,
// 'chiffre_aff_du_mois' => $chiffre_aff_du_mois,
// 'chiffre_aff_mois_passe' => $chiffre_aff_mois_passe,



// 'depenses_du_mois_current'=> $depenses_du_mois_current,
// 'depenses_du_mois_passe'=>$depenses_du_mois_passe,
// 'depenses_sem' => $depenses_sem,
// 'depense_trim' => $depense_trim,
// 'depenses_year'=> $depenses_year,


// 'comptes_mois_current'=>$comptes_mois_current,
// 'comptes_sem'=>$comptes_sem,
// 'comptes_trim'=>$comptes_trim,
// 'comptes_year'=>$comptes_year,//group
// 'compte_year'=>$compte_year,
