<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Taxe;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Agence;
use App\Models\Compte;
use App\Models\Depense;
use App\Models\Parametre;
use App\Models\Departement;
use App\Models\SousDepense;
use Illuminate\Http\Request;
use App\Models\TypeParametre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class DepenseController extends Controller
{

    function __construct()
    {
        //    les permissions
        //    $this->middleware('permission:index-depense', ['only' => ['index']]);  //  
        //    $this->middleware('permission:show-depense', ['only' => ['show']]);
        //    $this->middleware('permission:store-depense', ['only' => ['store']]);
        //    $this->middleware('permission:create-depense', ['only' => ['create']]);
        //    $this->middleware('permission:update-depense', ['only' => ['update']]);
        //    $this->middleware('permission:delete-depense', ['only' => ['destroy']]);

        //     // les roles
        //    $this->middleware('role:gestionnaire', ['only' => ['store','index','update','destroy']]);
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $depenses = Depense::whereEntreprise_id(Auth::user()->entreprise_id)
        ->whereStatus_depense('depense simple')
        ->with([
            'comptes',
            'media'
        ])->get();


        $depense_recurrente = Depense::whereEntreprise_id(Auth::user()->entreprise_id)
        ->whereNotNull('date_recurrente')
        ->with([
            'comptes',
            'media'
        ])->get();


        $depense_groupe = Depense::whereEntreprise_id(Auth::user()->entreprise_id)
        ->where('status_depense','depense groupe')
        ->with([
            'sous_depenses',
            'media'
        ])->get();






        // $reglement = DB::table('compte_depense')->get();

        return response()->json([
            'depense_groupe'=>$depense_groupe,
            'depense'=>$depenses,
            'depense_recurrente'=>$depense_recurrente

        ], 200);
                //

    }


    
    public function indexRecurrente(Request $request)
    {


        $depenses = Depense::whereEntreprise_id(Auth::user()->entreprise_id)
        ->whereNotNull('date_recurrente')
        ->with([
            'comptes',
            'media'
        ])->get();




        // $reglement = DB::table('compte_depense')->get();

        return response()->json(['depense'=>$depenses], 200);
                //

    }





    /**
     * Show the form for creating a new resource.  depense_edits
     *
     * @return \Illuminate\Http\Response
     */
    public function item(Request $request)
    {
        //

        $libelle = $request->item;
        if ($libelle == 'projet') {
            $projet= TypeParametre::where('libelle',"Projet")
            ->first();
            $id_projet=$projet->id;
            $projet= Parametre::where("type_parametre_id", $id_projet)->get();

            return response()->json([
                'projet'=>$projet ,
                'message' => 'projet Collecté avec success',
            ]);
        }

        if ($libelle == 'employe') {
            $employe= User::where('entreprise_id',Auth::user()->entreprise_id)
            ->where('status_user','employee')
            ->get();
            return response()->json([
                'employe'=>$employe ,
                'message' => 'employe Collecté avec success',
            ]);
        }

        if ($libelle == 'departement') {
            $departement=Departement::where('entreprise_id',Auth::user()->entreprise_id)
            ->get();
            return response()->json([
                'departement'=>$departement ,
                Auth::user()->entreprise_id,
                'message' => 'departements Collecté avec success',
            ]);
        }
        if ($libelle == 'agence') {
            $agence=Agence::where('entreprise_id',Auth::user()->entreprise_id)
            ->get();
            return response()->json([
                'agence'=>$agence ,
                Auth::user()->entreprise_id,
                'message' => 'agences Collecté avec success',
            ]);
        }
    }


/**
 *
 * update TypeDepense/store
 */
    public function type_depense_store(Request $request){

        $request->validate([
            'libelle'=>['required'],
        ]);

        $type_depense_id = TypeParametre::whereLibelle('Depense')->first();
        // $type_depense = TypeParametre::whereDeleted_at('null')->first();
            $type_depense_id = $type_depense_id->id;

            $depense_exist = Parametre::whereLibelle($request->libelle)->first();
            if ($depense_exist) {
                return response()->json([
                    'depense existe déjà',
                    $depense_exist ,
                    ] ,200);
            }

            if (!$depense_exist) {
                $depense = Parametre::create([
                    'libelle'=>$request->libelle,
                    'description'=>$request->description,
                    'type_parametre_id'=>$type_depense_id,
                    'entreprise_id'=>Auth::user()->entreprise_id,
                    'created_user'=>Auth::user()->id
                ]);

                return response()->json([
                    $depense,
                    'insertion reussi',
                    ] ,200);

            }

    }

/**
 *
 * TypeDepense/update
 */
    public function type_depense_update(Request $request){

        $request->validate([
            'libelle'=>['required'],
        ]);

        $type_depense = Parametre::whereEntreprise_id(Auth::user()->entreprise_id)->first();

        if ($type_depense) {
         $type_depense = Parametre::find($request->id)->update($request->all());

         return response()->json([$type_depense,'modifié avec success'],200);
        }

       if (!$type_depense) {
        return response()->json('vous n\'êtes pas autorisé à modifier');
       }

    }



/**
 *
 * TypeDepense/destroy
 */
public function type_depense_destroy(Request $request){

    $type_depense = Parametre::whereEntreprise_id(Auth::user()->entreprise_id)->first();

    if ($type_depense) {
     $type_depense = Parametre::find($request->id)->delete();

     return response()->json(['supprimé avec success'],200);
    }

   if (!$type_depense) {
    return response()->json('vous n\'êtes pas autorisé à supprimer');
   }

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
                            'libelle'=>['required'],
                            // 'type_depense_id'=>['required'],
                            'montant_depense'=>['required','numeric'],
                            // 'fournisseur'=>['required'],
                            'date_emission'=>['required']
                        ]);

                                                //categorisation de depense
                                    $category = Parametre::where('libelle', $request->depense)
                                    ->where('entreprise_id',$request->user()->entreprise_id)->first();
                                    $depense = Depense::Create([
                                        'libelle'=>$request->libelle,
                                        'description'=>$request->description,
                                        'montant_depense'=>$request->montant_depense,
                                        'type_depense'=>$request->type_depense,
                                        'fournisseur'=>$request->fournisseur,
                                        'facture_fournisseur'=>$request->facture_fournisseur,
                                        'date_emission'=>$request->date_emission,
                                        'entreprise_id'=>Auth::user()->entreprise_id,
                                        'created_user'=>Auth::user()->id,

                                        'projet_id'=>$request->projet_id,
                                        'departement_id'=>$request->departement_id,
                                        'agence_id'=>$request->agence_id,
                                        'employe_id'=>$request->employe_id,

                                        'projet'=>$request->projet,
                                        'departement'=>$request->departement,
                                        'agence'=>$request->agence,
                                        'employe'=>$request->employe,

                                        'status_depense'=>'depense simple'
                                    ]);

                                    if($request->file('image'))
                                    {
                                        $depense->addMediaFromRequest('image')
                                        ->toMediaCollection('fournisseur');
                                    }

                                    //pivot 1
                                    DB::table('depense_projet')->insert(
                                        array(
                                        'depense_id'=> $depense->id,
                                        'projet_id'=>  $request->projet_id,
                                    ));

                                    //pivot 2
                                    DB::table('departement_depense')->insert(
                                        array(
                                        'depense_id' => $depense->id ,
                                        'departement_id' =>  $request->departement_id)
                                    );

                                    //pivot 3
                                    for($i=0;$i<$request->benefit_perso;$i++)
                                    {
                                        DB::table('depense_user')->insert(
                                            array(
                                            'depense_id' => $depense->id ,
                                            'user_id' => Auth::user()->id )  
                                        );
                                    }

                                     //pivot 4
                                    for($i=0;$i<$request->count;$i++)
                                    {
                                        DB::table('compte_depense')->insert(
                                            array(
                                            'depense_id' => $depense->id,
                                            'compte_id' =>  $request->item[$i]['selectedCompteId'],
                                            'date_reglement'=>$request->item[$i]['date_reglement'],
                                            'montant_reglement'=>$request->item[$i]['montant_reglement'],
                                            'note'=>$request->item[$i]['note'],
                                            'compte_libelle'=>$request->item[$i]['selectedCompte']['libelle'],
                                            'created_at'=>Carbon::now()
                                            ));
                                    }


                                    //debiter le compte lors du reglement de la depense
                                    // $compdep =DB::table('compte_depense')->get();
                                    // $compte = Compte::where('entreprise_id',Auth::user()->entreprise_id)
                                    // ->where('delete_update_at',0)
                                    // ->get();
                                    // for ($i=0; $i <count($compte) ; $i++) { 
                                    //     $solde = $compte[$i] ->solde;
                                    //     $compte_id= $compte[$i] ->id;
                            
                                    //     for($i=0;$i<$request->count;$i++) { 
                                    //        $montant  = $request->item[$i]['montant_reglement'];
                                    //        $compteId  = $request->item[$i]['selectedCompteId'];
                            
                                          
                                    //         $debit = $solde - $montant;
                                    //         $update = Compte::whereId($compteId)->update([
                                    //        'solde'=>$debit
                                    //            ]);
                                     
                                    //             }

                                    //         }

                                    $depense = Depense::withSum('comptes','compte_depense.montant_reglement')->get();
                                    $mt=[];
                                    for ($i=0; $i <count($depense) ; $i++) {
                                   
                                        //impayé -- payé
                                        $impaye = $depense[$i]->montant_depense - $depense[$i]->comptes_sum_compte_depensemontant_reglement;
                                        $paye = $depense[$i]->comptes_sum_compte_depensemontant_reglement;
                                      
                                        if ($depense[$i]->montant_depense == $depense[$i]->comptes_sum_compte_depensemontant_reglement) {
                                            $status = Depense::where('id',$depense[$i]->id)->update([
                                                'status'=>'réglé',
                                                'impaye'=> $impaye,
                                                'paye'=> $paye,
                                            ]);
                                           }

                                           if ($depense[$i]->montant_depense !== $depense[$i]->comptes_sum_compte_depensemontant_reglement) {
                                            $status = Depense::where('id',$depense[$i]->id)->update([
                                                'status'=>'partiel',
                                                'impaye'=> $impaye,
                                                'paye'=> $paye,
                                            ]);
                                           }

                                           if ($depense[$i]->comptes_sum_compte_depensemontant_reglement == null) {
                                            $status = Depense::where('id',$depense[$i]->id)->update([
                                                'status'=>'à payer',
                                                   'impaye'=> $impaye,
                                                'paye'=> $paye,
                                            ]);
                                           }

                                        //    //impayé -- payé

                                        //    $impaye = $depense[$i]->montant_depense - $depense[$i]->comptes_sum_compte_depensemontant_reglement;
                                        //     $paye = $depense[$i]->comptes_sum_compte_depensemontant_reglement;
                                            
                                    //    $status = DB::table('compte_depense')->where('depense_id',$id_depense)->sum('montant_reglement');
                                       array_push($mt);
                                    }


                                    // }
                     return response()->json([
                        'message' => 'Depense enregistré avec success',
                    ]);

    }

    
    public function test(Request $request){

        $compdep =DB::table('compte_depense')->get();
        $compte = Compte::where('entreprise_id',Auth::user()->entreprise_id)
        ->where('delete_update_at',0)
        ->get();

        for ($i=0; $i <count($compte) ; $i++) { 
            $solde = $compte[$i] ->solde;
            $compte_id= $compte[$i] ->id;

            for ($i=0; $i < count($compdep); $i++) { 
               $montant  = $compdep[$i]->montant_reglement;
               $compteId  = $compdep[$i]->compte_id;

               if( $compte_id ===$compteId){
                $debit = $solde - $montant;
                $update = Compte::whereId($compteId)->update([
               'solde'=>$debit
                   ]);
            }
                    }
                    
               
              
            }
        return response()->json('compte debité');
    }




    public function dateR(Request $request){

        $date_jour = Carbon::now()->day; 
          $depense_recurrente = Depense::whereEntreprise_id(Auth::user()->entreprise_id)
        ->whereNotNull('date_recurrente')
        ->where('date_recurrente', $date_jour)
        ->with([
            'comptes',
            'media'
        ])->get();

        

      
    

 foreach ($depense_recurrente as $depenseR ) {
     $id = $depenseR->id;
     $data[]  = $id;
     if ($depenseR->date_recurrente==$date_jour) {
        $replique= Depense::find($depenseR->id)->replicate();
        $replique->save();
        $update = Depense::where('date_recurrente', $date_jour)->where('created_at',Carbon::now())->update(['status'=>'à payer']);
         }


    }
    return response()->json($update);

}





    public function storeRecurrente(Request $request)
    {
        //
                        $request->validate([
                            'libelle'=>['required'],
                            // 'type_depense_id'=>['required'],
                            'montant_depense'=>['required','numeric'],
                            // 'fournisseur'=>['required'],
                            'date_emission'=>['required']
                        ]);

                                                //categorisation de depense
                                    $category = Parametre::where('libelle', $request->depense)
                                    ->where('entreprise_id',$request->user()->entreprise_id)->first();

                                    $depense = Depense::Create([
                                        'libelle'=>$request->libelle,
                                        'description'=>$request->description,
                                        'montant_depense'=>$request->montant_depense,
                                        'fournisseur'=>$request->fournisseur,
                                        'type_depense'=>$request->type_depense,
                                        'date_recurrente'=>$request->date_recurrente,
                                        'facture_fournisseur'=>$request->facture_fournisseur,
                                        'date_emission'=>$request->date_emission,
                                        'departement_id'=>$request->departement_id,
                                        'entreprise_id'=>Auth::user()->entreprise_id,
                                        'created_user'=>Auth::user()->id,
                                        'projet_id'=>$request->projet_id,
                                        'departement_id'=>$request->departement_id,
                                        'agence_id'=>$request->agence_id,
                                        'employe_id'=>$request->employe_id,
                                        'status_depense'=>'depense recurrente'

                                    ]);

                                    if($request->file('image'))
                                    {
                                        $depense->addMediaFromRequest('image')
                                        ->toMediaCollection('fournisseur');
                                    }

                                    //pivot 1
                                    DB::table('depense_projet')->insert(
                                        array(
                                        'depense_id'=> $depense->id,
                                        'projet_id'=>  $request->projet_id,
                                    ));

                                    //pivot 2
                                    DB::table('departement_depense')->insert(
                                        array(
                                        'depense_id' => $depense->id ,
                                        'departement_id' =>  $request->departement_id)
                                    );

                                    //pivot 3
                                    for($i=0;$i<$request->benefit_perso;$i++)
                                    {
                                        DB::table('depense_user')->insert(
                                            array(
                                            'depense_id' => $depense->id ,
                                            'user_id' => Auth::user()->id )  //[$i]
                                        );
                                    }

                                     //pivot 4
                                    for($i=0;$i<$request->count;$i++)
                                    {
                                        DB::table('compte_depense')->insert(
                                            array(
                                            'depense_id' => $depense->id,
                                            'compte_id' =>  $request->item[$i]['selectedCompteId'],
                                            'date_reglement'=>$request->item[$i]['date_reglement'],
                                            'montant_reglement'=>$request->item[$i]['montant_reglement'],
                                            'note'=>$request->item[$i]['note'],
                                            'compte_libelle'=>$request->item[$i]['selectedCompte']['libelle'],
                                           'created_at'=>carbon::now(),
                                        ));
                                    }



                                    $depense = Depense::withSum('comptes','compte_depense.montant_reglement')->get();
                                    $mt=[];
                                    for ($i=0; $i <count($depense) ; $i++) {
                                    //    $id_depense=$depense[$i]->id;

                                       if ($depense[$i]->montant_depense == $depense[$i]->comptes_sum_compte_depensemontant_reglement) {
                                            $status = Depense::where('id',$depense[$i]->id)->update(['status'=>'réglé']);
                                           }

                                           if ($depense[$i]->montant_depense !== $depense[$i]->comptes_sum_compte_depensemontant_reglement) {
                                            $status = Depense::where('id',$depense[$i]->id)->update(['status'=>'partiel']);
                                           }

                                           if ($depense[$i]->comptes_sum_compte_depensemontant_reglement == null) {
                                            $status = Depense::where('id',$depense[$i]->id)->update(['status'=>'à payer']);
                                           }

                                    //    $status = DB::table('compte_depense')->where('depense_id',$id_depense)->sum('montant_reglement');
                                       array_push($mt);
                                    }




                  $date_jour = Carbon::now()->day; 
                  $depense_recurrente = Depense::whereEntreprise_id(Auth::user()->entreprise_id)
                ->whereNotNull('date_recurrente')
                ->where('date_recurrente', $date_jour)
                ->with([
                    'comptes',
                    'media'
                ])->get();

                foreach ($depense_recurrente as $depenseR ) {
                  if ($depenseR->date_recurrente==$date_jour) {
             
             return response()->json([$depense_recurrente ]);
                }
                               }


                                    // }
                     return response()->json([
                        'message' => 'Depense enregistré avec success',
                    ]);

    }

    public function storegroupe(Request $request){
        
        $depense = Depense::Create([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'montant_depense'=>$request->montant_depense,
            'date_emission'=>$request->date_emission,
            'status'=>'réglé',
            'status_depense'=>'depense groupe',
            'entreprise_id'=>Auth::user()->entreprise_id,
            'created_user'=>Auth::user()->id,

        ]);

        for($i=0;$i< $request->nombre_article ;$i++ )
        {
            $pivot = DB::table('sous_depenses')->insert(
                array(
                      'prix'  =>$request->items[$i]['prix'],
                      'article'  => $request->items[$i]['itemTitle'],
                       'quantite'  =>$request->items[$i]['qte'],
                        'depense_id'=>$depense->id,
                     'created_at'=> Carbon::now(),
                     'updated_at'=>Carbon::now(),
                )
            );
        }

        for($i=0;$i< $request->nombre_article ;$i++ )
        {
            $pivot = DB::table('compte_depense')->insert(
                array(
                        'depense_id'=>$depense->id,
                        'montant_reglement'=>$depense->montant_depense,
                     'created_at'=> Carbon::now(),
                     'updated_at'=>Carbon::now(),
                )
            );
        }
    }


    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

public function storeReglement(Request $request){


    for($i=0;$i<$request->count;$i++)
    {
        DB::table('compte_depense')->insert(
            array(
            'depense_id' => $request->depense_id,
            'compte_id' =>  $request->item[$i]['selectedCompteId'],
            'date_reglement'=>$request->item[$i]['date_reglement'],
            'montant_reglement'=>$request->item[$i]['montant_reglement'],
            'note'=>$request->item[$i]['note'],
            'compte_libelle'=>$request->item[$i]['selectedCompte']['libelle'],
            'created_at'=> Carbon::now(),
            'updated_at'=>Carbon::now(),
            ));
    }

     


    $depense = Depense::withSum('comptes','compte_depense.montant_reglement')->get();
    $mt=[];
    for ($i=0; $i <count($depense) ; $i++) {
    //    $id_depense=$depense[$i]->id;

    $impaye = $depense[$i]->montant_depense - $depense[$i]->comptes_sum_compte_depensemontant_reglement;
    $paye = $depense[$i]->comptes_sum_compte_depensemontant_reglement;
  
    if ($depense[$i]->montant_depense == $depense[$i]->comptes_sum_compte_depensemontant_reglement) {
        $status = Depense::where('id',$depense[$i]->id)->update([
            'status'=>'réglé',
            'impaye'=> $impaye,
            'paye'=> $paye,
        ]);
       }

       if ($depense[$i]->montant_depense !== $depense[$i]->comptes_sum_compte_depensemontant_reglement) {
        $status = Depense::where('id',$depense[$i]->id)->update([
            'status'=>'partiel',
            'impaye'=> $impaye,
            'paye'=> $paye,
        ]);
       }

       if ($depense[$i]->comptes_sum_compte_depensemontant_reglement == null) {
        $status = Depense::where('id',$depense[$i]->id)->update([
            'status'=>'à payer',
               'impaye'=> $impaye,
            'paye'=> $paye,
        ]);
       }
    //    $status = DB::table('compte_depense')->where('depense_id',$id_depense)->sum('montant_reglement');
       array_push($mt);
    }

     //debiter le compte lors du reglement de la depense
    //  $compdep =DB::table('compte_depense')->get();
    //  $compte = Compte::where('entreprise_id',Auth::user()->entreprise_id)
    //  ->where('delete_update_at',0)
    //  ->get();
    //  for ($i=0; $i <count($compte) ; $i++) { 
    //      $solde = $compte[$i] ->solde;
    //      $compte_id= $compte[$i] ->id;

    //      for($i=0;$i<$request->count;$i++) { 
    //         $montant  = $request->item[$i]['montant_reglement'];
    //         $compteId  = $request->item[$i]['selectedCompteId'];

           
    //         //   if( $compte_id == $compteId){
    //             $debit = $solde - $montant[$i];
    //             $update = Compte::whereId($compteId)->update([
    //            'solde'=>$debit
    //                ]);
    //         // }
      
    //              }

    //          }



    return response()->json('reglement insere avec success');

}


    public function edit($id)
    {
        //
        $edit =  Depense::find($id);


        return response()->json([
            'edit' , $edit ,
            'message' => 'Collecter avec success',
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
              //

              $request->validate([
                'libelle'=>['required'],
                'type_depense_id'=>['required'],
                'montant'=>['required','numeric'],
                'fournisseur'=>['required'],
                'date_emission'=>['required']
            ]);


            $depense = Depense::find($request->id)->update([
                'libelle'=>$request->libelle,
                'description'=>$request->description,
                'montant_depense'=>$request->montant,

                'departement_id'=>$request->departement_id,
                //'entreprise_id'=>Auth::user()->entreprise_id,
                'projet_id'=>$request->projet_id,
                'agence_id'=>$request->agence_id,

                //'type_depense_id'=>$category[0]->id,
                'employe_id'=>$request->employe_id,

            ]);


            //pivot 1
              DB::table('depense_projet')->update(
                array(
                'depense_id'=> $request->id,
                'projet_id'=>  $request->projet_id,
              ));

             //pivot 2
            DB::table('departement_depense')->update(
                array(
                 'depense_id' => $request->id ,
                 'departement_id' =>  $request->departement_id)
            );

             //pivot 3
            for($i=0;$i<$request->benefit_perso;$i++)
            {
                DB::table('depense_user')->update(
                    array(
                     'depense_id' => $request->id[$i] ,
                     'user_id' =>     Auth::user()->id  //$request->user_id[$i]  //[$i]
                ));
            }


              //pivot 4
              for($i=0;$i<$request->count;$i++)
              {
                  DB::table('compte_depense')->update(
                      array(
                      'depense_id' => $request->id[$i],
                      'compte_id' =>  $request->compte_id[$i],
                      'depense_id'=>$request->depense_id[$i],
                      'compte_id'=>$request->compte_id[$i],
                      'date_reglement'=>$request->date_reglement[$i],
                      'montant_reglement'=>$request->montant_reglement[$i],
                      'note'=>$request->note,
                      ));
              }


            return response()->json([
                // 'entreprise_id'=>$auth,
                'message' => 'Depense modiée avec success',
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
        $depense=Depense::find($request->id)->delete();
        $dep = DB::table('compte_depense')->where('depense_id',$request->id)->delete();
        return response()->json([
            'message' => 'Depense supprimé avec success',
        ]);
    }
}
