<?php

namespace App\Http\Controllers;

use App\helpers;
use Carbon\Carbon;
use App\Models\Taxe;
use App\Models\user;
use App\Models\Compte;
use App\Models\Module;
use App\Models\Projet;
use App\Models\Depense;
use App\Models\Activite;
use App\Models\Parametre;
use App\Models\Abonnement;
use App\Models\Entreprise;
use App\Models\Patrimoine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Models\AbonnementEntreprise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


use Paydunya\Setup as PaydunyaSetup;

use Illuminate\Support\Facades\Cookie;
use Spatie\Permission\Models\Permission;
use Paydunya\Checkout\Store as PaydunyaStore;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AbonnementController extends Controller
{

    function __construct()
    {
        //$this->role = $role;
        //$this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);


        // $this->middleware('role:gestionnaire|daf', ['only' => ['reabonnement']]);
        // $this->middleware('role:gestionnaire', ['only' => ['store']]);

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $auth = Auth::user()->entreprise_id;
        $abonnements = Abonnement::all();
       // $auth_abonnement = Abonnement::where('entreprise_id',$auth )->get();


       $abonnement_details = DB::table('abonnements')->where('libelle','premium')->first();

       $abonnement_detailss = DB::table('abonnements')
       ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
       ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
       ->where('entreprises.id',Auth::user()->entreprise_id)
       ->select('abonnement_entreprise.*','abonnements.*')
       ->orderBy('abonnements.created_at', 'desc')
       ->first();

        // activity()
        //     ->performedOn($abonnements)
        //      ->log('Abonnement-index');



        return response()->json([

            'auth' => $auth,
            //'auth_abonnement' => $auth_abonnement,
            'List_Abonnements' => $abonnement_details,
            //'abonnement' => $abonnement,
         ]);
    }

        /**Paydunya_Checkout_Store::setName("Magasin Chez Sandra"); // Seul le nom est requis
        Paydunya_Checkout_Store::setTagline("L'élégance n'a pas de prix");
        Paydunya_Checkout_Store::setPhoneNumber("336530583");
        Paydunya_Checkout_Store::setPostalAddress("Dakar Plateau - Etablissement kheweul");
        Paydunya_Checkout_Store::setWebsiteUrl("http://www.chez-sandra.sn");
        Paydunya_Checkout_Store::setLogoUrl("http://www.chez-sandra.sn/logo.png");
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
    public function storeAbonnement(Request $request)
    {
        //
        $auth = Auth::user()->entreprise_id;


        //2-choix du pack
        if($request->libelle=="gratuit"){   $date_final=Carbon::now()->addDay(14);
            $nbr_abonnes=1;
        }else{
            $nbr_abonnes=5;
        }

         $abonnements = Abonnement::create([
            'libelle'=> $request->libelle,
            'nbr_user'=>$nbr_abonnes,
        ]);

        activity()
        ->performedOn($abonnements)
       ->log('Abonnement-Form-Create');

        return response()->json([
            'auth' => $auth,
            'Abonnements' => $abonnements,
            //'abonnement' => $abonnement,

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
        //1-validation
        $request->validate([
            'libelle' => ['required'],
            // 'nom' => ['required'],
            // 'duree' => ['required'],

        ]);
        //2-choix du pack
        if($request->libelle=="gratuit"){
            $date_final=Carbon::now()->addDay(14);
            $nbr_abonnes=5;
            $duree = 14;
        }else{

            $date_final=Carbon::now()->addYear(1);
            $nbr_abonnes=15;
            $duree = 365;
        }

        $abon = Abonnement::find($request->libelle);

        $Abonnement_id =Abonnement::where('libelle',$request->libelle)->first();

        //3-creation de l'abonnement
        // $Abonnement_id = Abonnement::create([
        //     'libelle'=> $request->libelle,
        //     'date_abonnement' => Carbon::now(), //Date de l'abonnement
        //     'date_buttoire' => $duree, //Date buttoire de l'abonnement
        //     'entreprise_id'=>Auth::user()->entreprise_id,
        //     'nbr_abonnes'=>$nbr_abonnes,
        // ]);

         //4-remplissage du pivot abonnement_entreprise
        $pivot = DB::table('abonnement_entreprise')->insert(
            array(
                'entreprise_id' =>Auth::user()->entreprise_id,
                'abonnement_id' =>$Abonnement_id->id,
                'duree' => $duree,  //date buttoire
                'date_final'=>$date_final,
                'created_at'=> Carbon::now(),
                'updated_at'=>Carbon::now(),
            )
        );

        //attribution des permissions aux modules de base
        $module_has_perm = Module::select("*")
                                  ->whereNull('entreprise_id')
                                  ->whereIn('libelle', ['facturation', 'crm', 'catalogue', 'tresorerie', ])
                                  ->orderBy('id','asc')
                                  ->get();

        for($i=0;$i< count($module_has_perm);$i++)
        {
            //$module_has_perm[$i]->id;
            $module[$i] = Module::create([
                'libelle' => $module_has_perm[$i]->libelle,
                'description' => $module_has_perm[$i]->description,
                'montant' => $module_has_perm[$i]->montant,
                'entreprise_id'=>Auth::user()->entreprise_id,
                'created_user'=>Auth::user()->id,
            ]);

            if( $i==0 )
            {
                $module[$i]->givePermissionTo(
                       //TRESORERRI
                    //  'create-tresorerie','edit-tresorerie','index-tresorerie','create-tresorerie','create-tresorerie',//4 tresorerie
                    'create-depense', 'index-depense', 'show-depense', 'delete-depense', //4
                    'create-compte', 'index-compte', 'show-compte', 'delete-compte', //4
                    //  'create-emprunt', 'index-emprunt', 'show-emprunt', 'delete-emprunt', //4
                    //  'create-versement', 'index-versement', 'show-versement', 'delete-versement',//4);
                );

            }elseif( $i==1 ){
                $module[$i]->givePermissionTo(
                    //CRM
                    // 'create-client','edit-client','index-client','create-client','create-client',//2 CRM
                       'create-creancier','edit-creancier','index-creancier','create-creancier','create-creancier',//2
                    // 'create-founisseur','edit-fournisseur','index-fournisseur','create-fournisseur','create-fournisseur',//
                );
            }
            elseif( $i==2 ){
                $module[$i]->givePermissionTo(
                    //Facturatiion
                    'create-facture','edit-facture','index-facture','create-facture','create-facture',//1 facturation
                    // 'create-devis','edit-devis','index-devis','create-devis','create-devis',//1
                );
            }elseif( $i==3 ){
                $module[$i]->givePermissionTo(
                      //incommu poour  le moment
                    'create-facture','edit-facture','index-facture','create-facture','create-facture',//1 facturation
                    // 'create-devis','edit-devis','index-devis','create-devis','create-devis',//1
                    // 'create-client','edit-client','index-client','create-client','create-client',//2 CRM
                    //   'create-creancier','edit-creancier','index-creancier','create-creancier','create-creancier',//2
                    //   'create-founisseur','edit-fournisseur','index-fournisseur','create-fournisseur','create-fournisseur',//2
                    //  'create-catalogue','edit-catalogue','index-catalogue','create-catalogue','create-catalogue',// 3
                    //  'create-tresorerie','edit-tresorerie','index-tresorerie','create-tresorerie','create-tresorerie',//4 tresorerie
                    //'create-depense', 'index-depense', 'show-depense', 'delete-depense', //4
                    //  'create-emprunt', 'index-emprunt', 'show-emprunt', 'delete-emprunt', //4
                    //  'create-versement', 'index-versement', 'show-versement', 'delete-versement',//4);
                );
            }else{
                return response()->json([
                    'meessage'=> 'il existe que 4 modules disponible pour ce package',
                ]);
            }//End attribution des permissions aux modules de base




            //abonnement_module
            $pivot1 = DB::table('abonnement_module')->insert(
                array(
                    'abonnement_id' => $Abonnement_id->id,
                    'module_id' => $module[$i]->id,
                    // 'date_debut' => Carbon::now(),  //date buttoire
                    'date_buttoire'=> Carbon::now()->addMonth(12),
                    'created_at'=> Carbon::now(),
                  //  'updated_at'=>Carbon::now(),
                )
            );



        }




                    // return response()->json([
                    //    // $module_has_perm,
                    //    'pivot1'=>$pivot1,
                    //    'module'=>$module,
                    //    $module_has_perm[0]->libelle,
                    // ]);



        //5-duplication

        // 5.1- TAXES


        //duplicate taxe for company  ==> Auth::user()->id
        $taxes = Taxe::whereNull('entreprise_id')->get();
         //duplication de taxe dans parametres
         if($taxes != null ){
            for($i=0;$i< count($taxes);$i++)
            {
                $taxes_parametres[$i] = Taxe::create([
                'libelle'=>$taxes[$i]->libelle,
                'valeur'=>$taxes[$i]->valeur,
                'valeur'=>$taxes[$i]->valeur,
                'description'=> $taxes[$i]->description,
                'created_user'=> $request->user()->id,
                'entreprise_id'=> Auth::user()->entreprise_id,
                ]);
            }
        }//End duplication de taxe dans parametres



            // $taxes_tt = Parametre::where('type_parametre_id',4)
            //                         ->whereNull('entreprise_id')->get(); // 4 ==>type_taxes

            //   //duplication de taxe dans parametres
            //  if($taxes_tt != null ){
            //     for($i=0;$i< count($taxes_tt);$i++)
            //     {
            //         $taxes_parametres[$i] = Parametre::Create([
            //         'libelle'=>$taxes_tt[$i]->libelle,
            //         'description'=> $taxes_tt[$i]->description,
            //         'created_user'=> $request->user()->id,
            //         'entreprise_id'=> Auth::user()->entreprise_id,
            //         ]);
            //     }
            // }//End duplication de taxe dans parametres



            // //5.1.1duplication de taxe existante
            // $taxes = Taxe::whereNull('entreprise_id')->get();

            //   if( $taxes != null ){
            //     for($i=0;$i< count($taxes);$i++)
            //     {
            //         $taxe_filling[$i] = Taxe::Create([
            //         'libelle'=>$taxes[$i]->libelle,
            //         'description'=> $taxes[$i]->description,
            //         'created_user'=> $request->user()->id,
            //         'entreprise_id'=> Auth::user()->entreprise_id,
            //         'categorie_id' => 4  ,
            //         ]);
            //    }
            // } //End duplication de taxe existante  ==> fini


            //END duplicate TAXES for company  ==> Auth::user()->id
            //*******************************************/
            //*******************************************/



            // //duplicate UNITE DE MESURES for company  ==> Auth::user()->id


           $mesure_tt = Parametre::where('type_parametre_id',5)
           ->whereNull('entreprise_id')->get(); // 6 ==> comptes

             // //duplicate UNITE DE  MESURE for company
             if($mesure_tt != null)
             {
                for($i=0;$i< count($mesure_tt);$i++)
                {
                    $taxes_parametres[$i] = Parametre::Create([
                    'libelle'=>$mesure_tt[$i]->libelle,
                    'description'=> $mesure_tt[$i]->description,
                    'created_user'=> $request->user()->id,
                    'entreprise_id'=> Auth::user()->entreprise_id,
                    ]);
                }
           }//End duplication d'unite de mesures
             //END duplicate TAXES for company  ==> Auth::user()->id
             //*******************************************/
             //*******************************************/


             //*******************************************/
            //*******************************************/
            //duplicate COMPTES for company  ==> Auth::user()->id

            $compte_tt = Parametre::where('type_parametre_id',6)
             ->whereNull('entreprise_id')->get(); // 6 ==> comptes

             if($compte_tt != null)
             {
                for($i=0;$i< count($compte_tt);$i++)
                {
                    $taxes_parametres[$i] = Parametre::Create([
                    'libelle'=>$compte_tt[$i]->libelle,
                    'description'=> $compte_tt[$i]->description,
                    'created_user'=> $request->user()->id,
                    'entreprise_id'=> Auth::user()->entreprise_id,
                    ]);
                }
            }




            $copmtes = Compte::whereNull('entreprise_id')->get();
             if($copmtes != null){
                for($i=0;$i< count($copmtes);$i++)
                {
                $compte[$i] = Compte::create([
                    'numero_compte' => $copmtes->numero_compte,
                    'libelle' => $copmtes->libelle,
                    'description'=> $request->description,
                    'solde'=> $copmtes->solde,
                    'entreprise_id'=>Auth::user()->entreprise_id,
                    'categorie_id' => 6  ,
                ]);
                }
            }
            //End

              //End comptes
              //*******************************************/
              //*******************************************/



              // //duplicate Depenses for company
              $depenses_tt = Parametre::where('type_parametre_id',7)
               ->whereNull('entreprise_id')->get(); // 7 ==> depenses

              if($depenses_tt != null)
               {
                    for($i=0;$i< count($depenses_tt);$i++)
                    {
                        $taxes_parametres[$i] = Parametre::Create([
                        'libelle'=>$depenses_tt[$i]->libelle,
                        'description'=> $depenses_tt[$i]->description,
                        'created_user'=> $request->user()->id,
                        'entreprise_id'=> Auth::user()->entreprise_id,
                        ]);
                    }
             }


            // $depenses = Depense::whereNull('entreprise_id')->get();
            // if($depenses != null)
            // {
            //     for($i=0;$i< count($depenses);$i++)
            //     {
            //         $depense = Depense::Create([
            //             'libelle'=>$depenses->libelle,
            //             'description'=>$depenses->description,
            //             'montant'=>$depenses->montant,
            //             'entreprise_id'=>Auth::user()->entreprise_id,
            //             'categorie_' => 7,


            //         ]);
            //      }
            // }

            //END duplicate DEPENSES for company  ==> Auth::user()->id
           //*******************************************/
            //*******************************************/



            //*******************************************/
            //*******************************************/
            //duplicate Patrimoines
            $patrimoines_tt = Parametre::where('type_parametre_id',8)
              ->whereNull('entreprise_id')->get(); // 8 ==> patrimoines

             if($patrimoines_tt != null)
             {
                for($i=0;$i< count($patrimoines_tt);$i++)
                {
                    $taxes_parametres[$i] = Parametre::Create([
                    'libelle'=>$patrimoines_tt[$i]->libelle,
                    'description'=> $patrimoines_tt[$i]->description,
                    'created_user'=> $request->user()->id,
                    'entreprise_id'=> Auth::user()->entreprise_id,
                    ]);
                }
            }


           $patrimoine = Patrimoine::whereNull('entreprise_id')->get();
             if($patrimoine != null)
            {
                    for($i=0;$i< count($patrimoine);$i++)
                    {
                        $patrimoine=Patrimoine::create([
                        'libelle' => $patrimoine->libelle,
                        'type_patrimoine' => $patrimoine->description,
                        'description' => $patrimoine->description,
                        'montant' => $patrimoine->montant,
                        'entreprise_id' => Auth::User()->Entreprise_id,
                        'categorie'=> 8 ,
                    ]);
                    }
                }


            //END duplicate PATRIMOINES for company  ==> PATRIMOINES == 8
           //*******************************************/
           //*******************************************/





            //*******************************************/
            //*******************************************/
            //duplicate Projets
            $projets_tt = Parametre::where('type_parametre_id',9)
                ->whereNull('entreprise_id')->get(); // 9 ==> projets

                if($projets_tt != null)
                {
                    for($i=0;$i< count($projets_tt);$i++)
                    {
                        $taxes_parametres[$i] = Parametre::Create([
                        'libelle'=>$projets_tt[$i]->libelle,
                        'description'=> $projets_tt[$i]->description,
                        'created_user'=> $request->user()->id,
                        'entreprise_id'=> Auth::user()->entreprise_id,
                        ]);
                    }
            }

           $projets = Projet::whereNull('entreprise_id')->get();

           if($projets != null)
           {
              for($i=0;$i< count($projets);$i++)
              {
                    $projet = Projet::create([
                        'libelle'=>$projets->libelle,
                        'budget'=>$projets->budget,
                        'date_debut'=>$projets->date_debut,
                        'date_fin'=>$projets->date_fin,
                        'description'=>$projets->description,
                        //'agence_id'=>$request->agence_id,
                        //'entreprise_id'=>Auth::user()->entreprise_id,
                        //'departement_id'=>$request->departement_id,
                        //'created_user'=>$request->user()->id
                        'categorie'=>  9,
                    ]);
                }
            }



            //END duplicate PATRIMOINES for company  ==> PATRIMOINES == 8
           //*******************************************/
           //iififi
           //*******************************************/

            //6- Attributtion des permissions de bases
            $user = User::find(Auth::user()->id);

            $role = $user->givePermissionTo([
              'create-facture','edit-facture','index-facture','create-facture','create-facture',//1 facturation
              //  'create-devis','edit-devis','index-devis','create-devis','create-devis',//1
              // 'create-client','edit-client','index-client','create-client','create-client',//2 CRM
              //   'create-creancier','edit-creancier','index-creancier','create-creancier','create-creancier',//2
              //   'create-founisseur','edit-fournisseur','index-fournisseur','create-fournisseur','create-fournisseur',//2
              //  'create-catalogue','edit-catalogue','index-catalogue','create-catalogue','create-catalogue',// 3
              //  'create-tresorerie','edit-tresorerie','index-tresorerie','create-tresorerie','create-tresorerie',//4 tresorerie
              //'create-depense', 'index-depense', 'show-depense', 'delete-depense', //4
              //  'create-emprunt', 'index-emprunt', 'show-emprunt', 'delete-emprunt', //4
              //  'create-versement', 'index-versement', 'show-versement', 'delete-versement',//4
            ]);

            //7- module table pivot
            $module = Module::where('entreprise_id',Auth::user()->entreprise_id)->get();
            return response()->json([
                'module'=>$module,
                'user_perrmission'=>$role,
         //         '$mes_permissions_def'=>$mes_permissions_def,
         //         'permission_devis'=>$permission_devis,
         //      'duree'=>$permission_facture[0]->id,
         //      'message' => 'Abonnement enregistrer avec success',
          ]);






                // //Achat de module
                //     $module = [1,2,3,4];// module facture,devis,crm,
                //     $module_nom = ["facture","devis","crm"];// module facture,devis,crm

                //    // $permission_facture = ["index-facture","index-facture","index-facture","index-facture","index-facture"];
                //    $permission_facture = DB::table('permissions')
                //    ->where('name','like', '%-facture')->get();

                //    $permission_devis = DB::table('permissions')
                //    ->where('name','like', '%-devis')->get();

                //    for($i=0;$i<count($permission_facture);$i++){
                //        $mes_permissions_def[$i] = $permission_facture[$i]->id;
                //     }

                    // for($i=0;$i<count($permission_devis);$i++){
                    //     $mes_permissions_def[$i] = $permission_devis[$i]->id;
                    //  }




                // for($i=0;$i<count($module);$i++)
                // {

                //     $module = Module::create([
                //         'libelle' => $module_nom[$i],
                //         //'description' => $module_nom[$i],
                //         //'montant' => $module_nom[$i],
                //     ]);

                //     for($j=0;$j<count($mes_permissions_def);$j++)
                //     {
                //         DB::table('module_permissions')->insert([
                //             'module_id' => $module[$j],
                //             'permission_id'=> $mes_permissions_def[$j],
                //         ]);
                //     }

                // }


                    //******************************************************* */
                    //*********************************************************










                    activity()
                    ->performedOn($abon)
                   ->log('Abonnement-Store');

        //activity()->log('Abonnement-Store')->subject(2)->withProperties(['test' => 'value']);

        return response()->json([
            'duree'=>$duree,
            Auth::user()->entreprise_id,
           // 'taxes1'=> $taxe1,
            'taxes'=> $taxes,
            'pivot'=> $pivot,
            'message' => 'Abonnement enregistrer avec success',
        ]);

    }



    public function reabonnement(Request $request)
    {

        $abon = Abonnement::find($request->libelle);
        //1-validation
        $request->validate([
            'libelle' => ['required'],
            // 'nom' => ['required'],
            // 'duree' => ['required'],
        ]);
        //2-choix du pack premium et Gold
        if($request->libelle=="premium"){
            $duree=Carbon::now()->addDay(365);
            $nbr_abonnes=15;
        }else{
            $duree=Carbon::now()->addYear(2);
            $nbr_abonnes=50;
        }

        //3-creation de l'abonnement
            //Collecter Dernier Abonnement
            $last_abonnement = DB::table('abonnements')->whereNull('deleted_at')->orderBy('id','desc')->get();
            $date_buttoire = Carbon::parse($last_abonnement[0]->date_buttoire)->addYear();//ajouter 1 an a la date buttoire d'abonnemet



            //extend abonnements
        $Abonnement_id = Abonnement::create([
            'libelle'=> $request->libelle,
            'date_abonnement' => Carbon::now(), //Date de l'abonnement
            'date_buttoire' =>  $date_buttoire, //Date buttoire de l'abonnement
            'entreprise_id'=>Auth::user()->entreprise_id,
            'nbr_abonnes'=>$nbr_abonnes,
        ]);

         //4-remplissage du pivot abonnement_entreprise
        $pivot = DB::table('abonnement_entreprise')->insert(
            array(
                'entreprise_id' =>Auth::user()->entreprise_id,
                'abonnement_id' =>$Abonnement_id->id,
                'duree' => $duree,  //date buttoire
                'created_at'=> Carbon::now(),
                'updated_at'=>Carbon::now(),
            )
        );





        //attribution des permissions aux modules de base
        //et liaison aux modules
        $module_has_perm = Module::select("libelle")
                                  ->distinct('libelle')
                                  ->where('entreprise_id',Auth::user()->entreprise_id)
                                  ->whereNull('deleted_at')
                                  ->whereIn('libelle', ['facturation', 'crm', 'catalogue', 'tresorerie', ])
                                  ->orderBy('id','asc')
                                  ->get();

        for($i=0;$i< count($module_has_perm);$i++)
        {
            //$module_has_perm[$i]->id;
            $module[$i] = Module::create([
                'libelle' => $module_has_perm[$i]->libelle,
                'description' => $module_has_perm[$i]->description,
                'montant' => $module_has_perm[$i]->montant,
                'entreprise_id'=>Auth::user()->entreprise_id,
                'created_user'=>Auth::user()->id,
            ]);

            //abonnement_module
            $pivot1 = DB::table('abonnement_module')->insert(
                array(
                    'abonnement_id' => $Abonnement_id->id,
                    'module_id' => $module[$i]->id,
                    'date_debut' => Carbon::parse($last_abonnement[0]->date_buttoire),  //date buttoire
                    'date_buttoire'=> Carbon::parse($last_abonnement[0]->date_buttoire)->addYear(),
                    'created_at'=> Carbon::now(),
                  //  'updated_at'=>Carbon::now(),
                )
            );
        }

        return response()->json([
            'solution1'=> $module,
            Carbon::parse($last_abonnement[0]->date_buttoire),
            Carbon::parse($last_abonnement[0]->date_buttoire)->addYear(),
           'solution'=> $Abonnement_id,
           'message' => 'Reabonnement enregistrer avec success',
        ]);


        

        activity()->performedOn($abon)->log('Abonnement-Store');

        activity()->log('Abonnement-Store')->subject(2)->withProperties(['test' => 'value']);

        return response()->json([
            'duree'=>$duree,
            Auth::user()->entreprise_id,
           // 'taxes1'=> $taxe1,
            //'taxes'=> $taxes,
            'pivot'=> $pivot,
            'message' => 'Abonnement enregistrer avec success',
        ]);

    }

    /**
     * Display the 
 
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
        $edit =  Abonnement::find($id);

        activity()
        //->performedOn($web)
       ->log('Abonnement-Form-Edit')
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
    public function update(Request $request)
    {
        //

        $request->validate([
            'libelle' => ['required'],
        ]);

        if($request->libelle=="gratuit"){
            $duree=Carbon::now()->addDay(14);
            return response()->json([
                'message' =>"Cet Abonnement n'est pas renoubelable",
            ]);

        }else{
            $duree=Carbon::now()->addYear(1);
        }

        $Abonnement_id = Abonnement::find($request->id)->update([
            'libelle'=> $request->libelle,
            'date_abonnement' => Carbon::now(), //Date de l'abonnement
            'date_buttoire' => $duree, //Date buttoire de l'abonnement
        ]);

        $pivot = DB::table('abonnement_entreprise')->insert(
            array('entreprise_id' =>Auth::user()->entreprise_id,
                'abonnement_id' =>$Abonnement_id->id,
                'duree' => $duree,  //date buttoire
                'created_at'=> Carbon::now(),
                'updated_at'=>Carbon::now(),
            )
        );






        activity()
        ->performedOn($Abonnement_id)
       ->log('Abonnement-Update');

        return response()->json([
            'message' => 'Abonnement Modifié avec success',
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
        $abonnement=Abonnement::find($id)->delete();

        activity()
        ->performedOn($abonnement)
       ->log('Abonnement-Destroy');

        return response()->json([
            'message' => 'Abonnemnt Supprimé avec success',
        ]);

    }


    public function annuler_paiement()
    {


        // Configuration globale de l'URL de redirection après annulation de paiement.
       // \Paydunya\Paydunya_Checkout_Store::setCancelUrl("URL_DE_REDIRECTION_APRES_ANNULATION");
    }























      public function paiement(Request $request)
    {
     
        $montant_ht = $request->montant_ht;
        $montant_tva = $request->montant_tva;
        $montant_remise = $request->montant_remise;
        $montant_ttc = $request->montant_ttc;
        $duree = $request->duree;
        $date_fin = $request->date_fin;
        $abonnement_id = $request->abonnement_id;
        $nbr_abonnes = $request->nbr_abonnes;

        $code = request('token');
        if ($code) {
            //dd(request('token'), request('code'));
            $abonnement_entreprise = AbonnementEntreprise::whereCode($code)->first();
            if ($abonnement_entreprise) {
                PaydunyaSetup::setMasterKey("N7Dgtnx7-S5Ye-EQbb-fmX6-nM8oNXiaPzOh");
                PaydunyaSetup::setPublicKey("test_public_k0bF3clZyOSmxucC2BgejjYo8qk");
                PaydunyaSetup::setPrivateKey("test_private_wbM47D0IUFnL1VJSopKOdmPR8U7");
                PaydunyaSetup::setToken("QMizRQ4ofYn6NrG3Tiaj");
                PaydunyaSetup::setMode("test");

                //Configuration des informations de votre service/entreprise
                PaydunyaStore::setName("Ediqia"); // Seul le nom est requis
                PaydunyaStore::setTagline("Application de gestion");
                PaydunyaStore::setPhoneNumber("+225 0140622180");
                PaydunyaStore::setPostalAddress("Abidjan, Cocody");
                PaydunyaStore::setWebsiteUrl(url('/'));
                PaydunyaStore::setLogoUrl('https://stage.qenium.com/img/logo_complet.c47c8edc.png');

                PaydunyaStore::setCallbackUrl(url('payment'));
                PaydunyaStore::setCancelUrl(url('pack?m=annule'));
                PaydunyaStore::setReturnUrl('https://www.ediqia.com');
                $invoice = new \Paydunya\Checkout\CheckoutInvoice();
                $invoice->setDescription("Abonnement Ediqia");
                $invoice->addCustomData("invEDQ", 'CM00001');

                //dd($abonnement_entreprise);
                $invoice->addItem('Abonnement', 1, $abonnement_entreprise->montant_ttc, $abonnement_entreprise->montant_ttc, '');
                $invoice->addTax("TVA (18%)", $abonnement_entreprise->montant_tva);
                $invoice->setTotalAmount($abonnement_entreprise->montant_ttc);

                $montant_ht = $abonnement_entreprise->montant_ht;
                $montant_tva = $abonnement_entreprise->montant_tva;
                $montant_remise = $abonnement_entreprise->montant_remise;
                $montant_ttc = $abonnement_entreprise->montant_ttc;
                $duree = $abonnement_entreprise->duree;

                if($invoice->create()) {
                    $paiementArray = array(
                        'status' => $invoice->getStatus(),
                        'name' => null,
                        'email' => null,
                        'phone' => null,
                        'pdf' => $invoice->getReceiptUrl(),
                        'response_code' => $invoice->response_code,
                        'response_text' => $invoice->response_text,
                        'token' => $invoice->token,
                        'transaction_id' => $invoice->transaction_id,
                    );
                    $abonnement_entreprise->update([
                        //'entreprise_id' => auth()->user()->entreprise_id,
                        //'created_user' => auth()->user()->id,
                        'token' => $invoice->token,
                        'options' => json_encode($paiementArray),
                    ]);
                    return redirect($invoice->getInvoiceUrl());
                }
                else{
                    return $invoice->response_text;
                }
            }
        }
        else {
            //dd(Auth::user());
            $abonnement_entreprise = AbonnementEntreprise::create([
                'abonnement_id' => $abonnement_id,
                'entreprise_id' => auth()->user()->entreprise_id,
                'moyen_paiement' => "PayDunya",
                'montant_ht' => $montant_ht,
                'montant_tva' => $montant_tva,
                'montant_remise' => $montant_remise,
                'montant_ttc' => $montant_ttc,
                'duree' => $duree,
                'date_final' => $date_fin,
                'active' => 1,
                'status_paiement'=> 0,
                'nbr_abonnes' => $nbr_abonnes,
                'created_user' => auth()->user()->id,
            ]);
            return response()->json([
                'message' => $abonnement_entreprise->code,
            ]);
        }
    }

    public function paiement_status(Request $request)
    {

        // return response()->json([
        //     'token_back'=> $request->token,
        //     'token_front'=> request('token'),
        //     'message'=>'paiement effectuer avec succes',
        // ]);

        PaydunyaSetup::setMasterKey("N7Dgtnx7-S5Ye-EQbb-fmX6-nM8oNXiaPzOh");
        PaydunyaSetup::setPublicKey("test_public_k0bF3clZyOSmxucC2BgejjYo8qk");
        PaydunyaSetup::setPrivateKey("test_private_wbM47D0IUFnL1VJSopKOdmPR8U7");
        PaydunyaSetup::setToken("QMizRQ4ofYn6NrG3Tiaj");
        PaydunyaSetup::setMode("test");

        //Configuration des informations de votre service/entreprise
        PaydunyaStore::setName("Ediqia"); // Seul le nom est requis
        PaydunyaStore::setTagline("Application de gestion");
        PaydunyaStore::setPhoneNumber("+225 0140622180");
        PaydunyaStore::setPostalAddress("Abidjan, Cocody");
        PaydunyaStore::setWebsiteUrl(url('/'));
        PaydunyaStore::setLogoUrl('https://stage.qenium.com/img/logo_complet.c47c8edc.png');

        PaydunyaStore::setCallbackUrl(url('payment'));
        PaydunyaStore::setCancelUrl(url('pack?m=annule'));
        PaydunyaStore::setReturnUrl(route('paiement-status'));
        $invoice = new \Paydunya\Checkout\CheckoutInvoice();

        $token = request('token');
        $abonnement_entreprise = AbonnementEntreprise::whereToken($token)->first();

      // dd(['abonnement_entreprise'=>$abonnement_entreprise,'token'=>$token]);
        // return response()->json([
        //     'message'=> $code,
        //    // 'token_front'=> request('token'),
        //    // 'message'=>'paiement effectuer avec succes',
        // ]);

        //dd($abonnement_entreprise);


        if($abonnement_entreprise)
        {
            if ($invoice->confirm($token)) {
                //dd($invoice);
                if($invoice->getStatus() == 'completed'){
                    $paiementArray = array(
                        'status' => $invoice->getStatus(),
                        'name' => $invoice->getCustomerInfo('name'),
                        'email' => $invoice->getCustomerInfo('email'),
                        'phone' => $invoice->getCustomerInfo('phone'),
                        'pdf' => $invoice->getReceiptUrl(),
                        'response_code' => $invoice->response_code,
                        'response_text' => $invoice->response_text,
                        'token' => $token,
                        'transaction_id' => $invoice->transaction_id,
                    );
                    $abonnement_entreprise->update([
                        'status_paiement' => 1,
                        'date_final' => Carbon::now()->addDay(365),
                        'duree' => 365,
                        'options' => json_encode($paiementArray),
                    ]);



                    $abonnement = DB::table('abonnement_entreprise')
                    ->where('entreprise_id',auth()->user()->entreprise_id)
                    ->where(  'status_paiement',1)
                    ->first();                        
                    
                    $entr =  $abonnement->entreprise_id;
                    $entreprise = Entreprise::whereId($entr)->first();                   
                    
                    Mail::send('emailPaiement', compact('abonnement','entreprise'),function ($message)use($entreprise) {
                        $message->from('no-reply@ediqia.com','ediqia');
                        $message->to('developpeur@ediqia.com');
                        $message->replyTo($entreprise->email);
                        $message->subject('Paiement de module');
                    });



                    return response()->json([
                        'token_back'=> [request('token'),$request->token],
                        'message'=>'paiement effectuer avec succes',
                    ]);

                   // return redirect()->away('localhost:8080');

                    // return response()->json([
                    //     'token_back'=> [request('token'),$request->token],
                    //     'message'=>'paiement effectuer avec succes',
                    // ]);

                }
            }
            else{
                $invoice->getStatus();
                $invoice->response_text;
                $invoice->response_code;
                return redirect('mode-de-paiement');
            }

        }else{
            return response()->json([
               // 'token_back'=> $request->token,
               // 'token_front'=> [$request->token],
                'message'=> 'Echec , Veuillez vérifier vos details et réessayez',
            ]);
        }

    }


}






































































