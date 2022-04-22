<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Module;
use App\Models\User;
use App\Models\Entreprise;
use App\Models\Abonnement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;




class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
           //les permissions
        //    $this->middleware('permission:index-module', ['only' => ['index']]);  //  
        // //    $this->middleware('permission:show-module', ['only' => ['index']]);
        // //    $this->middleware('permission:create-module', ['only' => ['store']]);
        // //    $this->middleware('permission:update-module', ['only' => ['update']]);
        // //    $this->middleware('permission:delete-module', ['only' => ['destroy']]);

        //     //les roles
        //    $this->middleware('role:admin', ['only' => ['store','index','update','destroy']]);
        //    $this->middleware('role:developpeur', ['only' => ['store','index','update','destroy']]);
        //    $this->middleware('role:superadmin', ['only' => ['store','index','update','destroy']]);
    }

   

    public function index()
    {
        // get logged-in user
        $user = auth()->user();

        // get all inherited permissions for that user
        $permissions = $user->getAllPermissions();

        $module_et_permission = Module::with('permissions')
                                        ->select('id','libelle','description','montant','created_at')
                                        ->whereNull('entreprise_id')
                                        ->get();




        //
        // $auth = Auth::user()->entreprise_id;
        // $modules = Module::all();
        $module_entreprise = DB::table('entreprise_module')->where('entreprise_id', Auth::user()->entreprise_id)->latest()->first();
        // $entreprise = DB::table('modules')->where('id',$module_entreprise[0]->entreprise_id)->get();

        activity()
            //->performedOn($web)
            ->log('Module-Index')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

        return response()->json([
            //  'entreprise' => $entreprise,
            "module_et_permission"=>$module_et_permission,
            'permissions' => $permissions,
            //'auth' => $auth,
            // 'module' => $modules,
            //'abonnement' => $abonnement,
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
        $modules = Module::all();

        activity()
            //->performedOn($web)
            ->log('Module-Form-Create')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

        return response()->json([
            'auth' => $auth,
            'module' => $modules,
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
        //NB: Lors de la creation des Modules , les permissions seront attachees aux modules
        $request->validate([
            'libelle' => ['required'],
            'description' => ['required'],
            'montant' => ['required'],
        ]);

        $module = Module::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant' => $request->montant,
        ]);

        //assign permission to modules
        if($request->permissions != null)
        {
            $module->syncPermissions($request->permissions);
        }else{
            return response()->json([
                'message' => 'Veillez attribuer des permissions a ce Module',
            ]);

        }


        //assign permission to modules avec ta pivot creer(a supprimer bientot)
            // if(count($request->permission_id) != null)
            // {
            //     for($i=0;$i<$request->permission_number;$i++)
            //     {
            //         DB::table('module_permissions')->insert([
            //             'module_id' => $module->id,
            //             'permission_id'=> $request->permission_id[$i],
            //         ]);
            //     }


            // }else{
            //     return response()->json([
            //         'message' => 'Veillez attribuer des permissions a ce Module',
            //     ]);

        // }




        // $module->givePermissionTo('create-facture');





        //  $abonnement_ref = Abonnement::where('entreprise_id',Auth::user()->entreprise_id)->first();

        // $pivot = DB::table('abonnement_module')->insert(
        //     array(
        //         'abonnement_id' =>$abonnement_ref->id,
        //         'module_id'  =>$module->id,
        //         'created_at'=> Carbon::now(),
        //         'updated_at'=>Carbon::now(),
        //     )
        // );



        // $pivot1 = DB::table('entreprise_module')->insert(
        //     array(
        //         'entreprise_id' =>Auth::user()->entreprise_id,
        //         'module_id'  =>$module->id,
        //         'created_at'=> Carbon::now(),
        //         'updated_at'=>Carbon::now(),
        //     )
        // );

        activity()
            //->performedOn($web)
            ->log('Module-Store')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

        return response()->json([
            'module_id' => $module->id,
            //'pivot'=> $pivot,
            'message' => 'Module enregistrer avec success',
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
        $edit =  Module::find($id);

        activity()
            //->performedOn($web)
            ->log('Module-Form-Edit')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

        return response()->json([
            'edit' =>  $edit,
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
            'description' => ['required'],
            'montant' => ['required'],
            'permissions'=>['required']
        ]);



        $module = Module::find($request->id)->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'montant' => $request->montant,
        ]);



         //assign permission to modules
         $module =Module::find($request->id);
         if($request->permissions != null)
         {
             $module->syncPermissions($request->permissions);
         }else{
             return response()->json([
                 'message' => 'Veillez attribuer des permissions a ce Module',
             ]);

         }


        activity()
            //->performedOn($web)
            ->log('Module-Update')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Module Modifié avec success',
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
        $module = Module::find($id)->delete();

        activity()
            //->performedOn($web)
            ->log('Module-Destroy')
            // ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Module Supprimé avec success',
        ]);
    }



    public function achatModule(Request $request)
    {


        //redirigé sur le portail de paiement avant de realiser l'operation

        $request->validate([
            'module_libelle' => ['required'],
            //'description' => ['required'],
            //'montant' => ['required'],
        ]);

        $module_recherche = Module::where('libelle', $request->module_libelle)->first();

        //creation du module achet2
        if($module_recherche != null)
        {
            $module = Module::create([
                'libelle' => $request->module_libelle,
                'description' => $module_recherche->description,
                'montant' => $module_recherche->montant,
                'entreprise_id'=>Auth::user()->entreprise_id,
                'created_user' => Auth::user()->id,
            ]);
        }else{
            return response()->json([
                'message'=> "ce module n'existe pa",
            ]);
        }



            //donner permissions aux modules (model_has_permissions)
            $module->syncPermissions(
            'create-facture','edit-facture','index-facture','create-facture','create-facture',//1 facturation
           //  'create-devis','edit-devis','index-devis','create-devis','create-devis',//1
           // 'create-client','edit-client','index-client','create-client','create-client',//2 CRM
           //   'create-creancier','edit-creancier','index-creancier','create-creancier','create-creancier',//2
           //   'create-founisseur','edit-fournisseur','index-fournisseur','create-fournisseur','create-fournisseur',//2
           //  'create-catalogue','edit-catalogue','index-catalogue','create-catalogue','create-catalogue',// 3
           //  'create-tresorerie','edit-tresorerie','index-tresorerie','create-tresorerie','create-tresorerie',//4 tresorerie
             );


               // dernier abonnement
         $abonnement_ref = Abonnement::where('entreprise_id', Auth::user()->entreprise_id)->orderBy('id', 'desc')->first();


        // Remplissage de la table pivot
        $pivot = DB::table('abonnement_module')->insert(
            array(
                'abonnement_id' => $abonnement_ref->id,
                'module_id'  => $module->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'date_debut' => Carbon::now(),
                'date_buttoire' => Carbon::now()->addMonth(12),
                 )
        );



        // Remplissage de la table pivot
        $pivot1 = DB::table('entreprise_module')->insert(
            array(
                'entreprise_id' => Auth::user()->entreprise_id,
                'module_id'  => $module->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            )
        );



        $user = Entreprise::where('id', Auth::user()->entreprise_id)->where('created_user', Auth::user()->id)->select('created_user')->get();

        $user = User::find($user[0]->created_user);   // returns an instance of \App\User ==> le 1er gestionnaire de l'entreprise

        //Collecter toutes les permissions du module achet2
        $all_module_permissions = $module->getAllPermissions();
        //all user having role gestionnaire
        $users = User::role('gestionnaire')->where('entreprise_id',Auth::user()->entreprise_id)->get(); //

        if(count($all_module_permissions) != null)
        {
           for($i=0;$i<count($all_module_permissions);$i++)
           {
               $module_permission_array[$i] = $all_module_permissions[$i]->name;
               for($j=0;$j<count($users);$j++)
               {
                $role1[$j] = $users[$j]->syncPermissions($module_permission_array);//attributions de toutes les permissions aux
               }
           }

           //$role = $user->syncPermissions($module_permission_array);//attributions de toutes les permissions aux

          return response()->json([
            'message'=> $abonnement_ref,
            'module_id'  => $module->id,
            'pivot'=> $pivot,
            'pivot11'=> $pivot1,
            'all_module_permissions_result'=>$all_module_permissions[0]->id,
            "cest zooooooooo"=> $role1,
           ]);

        }else{
            return response()->json([
                "cest zooooooooo"=> "il n'existe pas de perrmisssion rattaach2 a ce module",
               ]);
        }








         //END ATTRIBUTION DES PERMISSION DE BASE AU GESTIONNAIRE
         activity()
         //->performedOn($web)
         ->log('achatModule-Store')
         // ->causedBy(Auth::user()->id)
         ->subject(2)
         ->withProperties(['test' => 'value']);


        return response()->json([
            //"ss"=>$s,
            //'mes_id'=>$bbbbn,
            //'test'=>$all_users_with_all_their_roles[0]->roles[0]->name,
            //'all_roles_a_and_b'=>$all_users_with_all_their_roles,
            //'user'=>$user->id,
            //'abonnement_ref'=>$module->id,
            //'pivot'=> $pivot,
            'message' => 'Achat de Module effectué avec success',
        ]);
    }
}





//Achat de module

    //   //assigner les permissions selon les module choisis
    //   if ($request->module_libelle == 'factura') {
    //     //assigner toutes les permissions a gestionnaire
    //    // $role = $user->givePermissionTo(['create-facture', 'index-facture', 'show-facture', 'delete-facture']);
    //    $role = $user->givePermissionTo($nos_permissions);//attributions de toutes les permissions aux
    // } elseif ($request->module_libelle == 'Tresorerie') {
    //     //assigner toutes les permissions a gestionnaire
    //     $role = $user->givePermissionTo([
    //         'create-compte', 'index-compte', 'show-compte', 'delete-compte',
    //         'create-versement', 'index-versement', 'show-versement', 'delete-versement',
    //         'create-depense', 'index-depense', 'show-depense', 'delete-depense',
    //         'create-emprunt', 'index-emprunt', 'show-emprunt', 'delete-emprunt',
    //     ]);
    //     $role = $user->givePermissionTo(['create-creancier']);
    // } elseif ($request->module_libelle == 'Prevision') {
    //     //assigner toutes les permissions a gestionnaire
    //     $role = $user->givePermissionTo($request->role);
    // } elseif ($request->module_libelle == 'Gestion de stocks') {
    //     //assigner toutes les permissions a gestionnaire
    //     $role = $user->givePermissionTo('create-creancier');
    // } else {
    //     return response()->json([
    //         'message' => 'Veuillez choisir un abonnement avant de continuer',
    //     ]);
    // }




    // //ATTRIBUTION DES PERMISSION DE BASE AUX Utilisateurs
    // $all_users_with_all_their_roles = User::with('roles')->where('entreprise_id', Auth::user()->entreprise_id)->get();

    // for ($i = 0; $i < count($all_users_with_all_their_roles); $i++) {
    //     if (
    //         $all_users_with_all_their_roles[$i]->roles[0]->name == 'gestionnaire' ||
    //         $all_users_with_all_their_roles[$i]->roles[0]->name == 'manager'
    //     ) {
    //         $s[$i] = $all_users_with_all_their_roles[$i]->roles[0];
    //         $user = User::find($all_users_with_all_their_roles[$i]->id);

    //         $role = $user->givePermissionTo([
    //             'create-compte', 'index-compte', 'show-compte', 'delete-compte',
    //          //   'create-versement', 'index-versement', 'show-versement', 'delete-versement',
    //             'create-depense', 'index-depense', 'show-depense', 'delete-depense',
    //           //  'create-emprunt', 'index-emprunt', 'show-emprunt', 'delete-emprunt',
    //         ]);
    //         $bbbbn[$i] = $all_users_with_all_their_roles[$i]->id;
    //     }
    // }
//Achat de module
