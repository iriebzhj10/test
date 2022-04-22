<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Depense;
use App\Models\Abonnement;
use App\Models\Entreprise;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Sanctum\Sanctum;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\BaseAuthControlleur;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */

    //createUser

    function __construct()
    {
        // $this->middleware('permission:create-employee', ['only' => ['createUser']]);
        //$this->middleware('permission:update-employee', ['only' => ['updateUser']]);

       //$this->middleware('role:gestionnaire', ['only' => ['createUser']]);
        //  $this->middleware('role:gestionnaire', ['only' => ['createUser']]);

        //  $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        //  $this->middleware('permission:product-delete', ['only' => ['destroy']]);

        //$this->middleware('role:employee', ['only' => ['store']]);nn
    }

    public function index()
    {
        //
        $user = DB::table('users')
            ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
            ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
            ->where('entreprises.id', Auth::user()->entreprise_id) //Auth::user()->entreprise_id $request->entreprise_id
            ->whereIn('status_user', ['employee','gestionnaire'])
             ->where('delete_update_at',0)
            ->whereNull('users.deleted_at') //not deleted
            ->select('users.*')
            ->distinct()
            ->get();

        $all_roles_in_database = Role::all()->pluck('name');

        $all_roles_except_a_and_b = Role::whereIn('name', ['employee', 'gestionnaire', 'manager'])->get();

        return response()->json([
            // $auth,
            'listeRole' => $all_roles_except_a_and_b,
            // $all_roles_in_database,
            'listeEmploye' => $user,
        ]);
    }

    public function index1()
    {
        // 'status_user'=>'client',


        $client = DB::table('users')
            ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
            ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
            ->where('entreprises.id', Auth::user()->entreprise_id) //Auth::user()->entreprise_id $request->entreprise_id
            ->where('users.status_user', 'client')
            ->select('users.*')
            ->get();

        $employees = DB::table('users')
            ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
            ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
            ->where('entreprises.id', Auth::user()->entreprise_id) //Auth::user()->entreprise_id $request->entreprise_id
            ->where('users.status_user', 'employee')
            ->select('users.*')
            ->get();




        // $user = DB::table('users')
        // ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
        // ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        // ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        // ->select('users.*',)
        // ->get();

        // $all_roles_in_database = Role::all()->pluck('name');

        // $all_roles_except_a_and_b = Role::whereIn('name', ['employee', 'gestionnaire','manager'])->get();

        return response()->json([
            // $auth,
            'client' => $client,
            'employe' =>$employees
            //    'listeRole'=> $all_roles_except_a_and_b,
            //   // $all_roles_in_database,
            //     'listeEmploye'=> $user
        ]);
    }

    public function checktokens(Request $request)
    {
        $valid = auth('sanctum')->check();

        return response()->json([ 'valid'=>$valid ]);
    }


    // fonction qui  ramenent les informations d'un utilisateur

    public function checkPass(Request $request){
        $password = $request->password;
        $email = $request->email;
        $user = User::where('email', $email)->first();
        $pivot =  DB::table('entreprise_user')->where('user_id',$user->id)->get();
        $entreprises = array();
        $inter = [];
        for($i=0; $i<count($pivot); $i++){
            $en = Entreprise::where('id',$pivot[$i]->entreprise_id)->with('media')->get();
            // $en->immatricule = $en[0]->getFirstMediaUrl('image');
            array_push($entreprises, $en);
        }
        for($i=0; $i<count($entreprises); $i++){
            array_push($inter,[
                "id" => $entreprises[$i][0]->id,
                "code" => $entreprises[$i][0]->code,
                "libelle" => $entreprises[$i][0]->libelle,
                "email" => $entreprises[$i][0]->email,
                'image' => $entreprises[$i][0]->getFirstMediaUrl('image')
            ]);
        }
        $entreprises = $inter;
        if(Hash::check($password, $user->password)){
            return response()->json([
                'entreprises' => $entreprises ,
                'ok' => 'Mot de passe correcte',
            ]);
        }else{
            return response()->json([
                'error' => 'Mot de passe incorrecte',
            ]);
        }
    }

    public function index2(Request $request)
    {
        /**********************************************************************/
        //listes des 4 desrnieres sessions 
        /**********************************************************************/
      

        /***********************************************************************/







        $user_connecte = Auth::user();
        //$user = Auth::user()->id;  last_activity
       // $now = strtotime(Carbon::now()->subMinutes(5));
       //return response()->json([ $user_connecte ]);
            //$session = DB::select('select DISTINCT(payload),id,user_id,ip_address,user_agent, last_activity from sessions where user_id = ? and tokens is not null  limit 4', [$user_connecte->id]);
       // $active = DB::select('select DISTINCT(payload),user_id,ip_address,user_agent from sessions where user_id = ?  and last_activity > ?', [$user_connecte->id,$now]);
        //$active =  DB::table('activity_log')->whereCauser_type('App\Models\User')->whereCauser_id(Auth::user()->id)->get();
        //= DB::table('sessions')->distinct('payload')->take(4)->orderBy('id','DESC')->get();
       $macadress = $macAddr = substr(shell_exec('getmac'), 159,20);
       $connected =   DB::select('select * from sessions where user_id = ? and payload = ? and tokens is not null limit 1', [$user_connecte->id,$macadress]);;

        // $user_connecte = Auth::user();

        if(isset($request->id)){
            $id = intval($request->id);
        }else{
            $id = Auth::user()->id;
        }

        // $user_role = Auth::user()->role;
        // $all_users_with_all_their_roles = User::with('roles')->get();
        $user_role = User::with('roles')
                    ->where('entreprise_id',Auth::user()->entreprise_id)
                    ->where('id',Auth::user()->id)
                    ->get();

         $user_role = $user_role[0]->roles[0];


        //  $role = Role::orderBy('name','ASC')
        //         ->get();



        $role = Role::where('name', "gestionnaire")->orWhere('name', "employee")
        ->get();

           //Récupération des tailles de personnel
        //    $taille= TypeParametre::where('libelle',"Taille de l'entreprise")
        //    ->first();
        //    $id_taille=$taille->id;
        //    $tailles= Parametre::where("type_parametre_id",$id_taille)
        //    ->get();


        $user_connecte = DB::table('users')->where('id','=', $id)->get();
        //SELECT * FROM `activity_log` WHERE `causer_type` LIKE '%USERS%' AND `causer_id`=1
        $historique1 =  DB::table('activity_log')
                                    ->where('causer_id',$id)
                                    ->where('causer_type','=',  'App\Models\User')
                                    ->whereNotNull('causer_type')
                                    ->whereNotNull('subject_type')
                                    ->orderBy('id','DESC')
                                    ->take(10)
                                    ->get();
                                    //'App\Models\User'

                            // $session = DB::table('sessions')
                            //                    // ->where('user_id',$id)
                            //                     ->where('user_id','=',  Auth::user()->id ) // Auth::user()->id
                            //                     ->distinct('user_agent')
                            //                     ->orderBy('id','DESC')
                            //                     ->take(10)
                            //                     ->get();

                            $session = DB::table('sessions')->groupBy('user_agent')
                            // ->where('user_id',$id)
                             ->where('user_id','=',  Auth::user()->id ) // Auth::user()->id
                             ->distinct('user_agent')
                             ->orderBy('id','DESC')
                             ->take(10)
                             ->get();
                      
                             $count = DB::table('sessions')
                              ->where('user_id','=',  Auth::user()->id ) // Auth::user()->id
                              ->distinct('user_agent')
                              ->orderBy('id','DESC')
                              ->count();

        $infoEntreprise = DB::table('users')
        ->join('entreprise_user' , 'users.id', '=', 'entreprise_user.user_id')
        ->join('entreprises' , 'entreprises.id', '=' ,'entreprise_user.entreprise_id')
        ->where('users.entreprise_id', Auth::user()->entreprise_id)
        // ->select('users.*' , '')
        ->first();

     

        //Get subject
        $inter=array();
        for($i=0; $i<count($historique1); $i++){


            $model = str_replace('App\\Models\\','',$historique1[$i]->subject_type);
            $model = strtolower($model.'s');
            $subject =null;
            if ($model != 'abonnemententreprises') {
                 $subject_id = $historique1[$i]->subject_id;
            $subject = DB::table($model)->where('id','=',$subject_id)->get();
            $historique1[$i]->sj = $subject;
            }
          

         


              //type appareil debut
              $user_agent[$i] = $historique1[$i]->properties;

              //return response()->json([ $historique1 ]);

              $bname[$i] = 'Unknown';
              $platform[$i] = 'Unknown';    //First get the platform?

              if (preg_match('/linux/i', $user_agent[$i])) {
                  $platform[$i] = 'linux';
              }
              elseif (preg_match('/macintosh|mac os x/i', $user_agent[$i])) {
                  $platform[$i] = 'mac';
              }
              elseif (preg_match('/windows|win32/i', $user_agent[$i])) {
                  $platform[$i] = 'windows';
              }

              // Next get the name of the useragent yes seperately and for good reason
              if(preg_match('/MSIE/i',$user_agent[$i]) && !preg_match('/Opera/i',$user_agent[$i]))
              {
                  $bname[$i] = 'Internet Explorer';
                  $ub[$i] = "MSIE";
              }
              elseif(preg_match('/Firefox/i',$user_agent[$i]))
              {
                  $bname[$i] = 'Mozilla Firefox';
                  $ub[$i] = "Firefox";
              }
              elseif(preg_match('/Chrome/i',$user_agent[$i]))
              {
                  $bname[$i] = 'Google Chrome';
                  $ub[$i] = "Chrome";
              }
              elseif(preg_match('/Safari/i',$user_agent[$i]))
              {
                  $bname[$i] = 'Apple Safari';
                  $ub[$i] = "Safari";
              }
              elseif(preg_match('/Opera/i',$user_agent[$i]))
              {
                  $bname[$i] = 'Opera';
                  $ub[$i] = "Opera";
              }
              elseif(preg_match('/Netscape/i',$user_agent[$i]))
              {
                  $bname[$i] = 'Netscape';
                  $ub[$i] = "Netscape";
              }
           

             // return array($bname,$platform);

             //check if user is already logging on another device
             if(Auth::check()){
                $login_decive_number = Auth::check();
             }

            $pass= [
                'id' => $historique1[$i]->id,
                'description' => $historique1[$i]->description,
                'subject_type' => $historique1[$i]->subject_type,
                'subject_id' => $historique1[$i]->subject_id,
                'causer_type' => $historique1[$i]->causer_type,
                'causer_id' => $historique1[$i]->causer_id,
                'created_at' => $historique1[$i]->created_at,
                'subject' => $subject,
                'platform'=> $platform[$i],
                'bname'=>$bname[$i],
                'login_decive_number' => $login_decive_number,
            ];
            array_push($inter,$pass);


        }

        
        $historique = $inter;

         return response()->json([
            'utilisateur'=>$user_connecte,
            'entreprise'=>$infoEntreprise,
            'historique'=>$historique,
            'roles'=>$role,
            'role'=>$user_role,
            'session'=>$session, //position 5
            'count'=>$count,
          //  'appareril_info'=>$appareril_info,
            //$session,
            // $now,
            // $active,
            //$user_connecte[0]->id,


            // $user_role,
            // $request->bearerToken(),
            $request->session()->all(),
            'session_connected'=>$connected , // important
        ]);
    }










    public function user_info()
    {
        //
        $user_info = User::select('contact', 'email')
        ->where('entreprise_id',Auth::user()->entreprise_id)
        -> get();
        return response()->json([$user_info]);
    }

    public function user_createur()
    {
        //
        $user_connecte = Auth::user();
        $user_createur = Entreprise::where('id', $user_connecte->entreprise_id)
            ->select('created_user')
            ->first();
        $info_user_createur = User::where('id', $user_createur->created_user)->get();
        return response()->json([
            $info_user_createur,
            // $info_user_createur,
            // $user_entreprise
        ]);
    }

    public function user_connecte()
    {
        //

        $entreprise_code = Entreprise::latest()->select('code')->first();



        $user_connecte = Auth::user();

        $user = User::find(Auth::user()->id);
        $user_role = $user->getRoleNames()->first();
        $code_entreprise = Entreprise::where('id',Auth::user()->entreprise_id)->first();

        $response = [
            'user_connecte' => $user_connecte,
            "user_role" => $user_role,
            "entreprise_code"=>$code_entreprise->code,
            // $info_user_createur,
            // $user_entreprise
        ];

        return response()->json([$response]);
    }

    public function createUser(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'indicateur' => ['required'],
            'contact' => ['required', 'string', 'max:255'],
            // 'localisation' => ['required'],
            'password' => ['required', 'min:8'],

            //'password' => ['required'],
        ]);

        //verifier si le mail exist en temps qu'utilisateur de lentreprise

        $check_mail = User::where('entreprise_id', Auth::user()->entreprise_id)
            ->where('email', $request->email)
            ->first();

        if ($check_mail != null) {
            return response()->json([
                // 'check_mail'=>$check_mail,
                'message' => "ce email est deja utilisé par un employé de l'entreprise ",
            ]);
        }

        $abonnement = DB::table('abonnements')
            ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
            ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
            ->where('entreprises.id', Auth::user()->entreprise_id) //Auth::user()->entreprise_id $request->entreprise_id
            ->select('abonnements.*','abonnement_entreprise.date_final')
            ->get();

        $nombre_user = User::where('entreprise_id', Auth::user()->entreprise_id)->count(); //Auth::user()->entreprise_id //  $abonnement[0]->nbr_abonnes

        // return response()->json([ $abonnement]);

        if ($abonnement != null && $abonnement[0]->date_final >= Carbon::now() && $nombre_user <= 14 && $abonnement[0]->libelle == 'gratuit') {
            $password = 'Users';



            $user = User::create([
                'nom' => $data['nom'],
                'prenoms' => $request['prenoms'],
                'email' => $data['email'],
                'contact' => $data['contact'],
                'indicateur' => $data['indicateur'],
                'localisation' => $request['localisation'],
                'status_user' => 'employee',
                'password' => Hash::make($request->password),
                'entreprise_id' => Auth::user()->entreprise_id,
                //'password'=> $request->password,
            ]);

            // Creation de pivot
            DB::table('entreprise_user')->insert([
                'entreprise_id' => Auth::user()->entreprise_id, //retirer pour test avec postman
                'user_id' => $user->id,
            ]);

            if ($request->role != null) {
                $role = $user->assignRole($request->role);
            } else {
                $role = $user->assignRole('employee');
            }

            $response = [Auth::user()->id, 'user_role' => $role, 'user' => $user, 'message' => 'utilisateur creer avec succes'];
            return response($response, 201);
        } elseif ($abonnement != null && $abonnement[0]->date_final >= Carbon::now() && $nombre_user <= 15 && $abonnement[0]->libelle != 'gratuit') {
            $password = 'Users';

            $user = User::create([
                'nom' => $data['nom'],
                'prenoms' => $request['prenoms'],
                'email' => $data['email'],
                'contact' => $data['contact'],
                'indicateur' => $data['indicateur'],
                'localisation' => $request['localisation'],
                'status_user' => 'employee',
                'password' => Hash::make($request->password),
                'entreprise_id' => Auth::user()->entreprise_id,
            ]);

            // Creation de pivot
            DB::table('entreprise_user')->insert([
                'entreprise_id' => Auth::user()->entreprise_id, //retirer pour test avec postman
                'user_id' => $user->id,
            ]);

            $role = $user->assignRole('employee');

            $response = [
                'user_role' => $role,
                'user' => $user,
                'message' => 'utilisateur creer avec succes',
            ];
            return response($response, 201);
        } else {
            $response = [
                'message' => "veillez verifier le nombre d'utilisateur  ou renouvelez votre abonnement 15",
            ];
            return response($response, 201);
        }

        $response = [
            'message' => "echec",
        ];
        return response($response, 201);
    }

    public function updateUser(Request $request)
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'indicateur' => ['required'],
            'contact' => ['required', 'string', 'max:255'],
            // 'password' => ['required'],
            'role' => ['required'],
            'localisation' => ['required'],
            // 'password' => ['required'],
        ]);

        $abonnement = DB::table('abonnements')
        ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
        ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        ->select('abonnements.*',)
        ->get();




        // && $abonnement[0]->date_buttoire >= Carbon::now()   && $abonnement[0]->nbr_abonnes = 8
        // && $abonnement[0]->date_buttoire >= Carbon::now() && $abonnement[0]->nbr_abonnes = 15
            if($abonnement != null  )
            {
               // $password = 'Users';
               $abonnement = DB::table('abonnements')
            ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
            ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
            ->where('entreprises.id', Auth::user()->entreprise_id) //Auth::user()->entreprise_id $request->entreprise_id
            ->select('abonnements.*')
            ->get();

        // && $abonnement[0]->date_buttoire >= Carbon::now()   && $abonnement[0]->nbr_abonnes = 8
        // && $abonnement[0]->date_buttoire >= Carbon::now() && $abonnement[0]->nbr_abonnes = 15
        if ($abonnement != null) {
            // $password = 'Users';

            $user = User::find($request->id)->update([
                'nom' => $data['nom'],
                'prenoms' => $request['prenoms'],
                'email' => $data['email'],
                'contact' => $data['contact'],
                'indicateur' => $data['indicateur'],
                'localisation' => $request['localisation'],
                // 'password' => Hash::make($request->password),
            ]);

            $user1 = User::find($request->id);

            //pivot
            $user1->entreprises()->attach(Auth::user()->entreprise_id);

            //Role and permission
            $users_connect = User::where('id', $request->id)->first();

            if ($request->role != null) {
                $role = $users_connect->syncRoles([$request->role]); //removeRole('employee');
                // $role1=$users_connect->assignRole($request->role);
            }
            //  else{
            //     $role='pas ete modifie';
            //  }

            // $users = User::role('gestionnaire')->get();
            // $users = User::with('roles')->where('id',$request->user_id)->get();

            $response = [
                'id' => Auth::user()->id,
                'role' => $role,
                'user' => $user,
                'message' => 'utilisateur creer avec succes',
            ];

            return response($response, 201);
        }

        $response = [
            'message' => "echec",
        ];
        return response($response, 201);
    }
    }

        // public function edit($id)
        // {
        //     $student = Student::find($id);
        //     return view('student.edit', compact('student'));
        // }

    public function updateUsers(Request $request)
    {

        $data = $request->validate([
            'nom' => 'required',
            'prenoms'=>'required',
            'sexe' =>'required',
            'indicateur' =>'required',
            'contact' =>'required',
            'profession' =>'required',
            'localisation' =>'required',
            // 'date_naissance' =>'required',
            // 'date_embauche' =>'required',
        ]);


        User::find($request->user_id)->update([
            'nom' => $data['nom'],
            'prenoms' => $data['prenoms'],
            'sexe' => $data['sexe'],
            'indicateur' => $data['indicateur'],
            'contact' => $data['contact'],
            'profession' => $data['profession'],
            'localisation' => $data['localisation'],
            'date_naissance' => $request->date_embauche,
            'date_embauche' => $request->date_embauche,
        ]);

        $user = User::whereId($request->user_id)->first();

        $test= $user->syncRoles([$request->role]);




        $response=[
            // $test,
            // $request->user_id,
            // $user,
            // 'users_update'=>$users_update,
            'message'=>'Modifié avec succes',
        ];

        return response($response,201);




        // dd($request->all());
        // return back()->with('message','Modifier');
    }


    public function UrgenceUser(Request $request)
    {
        $request->validate([
            // 'full_name_Urgence' => 'required',
            // 'contact_1' => 'required',
            // 'contact2' => 'required',
            // 'localisation' => 'required',
        ]);

        user::find($request->id)->update([
            'full_name_urgence' => $request->full_name_urgence,
            // 'prenom_urgence' => $request->prenom_urgence,
            'contact_1' => $request->contact_1,
            'contact_2' => $request->contact_2,
            'relation' => $request->relation,
            'localisation_urgence' => $request->localisation_urgence,
            // 'status_user'=>'urgence',
        ]);


        $response=[
            'message'=>'Modifié avec succes',
        ];

        return response($response,201);
    }




    public function paiemmentEmploye()
    {
        // Auth::user()->entreprise_id);

        $entreprise_id = Auth::user()->entreprise_id;
        $paiemment = Depense::whereIn('type_depense',['salaire', 'prime', 'employe'])
        ->where('entreprise_id',$entreprise_id)->get()
        ;


       return response()->json([
        $paiemment,
        $entreprise_id,
        'Collecter avec success',
    ],200 );
    }




    public function updateEntreprise(Request $request)
    {

        $request->validate([
            'libelle' => 'required',
            'created_at'=>'required',
            // 'adresse' =>['required'],
            // 'indicateur' =>'required',
            'contact' =>'required',
            'localisation' =>'required',
            // 'email' =>'required',
            // 'site_internet' =>'required',
            // 'description' =>'required',
        ]);

        Entreprise::find($request->id)->update([
            'libelle' => $request->libelle,
            'created_at' => $request->created_at,
            'adresse' => $request->adresse,
            'indicateur' => $request->indicateur,
            'contact' => $request->contact,
            // 'adresse' => $request->adresse,
            'localisation' => $request->localisation,
            'email' => $request->email,
            'site_internet' => $request->site_internet,

            // 'description' => $data['description'],
        ]);


        $response=[
            'message'=>'Modifié avec succes',
        ];

        return response($response,201);
    }










    public function updateEmployeProfil(Request $request)
    {

        // $request->validate([
            // 'localisation' => 'required',
        //     // 'created_at'=>'required',
        //     // // 'adresse' =>['required'],
        //     // 'indicateur' =>'required',
        //     // 'contact' =>'required',
        //     // 'localisation' =>'required',
        //     // 'email' =>'required',
        //     // // 'site_internet' =>'required',
        //     // // 'description' =>'required',
        // ]);

        User::find($request->id)->update([
            // 'localisation' => $request->localisation,
            'nombre_enfant' => $request->nombre_enfant,
            'situation_matrimoniale' => $request->situation_matrimoniale,
            'email' => $request->email,
            'date_naissance' => $request->date_naissance,
            'sexe' => $request->sexe,
        ]);


        $response=[
            'message'=>'Modifié avec succes',
        ];

        return response($response,201);
    }


    function UpdatePaiemmentEmploye(Request $request)
    {

        User::find($request->id)->update([
            'salaire' => $request->salaire,
            'n_assurance' => $request->n_assurance,
            'mode_paiemment' => $request->mode_paiemment,
        ]);

        $response=[
            'message'=>'Modifié avec succes',
        ];

        return response($response,201);
    }


    function UpdateEmploi(Request $request)
    {

        User::find($request->id)->update([
            'etat' => $request->etat,
            'date_embauche' => $request->date_embauche,
            'lieu_travail' => $request->lieu_travail,
            'departement' => $request->departement,
            'profession' => $request->profession,
        ]);

        $response=[
            'message'=>'Modifié avec succes',
        ];

        return response($response,201);
    }







    public function updatePresentation(Request $request){
        $data = $request->validate([
            'description' =>'required',
        ]);

        Entreprise::find($request->id)->update([
            'description' => $data['description'],
        ]);

        $response=[
            'message'=>'Modifié avec succes',
        ];

        return response($response,201);

    }


    public function register(Request $request)
    {
        //
        //$basecontroller = new BaseAuthControlleur ;

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required'],
            'indicateur' => ['required'],
            'contact' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ]);

        $user_exist = User::where('email', $request->email)->where('type_user','gestionnaire')->first(); //Auth::user()

        if(!$user_exist){
            $user = User::firstOrCreate([
                'nom' => $data['nom'],
                'prenoms' => $request['prenoms'],
                //'username' => $request['username'],
                'email' => $data['email'],
                'contact' => $data['contact'],
                'indicateur' => $data['indicateur'],
                'password' => Hash::make($data['password']),
                'status_user'=>'gestionnaire',
                'type_user'=>'gestionnaire',
                'localisation' => $request->localisation ,
            ]);

            Mail::send('email', compact('user'),function ($message)use($user) {
                $message->from('no-reply@ediqia.com','ediqia');
                $message->to('developpeur@ediqia.com');
                $message->replyTo($user->email);
                $message->subject('Nouvel utilisateur');
               
            });
        }else{
            return response()->json([
                'present' => "ce mail est déja utilisé c'est termine" ]);
        }


        $role=$user->assignRole('Gestionnaire');  //assigniPng role


      /* STORE SESSIONS DETAILS IN SESSIONS TABLE*/
       $macAddr = substr(shell_exec('getmac'), 159,20);

      //convert time to int
      $yourdatetime = Carbon::now();
      $timestamp = strtotime($yourdatetime);



            /*************************************** */
            // $user->givePermissionTo(

            //     'create-facture','edit-facture','index-facture','create-facture','create-facture',//1 facturation
            //     'create-devis','edit-devis','index-devis','create-devis','create-devis',//1
            //     'create-client','edit-client','index-client',//2 CRM
            //     'create-creancier','edit-creancier','index-creancier','create-creancier','create-creancier',//2
            //     'create-fournisseur','edit-fournisseur','index-fournisseur','create-fournisseur','create-fournisseur',//2
            //     'create-catalogue','edit-catalogue','index-catalogue','create-catalogue','create-catalogue',// 3
            //     'create-tresorerie','edit-tresorerie','index-tresorerie','create-tresorerie','create-tresorerie',//4 tresorerie
            //     'create-depense', 'index-depense', 'show-depense', 'delete-depense', //4
            //     'create-emprunt', 'index-emprunt', 'show-emprunt', 'delete-emprunt', //4
            //     'create-versement', 'index-versement', 'show-versement', 'delete-versement',//4);
            //     'create-compte', 'index-compte', 'show-compte', 'delete-compte', //4
            //      );




        $allpermissions = $user->getAllPermissions();
       // return response()->json([ $allpermissions]);
        $email= $request->email;




            /************************************** */
             // Use other controller's method in this controller's method
           //  $base_side = $basecontroller->sidebar1($allpermissions, $email, );





            //return response()->json([ $email  ]);

       // $user = User::where('email', $data['email'])->first(); //Auth::user()
       $user = User::where('email', $email)->where('type_user','gestionnaire')->first(); //Auth::user()

      // return response()->json([ $user ]);



       //collect des permissions
        $connected_user_permission = User::with('Permissions')
            ->where('id', $user->id)
            ->get();

        $user_connected_details = [];
        array_push($user_connected_details, $connected_user_permission);
        array_push($user_connected_details, $allpermissions);






        $sideperm = $user_connected_details[1];

        // return response()->json(
        //     $user_connected_details[1],
        // );

        $permissionsFront = [];
        for ($i = 0; $i < count($sideperm); $i++) {
            array_push($permissionsFront, $sideperm[$i]->name);
        }


        // --------------------------------------------------------------------------------------------------------------

      // --------------------------------------------------------------------------------------------------------------

        //les liens dans la sidebar du module facture
        $facture = [];
        $devis = [];
        $relance = [];
        $versement = [];
        $taxe = [];
        $historiquefacture = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'facture')) {
                array_push($facture, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'devis')) {
                array_push($devis, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'relance')) {
                array_push($relance, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'versement')) {
                array_push($versement, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'taxe')) {
                array_push($taxe, $permissionsFront[$i]);
            }
            // if (strpos($permissionsFront[$i], 'historiquefacture')) {
            //     array_push($historiquefacture, $permissionsFront[$i]);
            // }
        }
        if (count($facture) > 0 || count($devis) > 0 || count($versement) > 0 || count($relance) > 0 || count($taxe) > 0  || count($historiquefacture) > 0) {
            if (count($facture) > 0) {
                $factureChildren = [
                    'title' => "Facture",
                    'route' => "FactureList",
                    'icon' => "FileTextIcon",
                    'params' => 'facture',
                ];
            }
            if (count($devis) > 0) {
                $devisChildren = [
                    'title' => "Devis",
                    'route' => "DevisList",
                    'icon' => "FileMinusIcon",
                ];
            }
            if (count($versement) > 0) {
                $versementChildren = [
                    'title' => "Versement",
                    'route' => "versements",
                    'icon' => "DollarSignIcon",
                ];
            }
            if (count($taxe) > 0) {
                $taxeChildren = [
                    'title' => "Taxe",
                    'route' => "taxes",
                    'icon' => "PaperclipIcon",
                ];
            }
            if (count($relance) > 0) {
                $relanceChildren = [
                    'title' => "Relance",
                    'route' => "relance",
                    'icon' => "RotateCwIcon",
                ];
            }
            // if (count($historiquefacture) > 0) {
            //     $historiquefactureChildren = [
            //         'title' => "Historique des factures",
            //         'route' => "",
            //         'icon' => "LayersIcon",
            //     ];
            // }

            $childrenFacturation = [];
            if (isset($factureChildren)) {
                array_push($childrenFacturation, $factureChildren);
            }
            if (isset($devisChildren)) {
                array_push($childrenFacturation, $devisChildren);
            }
            if (isset($taxeChildren)) {
                array_push($childrenFacturation, $taxeChildren);
            }
            if (isset($relanceChildren)) {
                array_push($childrenFacturation, $relanceChildren);
            }
            if (isset($versementChildren)) {
                array_push($childrenFacturation, $versementChildren);
            }
            // if (isset($historiquefactureChildren)) {
            //     array_push($childrenFacturation, $historiquefactureChildren);
            // }
            $facturation = [
                'title' => 'Facturation',
                'icon' => "LayersIcon",
                'children' => $childrenFacturation,
            ];
            // return response($facturation, 201);
        }
        //Facturation children
        // $childrenFacturation = [];
        // if (isset($factureChildren)) {
        //     array_push($childrenFacturation, $factureChildren);
        // }
        // if (isset($devisChildren)) {
        //     array_push($childrenFacturation, $devisChildren);
        // }
        // if (isset($taxeChildren)) {
        //     array_push($childrenFacturation, $taxeChildren);
        // }
        // if (isset($relanceChildren)) {
        //     array_push($childrenFacturation, $relanceChildren);
        // }
        // if (isset($versementChildren)) {
        //     array_push($childrenFacturation, $versementChildren);
        // }
        // $facturation = [
        //     'title' => 'Facturation',
        //     'icon' => "LayersIcon",
        //     'children' => $childrenFacturation,
        // ];

        // --------------------------------------------------------------------------------------------------------------

        //Module Trésorerie liens de la side bar
        $depense = [];
        $transaction = [];
        $compte = [];
        $emprunt = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'depense')) {
                array_push($depense, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'transaction')) {
                array_push($transaction, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'compte')) {
                array_push($compte, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'emprunt')) {
                array_push($emprunt, $permissionsFront[$i]);
            }
        }
        if (count($depense) > 0 || count($transaction) > 0 || count($compte) > 0 || count($emprunt) > 0) {
            if (count($depense) > 0) {
                $depenseChildren = [
                    'title' => "Dépense",
                    'route' => "depenses",
                    'icon' => "CornerLeftUpIcon",
                    'children' => [
                        [
                            'title' => "Depense simple",
                            'route' => "liste-depense-simple",
                            'icon' => "TrendingUpIcon",
                        ],
                        [
                            'title' => "Type de depense",
                            'route' => "type-depense",
                            'icon' => "ListIcon",
                        ],
                        // [
                        //     'title' => "Depense groupée",
                        //     'route' => "liste-depense-groupe",
                        //     'icon' => "TrendingUpIcon",
                        // ],
                    ]
                ];
            }
            if (count($transaction) > 0) {
                $transactionChildren = [
                    'title' => "Transaction",
                    'route' => "transaction",
                    'icon' => "TrendingUpIcon",
                ];
            }
            if (count($compte) > 0) {
                $compteChildren = [
                    'title' => "Compte",
                    'route' => "comptes",
                    'icon' => "LockIcon",
                ];
            }

            // $budgetChildren = [
            //     'title' => "Budget",
            //     'route' => "",
            //     'icon' => "LayersIcon",
            // ];

            if (count($emprunt) > 0) {
                $empruntChildren = [
                    'title' => "Emprunt",
                    'route' => "emprunt",
                    'icon' => "CornerRightDownIcon",
                ];
            }
        }
        //Trésorrerie Children
        $childrenTresorerie = [];
        if (isset($depenseChildren)) {
            array_push($childrenTresorerie, $depenseChildren);
        }
        if (isset($transactionChildren)) {
            array_push($childrenTresorerie, $transactionChildren);
        }
        if (isset($compteChildren)) {
            array_push($childrenTresorerie, $compteChildren);
        }
        if (isset($budgetChildren)) {
            array_push($childrenTresorerie, $budgetChildren);
        }
        if (isset($empruntChildren)) {
            array_push($childrenTresorerie, $empruntChildren);
        }

        $tresorerie = [
            'title' => 'Trésorerie',
            'icon' => "DollarSignIcon",
            'children' => $childrenTresorerie,
        ];
        // --------------------------------------------------------------------------------------------------------------

        //Module Catalogue liens de la sidebar
        $article = [];
        // $categorieChildren = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'article')) {
                array_push($article, $permissionsFront[$i]);
            }
        }

        //Catalogue Children
        if (count($article) > 0) {
            if (count($article) > 0) {
                $articleChildren = [
                    'title' => "Article",
                    'route' => "articles",
                    'icon' => "ShoppingBagIcon",
                ];
            }

            // $codepromoChildren = [
            //     'title' => "Code promo",
            //     'route' => "",
            //     'icon' => "TagIcon",
            // ];

            $categorieChildren = [
                'title' => "Catégorie d'article",
                'route' => "CategorieArticles",
                'icon' => "GridIcon",
            ];

            // $packChildren = [
            //     'title' => "Pack",
            //     'route' => "",
            //     'icon' => "CopyIcon",
            // ];

            $catalogueProduitChildren = [
                'title' => "Catalogue de produit",
                'route' => "catalogue",
                'icon' => "CopyIcon",
            ];
        }
        $childrenCatalogue = [];
        if (isset($articleChildren)) {
            array_push($childrenCatalogue, $articleChildren);
        }
        if (isset($codepromoChildren)) {
            array_push($childrenCatalogue, $codepromoChildren);
        }
        if (isset($categorieChildren)) {
            array_push($childrenCatalogue, $categorieChildren);
        }
        if (isset($packChildren)) {
            array_push($childrenCatalogue, $packChildren);
        }
        if (isset($catalogueArticleChildren)) {
            array_push($childrenCatalogue, $catalogueProduitChildren);
        }

        $catalogue = [
            'title' => 'Catalogue',
            'icon' => "ShoppingBagIcon",
            'children' => $childrenCatalogue,
        ];

        // --------------------------------------------------------------------------------------------------------------

        //Module CRM liens de la sidebar
        $client = [];
        $prospection = [];
        $prospect = [];
        $fournisseur = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'client')) {
                array_push($client, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospection')) {
                array_push($prospection, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospect')) {
                array_push($prospect, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'fournisseur')) {
                array_push($fournisseur, $permissionsFront[$i]);
            }
        }
        if (count($client) > 0 || count($prospection) > 0 || count($prospect) > 0 || count($fournisseur) > 0) {
            if (count($client) > 0) {
                $clientChildren = [
                    'title' => "Client",
                    'route' => "clients",
                    'icon' => "UserCheckIcon",
                ];
            }
            if (count($prospection) > 0) {
                $prospectionChildren = [
                    'title' => "Prospection",
                    'route' => "liste-prospection",
                    'icon' => "Minimize2Icon",
                ];
            }
            if (count($prospect) > 0) {
                $prospectChildren = [
                    'title' => "Prospect",
                    'route' => "prospect",
                    'icon' => "MehIcon",
                ];
            }
            if (count($fournisseur) > 0) {
                $fournisseurChildren = [
                    'title' => "Fournisseur",
                    'route' => "fournisseurs",
                    'icon' => "TruckIcon",
                ];
            }
        }
        $childrenCRM = [];
        if (isset($clientChildren)) {
            array_push($childrenCRM, $clientChildren);
        }
        if (isset($prospectionChildren)) {
            array_push($childrenCRM, $prospectionChildren);
        }
        if (isset($prospectChildren)) {
            array_push($childrenCRM, $prospectChildren);
        }
        if (isset($fournisseurChildren)) {
            array_push($childrenCRM, $fournisseurChildren);
        }

        $crm = [
            'title' => 'CRM',
            'icon' => "UsersIcon",
            'children' => $childrenCRM,
        ];
        // --------------------------------------------------------------------------------------------------------------
        //Entreprise les liens de la sidebar

            $personnel = [];
            $infopersonnel = [];
            $module = [];
            // $departement = [];
            // $agence = [];
            $projet = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'personnel')) {
                    array_push($personnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'infopersonnel')) {
                    array_push($infopersonnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'achatmodule')) {
                    array_push($module, $permissionsFront[$i]);
                }
                // if (strpos($permissionsFront[$i], 'departement')) {
                //     array_push($departement, $permissionsFront[$i]);
                // }
                // if (strpos($permissionsFront[$i], 'agence')) {
                //     array_push($agence, $permissionsFront[$i]);
                // }
                if (strpos($permissionsFront[$i], 'projet')) {
                    array_push($projet, $permissionsFront[$i]);
                }
            }
            if (count($personnel) > 0 || count($infopersonnel) > 0 || count($module) > 0 || count($departement) > 0  || count($agence) > 0  || count($projet) > 0) {
                if (count($personnel) > 0) {
                    $personnelChildren = [
                        'title' => "Personnel",
                        'route' => "employes",
                        'icon' => "UserIcon",
                    ];
                }
                if (count($infopersonnel) > 0) {
                    $infopersonnelChildren = [
                        'title' => "Info entreprise",
                        'route' => "",
                        'icon' => "FolderIcon",
                    ];
                }
                if (count($module) > 0) {
                    $moduleChildren = [
                        'title' => "Module",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                // if (count($departement) > 0) {
                //     $departementChildren = [
                //         'title' => "Département",
                //         'route' => "",
                //         'icon' => "LayoutIcon",
                //     ];
                // }
                // if (count($agence) > 0) {
                //     $agenceChildren = [
                //         'title' => "Agence",
                //         'route' => "",
                //         'icon' => "MapIcon",
                //     ];
                // }
                if (count($projet) > 0) {
                    $projetChildren = [
                        'title' => "Projet",
                        'route' => "projet",
                        'icon' => "PlusSquareIcon",
                    ];
                }
            }
            $childrenEntreprise = [];
            if (isset($personnelChildren)) {
                array_push($childrenEntreprise, $personnelChildren);
            }
            if (isset($infopersonnelChildren)) {
                array_push($childrenEntreprise, $infopersonnelChildren);
            }
            if (isset($moduleChildren)) {
                array_push($childrenEntreprise, $moduleChildren);
            }
            if (isset($departementChildren)) {
                array_push($childrenEntreprise, $departementChildren);
            }
            if (isset($agenceChildren)) {
                array_push($childrenEntreprise, $agenceChildren);
            }
            if (isset($projetChildren)) {
                array_push($childrenEntreprise, $projetChildren);
            }

            $entreprise = [
                'title' => 'Entreprise',
                'icon' => "BriefcaseIcon",
                'children' => $childrenEntreprise,
            ];
        // --------------------------------------------------------------------------------------------------------------
            //Ediqia liens de la sidebar
            $roles = [];
            $permission = [];
            $modules = [];
            $parametre = [];
            $typeparametre = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'role')) {
                    array_push($roles, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'permission')) {
                    array_push($permission, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'module')) {
                    array_push($modules, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'parametre')) {
                    array_push($parametre, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'typeparametre')) {
                    array_push($typeparametre, $permissionsFront[$i]);
                }
            }
            if (count($roles) > 0 || count($permission) > 0 || count($modules) > 0 || count($parametre) > 0 || count($typeparametre) > 0) {
                if (count($roles) > 0) {
                    $rolesChildren = [
                        'title' => "Rôles",
                        'route' => "",
                        'icon' => "FramerIcon",
                    ];
                }
                if (count($permission) > 0) {
                    $permissionChildren = [
                        'title' => "Permissions",
                        'route' => "",
                        'icon' => "KeyIcon",
                    ];
                }
                if (count($modules) > 0) {
                    $modulesChildren = [
                        'title' => "Modules",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                if (count($parametre) > 0) {
                    $parametreChildren = [
                        'title' => "Paramètres",
                        'route' => "parametres",
                        'icon' => "SettingsIcon",
                    ];
                }
                if (count($typeparametre) > 0) {
                    $typeparametreChildren = [
                        'title' => "Type paramètres",
                        'route' => "typeparametres",
                        'icon' => "ServerIcon",
                    ];
                }
            }
            $childrenEdiqia = [];
            if (isset($rolesChildren)) {
                array_push($childrenEdiqia, $rolesChildren);
            }
            if (isset($permissionChildren)) {
                array_push($childrenEdiqia, $permissionChildren);
            }
            if (isset($modulesChildren)) {
                array_push($childrenEdiqia, $modulesChildren);
            }
            if (isset($parametreChildren)) {
                array_push($childrenEdiqia, $parametreChildren);
            }
            if (isset($typeparametreChildren)) {
                array_push($childrenEdiqia, $typeparametreChildren);
            }

            $ediqia = [
                'title' => 'Ediqia',
                'icon' => "ZapIcon",
                'children' => $childrenEdiqia,
            ];

        // --------------------------------------------------------------------------------------------------------------


        $sidebar = [['title' => 'Tableau de bord', 'route' => "home", 'icon' => "HomeIcon"]];
        array_push($sidebar, $facturation);
        array_push($sidebar, $tresorerie);
        array_push($sidebar, $catalogue);
        array_push($sidebar, $crm);
        array_push($sidebar, $entreprise);
        // array_push($sidebar, $typeparametre);
        array_push($sidebar, $ediqia);
        // --------------------------------------------------------------------------------------------------------------
        // generer macaddress
        $macAddr = substr(shell_exec('getmac'), 159,20);

        //end check abonnements
        $macAddr = substr(shell_exec('getmac'), 159,20);
        $token = $user->createToken($macAddr)->plainTextToken;

        // $all_users_with_all_their_roles = User::with('permissions')->where('id',$user->id)->get();
        // // $list=DB::table('nom_permissions')->select('libelle')->get();

        //    for($i=0;$i<count($list);$i++)
        //    {
        //        $list2[$i] =  $list[$i]->libelle;
        //        $permissions[$i] = Permission::where('name','like' ,'%-'.$list2[$i])->get();
        //        //$permission_et_nom[$i] = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);
        //        if(count($permissions)>0){

        //            $factureChildren[$i] = [
        //                'title'=> $list[$i]->libelle,
        //                'route'=> "FactureList", //doit etre dynamic
        //                'icon'=> "FileTextIcon", //doit etre dynamic
        //            ];

        //        }

        //    }

           /* STORE SESSIONS DETAILS IN SESSIONS TABLE*/
       //$macAddr = substr(shell_exec('getmac'), 159,20);

       //convert time to int
       $yourdatetime = Carbon::now();
       $timestamp = strtotime($yourdatetime);

        //    $session_id = DB::table('sessions')->insert([
        //          'user_id'=> $user->id,
        //          'ip_address'=> $request->ip(),
        //          'user_agent'=>$request->server('HTTP_USER_AGENT'),
        //          'payload'=>  $macAddr, // mac address
        //          'last_activity'=> $timestamp, //$request->activity()
        //          'tokens'=>$token,
        //          'created_at'=>Carbon::now(),
        //          'updated_at'=>Carbon::now()
        //         // 'deleted_at'=> Carbon::now(),
        //    ]);

       /*END STORE SESSIONS DETAILS IN SESSIONS TABLE*/

        $response = [
            // 'session_id'=>$session_id,
            //   'role' => $role,
            'sidebar' => $sidebar,
            'user_connected_details' => $user_connected_details,
            //$all_users_with_all_their_roles,
            'allpermissions' => $allpermissions,
            'sidebar' => $sidebar,
            'role'=>$role,
            // 'entre' => $entreprise_check->id,
            'connected_user_permission' => $connected_user_permission,
            //'user_connecte' => $user_connecte,
            // 'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
            // 'checker' => $checker,
            'user' => $user,
            'token' => $token,
        ];

         // return response(['jojo'=>$response], 201);
     return response()->json($response, 201);





















        // mac adress
     $macAddr = substr(shell_exec('getmac'), 159,20);






       $role = $user->assignRole('Gestionnaire');
      
       $token = $user->createToken($macAddr)->plainTextToken; //     monappareil
       $response = [
        // 'base_side' => $base_side,
        'token' => $token,
        'role' => $role,
      ];
       return response($response);









        $role = $user->assignRole('Gestionnaire');
        $token = $user->createToken('monappareil')->plainTextToken;  // 
        $response = [
            'user' => $user,
            'token' => $token,
            'role' => $role,
        ];
        return response($response, 201);
    }



      /************************************************************************************/
















    public function Verification()
    {
        $user = Auth::user()->id;

        // // verifier si entreprise existe
        $entreprise_exists =  Entreprise::where('created_user',$user)->where('id',Auth::user()->entreprise_id)->first();
        $entreprise_exist = !empty($entreprise_exists);
        //verifier si il a un abonnement
        $abonnement_exists = DB::table('abonnement_entreprise')->where('Entreprise_id',Auth::user()->entreprise_id)
                               ->whereNotNull('abonnement_id')->first();
        $abonnement_exist = !empty($abonnement_exists);

       //type Abonnement
       // if($abonnement_exists){

       // }

       if($abonnement_exists){
           $type_abonnement = Abonnement::where('id',$abonnement_exists->abonnement_id)
           ->select('libelle')
           ->first();

           $date_finals = DB::table('abonnement_entreprise')->where('entreprise_id',Auth::user()->entreprise_id)//Auth::user()->entreprise_id
           ->where('abonnement_id',$abonnement_exists->abonnement_id)
           ->select('date_final')
           ->get();

           $date = strtotime(date_format(Carbon::now(),"Y-m-d"));
           $date_finals = $date_finals[0]->date_final;
           $date_finals = strtotime($date_finals);
           //  return response()->json(['date'=>$date, 'date_finals'=>$date_finals]);
           if($date_finals > $date ){
          // if(Carbon::now()->addDays(10) < Carbon::now() ){
               $date_final = true;
           }else{
               $date_final = false;
           }
       }else{
           $type_abonnement = null;
           $date_final = null;

       }

       $response = [
        'entreprise_exist'=>$entreprise_exist,
        'abonnement_exist'=>$abonnement_exist,
        'type_abonnement'=>$type_abonnement,
        'valable'=>$date_final,
        //    'user_id'=>$user->id,
        //     'role' => $role,
        //     'user_connected_details' => $user_connected_details,
        //     $all_users_with_all_their_roles,
        //     'allpermissions' => $allpermissions,
        //     'sidebar' => $sidebar,
        //     'entre' => $entreprise_check->id,
        //     'connected_user_permission' => $connected_user_permission,
        //     'user_connecte' => $user_connecte,
        //     'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
        //     'checker' => $checker,
        //     'user' => $user,
        //     'token' => $token,
        ];

        return response($response, 201);


    }

    public function reinitUser(Request $request)
    {
        //reinitialiser password

        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $users = DB::table('users')
            ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
            ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
            ->where('entreprises.id', 1) //Auth::user()->entreprise_id
            ->where('users.email', $request->email)
            ->select('users.*')
            ->get();

        // return[
        //     'message'=>$users,
        //   ];

        $password = 'Users';
        if ($users != null) {
            $user = User::find($users[0]->id)->update([
                'password' => Hash::make($password),
            ]);

            return [
                'message' => 'reinitialiser avec succes 111',
            ];
        } else {
            return [
                'message' => 'aucun Ulitilisateur existe pour ce mail',
            ];
        }

        return [
            'message' => 'Echec reinitialiser ',
        ];
        //
    }

    public function logout(Request $request)
    {
     
        $request->user()->currentAccessToken()->delete();

        $macadress = $macAddr = substr(shell_exec('getmac'), 159,20);

      
                            
       $token_deleted = DB::table('personal_access_tokens')
                                ->where('id',$request->user()->currentAccessToken()->id )
                                ->where('tokenable_id',Auth::user()->id )->delete();

        return response()->json( [
           'token_delete'=>$token_deleted,
            'message' => 'deconnexion reussi',
        ]);
        //
    }


    public function remoutlylogout( Request $request){
        $id = $request->user()->token()->id;

        return response()->json([
          
             'id' => $id ,
         ]);

        $token =   DB::select('select tokens from sessions where id = ? limit 1', [$request->id]);

        $destroy = DB::table('personal_access_tokens')->where('token',$token[0]->tokens)->first();

        //$request->user->tokens()->where('token',$token[0]->tokens)->delete();
        //$tokens = $request->user()->createToken($request->token_name);

        return response()->json([
           'token'=> $token[0]->tokens ,
            'destroy'=>$destroy ,
            //'tokens'=>$tokens,
            'id' => $id ,
        ]);

    }





    public function form_email()
    {
        return view('auth.passwords.email');
    }

    // Fonction pour changer le mot de passe d'un utilisateur

    public function resetUserPassword(Request $request){

        $request->validate([
            'password' => 'required',
            'oldPassword' => 'required'

        ]);

        // $allPassword = DB::table('password_resets')
        // ->where([
        //     'password' => $request->password,
        // ]);

        // if (!$allPassword) {
        //     return response()->json(['message' => 'token invalide'], 201);
        // }
        $oldPassword = $request->oldPassword;
        $password = $request->password;
        if (Hash::check($oldPassword, Auth::user()->password)) {
            $id = Auth::user()->id;
            $user = User::find($id)->update([

                'password'=> bcrypt($password)
            ]);

            return response()->json([
                'message' => 'password reintialisé avec succes',
            ]);

        }else{
            return response()->json([
                'error' => 'votre mot de passe actuel est incorrect'
            ]);
        }


    }




































    public function email_reset_password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'IdCompte' => 'required|exists:users,IdCompte',
        ]);
        // $token = $user->createToken('auth_token')->plainTextToken;
        $expire_at = Carbon::now()->addMinute('2');
        $expire_at = preg_replace("/\-/", "3YMouRDF43", $expire_at);
        $expire_at = preg_replace("/\:/", "5vgfT0KO7", $expire_at);
        $expire_at = preg_replace("/\ /", "9vgMufT0KO1", $expire_at);
        // $expire_at = Crypt::encrypt($expire_at);
        $token = Str::random(64);
        $url = $request->url;
        $full_host = $url.'/?token='.$token.'&yts='.$expire_at;

        $IdCompteVerify = User::where('IdCompte',$request->IdCompte)->first();
        $IdCompteVerify = $IdCompteVerify->email;
        if ($request->email!=$IdCompteVerify ) {
            return response()->json(['errorMessage'=>'Id compte n\'est passocié a l\'email entré']);
        }else{
     $email_delete = DB::table('password_resets')->where('email',$request->email)
        ->where('IdCompte',$request->IdCompte)
        ->delete();

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'IdCompte'=> $request->IdCompte,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

          Mail::send('auth.emailPassword', ['token' => $token,'full_host'=> $full_host], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reintialiser le mot de passe');
        });

        return response()->json(
            [
                'token' => $token,
                 $expire_at,
                'message' => 'Nous avons envoyé votre lien de réinitialisation de mot de passe par e-mail !',
            ],
            200
        );
        }
            // return response()->json($IdCompteVerify);

    }

    public function show_token($token)
    {

        return response()->json([
            'token' => $token,
        ]);
    }

    public function reset_password(Request $request)
    {
        $request->validate([
            // 'email' => ['required', 'string', 'email', 'max:255'],
            // 'password' => ['required'],
        ]);


        $updatePassword = DB::table('password_resets')
            ->where([
                // 'email' => $request->email,
                'token' => $request->token,
            ]) ->select('email')
            ->first();
            // return response()->json($updatePassword);
            $emailGet = $updatePassword ->email;
            $IdCompteGet = $updatePassword ->IdCompte;

        if (!$updatePassword) {
            return response()->json(['message' => 'token invalide'], 201);
        }
        if ($updatePassword) {
            $user = User::where('email', $emailGet)
            ->where('IdCompte',$IdCompteGet)
            ->update(['password' => Hash::make($request->password)]);

            DB::table('password_resets')
                ->where(['email' =>$emailGet])
                ->where(['email' =>$IdCompteGet])
                ->delete();

            return response()->json(['message' => 'password reintialisé']);
        }
    }



    public function resetIdCompte(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $url = $request->url;
        $full_host = $url;

            // verificatio de l'email'
           $email= User::where('email',$request->email)->first();
           $email_verify  =  $email->IdCompte;
                    if ($email_verify) {
                      $code = $email_verify;

                      Mail::send('auth.emailIdCompte', ['full_host'=> $full_host,'code'=> $code], function($message) use($request){
                        $message->to($request->email);
                        $message->subject('Votre ID compte');
                    });
                    }
        return response()->json([$email_verify,$code, 'email envoyé avec success']);
    }

    public function destroy(Request $request)
    {
        //
        $employe=User::find($request->id)->get();
                if ($employe) {
                    $employe_up = User::whereId($request->id)->update(['delete_update_at'=>1]);
                }
        return response()->json([
            'message' => 'suppression reussi',
        ]);
    }



    public function login(Request $request)
    {
        //
        
        $data = $request->validate([
            //'code' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required'],
        ]);
        $emails = $data['email'];



        $user = User::where('email', $data['email'])->where('type_user','gestionnaire')->first(); //Auth::user()

        if(!$user){
            return response(
                [
                    'error' => true,
                    'message' => 'Mot de passe ou Email incorrect',
                    'path' => 'email',

                ],
                201
            );
        }





        $role = $user->roles->pluck('name');

       // return response()->json($role);

        $allpermissions = $user->getAllPermissions();









        // combiner
        //$permission_et_nom = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);

        $connected_user_permission = User::with('Permissions')
         ->where('id', $user->id)
         ->get();

                // return response()->json([ $allpermissions ,$role ,$connected_user_permission]);
            //************************************************************************************************** */
        $user_connected_details = [];
         array_push($user_connected_details, $connected_user_permission);
        array_push($user_connected_details, $allpermissions);

        // $user_connected_details =   Arr::add(['user_info'=>$connected_user_permission ], 'permissions', $allpermissions);

        $entreprise_check = DB::table('users')
            ->join('entreprise_user', 'entreprise_user.user_id', '=', 'users.id')
            ->join('entreprises', 'entreprise_user.entreprise_id', '=', 'entreprises.id')
            ->where('entreprises.username', $request->username)
            ->where('users.email', $request->email)
            ->where('users.password', Hash::check($data['password'], 'users.password'))
            ->select('users.*','entreprises.id' )
            ->first();
        // $user2 = User::where('email',$data['email'])
        // ->where('entreprise_id',$request->entreprise_id)
        // ->first();

        if ($entreprise_check == null) {
            return response(
                [
                    'error' => true,
                    'message' =>  "Nom d'utilisateur de l' entreprise incorrect",
                    'path' =>  'code',
                ],
                201
            );
        }

        if ( !$user || !Hash::check($data['password'], $user->password)) {
            return response(
                [
                    'error' => true,
                    'message' => 'Mot de passe ou Email incorrect',
                    'path' => 'email',
                ],
                201
            );
        }
        //return response()->json([ ]);

        //check abonnements
        $checker = DB::table('abonnements')
            ->join('abonnement_module', 'abonnement_module.abonnement_id', '=', 'abonnements.id')
            ->join('modules', 'abonnement_module.module_id', '=', 'modules.id')
            ->where('abonnements.entreprise_id', $entreprise_check->id)
            ->where('abonnement_module.date_buttoire', '<', Carbon::now()) //date expirer
            ->select('modules.*')
            ->get();
        //**************************************************** */
        //collecter id de l'employe et retirer toutes ses permissions
        $all_users_with_all_their_roles = User::with('permissions')
            ->where('entreprise_id', $entreprise_check->id)
            ->get();

        if ($all_users_with_all_their_roles != null) {
            $user_connecte = User::find($user->id); // trouver l'utiliseur en processus de connexion
            //trouver les permissions rataché a un module
            $user_connecte->revokePermissionTo([]); //extraire les permissions rattachées aux modules
        }

        $sideperm = $user_connected_details[1];
        $permissionsFront = [];
        for ($i = 0; $i < count($sideperm); $i++) {
            array_push($permissionsFront, $sideperm[$i]->name);
        }

       // return response()->json([$user_connected_details[1]]);


        /******************************************/

        // $basecontroller = new BaseAuthControlleur ;

        //     // Use other controller's method in this controller's method
        //    $response = $basecontroller->sidebar($email,$user,$allpermissions,$role,$all_users_with_all_their_roles,$entreprise_check,
        //    $user_connecte,$checker,);




        // $response = [
        //     'role' => $role,
        //     'user_connected_details' => $user_connected_details,
        //     $all_users_with_all_their_roles,
        //     'allpermissions' => $allpermissions,
        //     //'sidebar' => $sidebar,
        //     //'jojo'=>$jojo,
        //     'entre' => $entreprise_check->id,
        //     'connected_user_permission' => $connected_user_permission,
        //     'user_connecte' => $user_connecte,
        //     'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
        //     'checker' => $checker,
        //     'user' => $user,
        //     'token' => $token,
        // ];

        // return response($response, 201);

        // return response()->json($response);


        /*****************************************/
        /*verification du nombre d'appareil connecte*/
        //$session = DB::table('sessions')->where('user_id',$user->id)->distinct('payload')->orderBy('id','DESC')->take(4)->get();


        // $session = DB::select('select DISTINCT(payload),user_id,ip_address,user_agent from sessions where user_id = ? and tokens is not null', [$user->id]);


        // SELECT DISTINCT column1, column2, ...FROM table_name;
        //$session = DB::table('sessions')->where('user_id',$user->id)->distinct()->take(4)->get(['user_id','payload','ip_address','user_agent',]);

       // return response()->json( [ $session, count($session) ]);

        // if(count($session)>= 4){
        //     return response()->json([
        //         'error'=>"Vous n'êtes pas autorisé à vous connecter sur plus de quatre(4) Appareils",
        //     ]);
        // }
         /*Fin verification du nombre d'appareil connecte*/

   







        // --------------------------------------------------------------------------------------------------------------

        //les liens dans la sidebar du module facture
        $facture = [];
        $devis = [];
        $relance = [];
        $versement = [];
        $taxe = [];
        // $historiquefacture = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'facture')) {
                array_push($facture, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'devis')) {
                array_push($devis, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'relance')) {
                array_push($relance, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'versement')) {
                array_push($versement, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'taxe')) {
                array_push($taxe, $permissionsFront[$i]);
            }
            // if (strpos($permissionsFront[$i], 'historiquefacture')) {
            //     array_push($historiquefacture, $permissionsFront[$i]);
            // }
        }
        if (count($facture) > 0 || count($devis) > 0 || count($versement) > 0 || count($relance) > 0 || count($taxe) > 0  || count($historiquefacture) > 0) {
            if (count($facture) > 0) {
                $factureChildren = [
                    'title' => "Facture",
                    'route' => "FactureList",
                    'icon' => "FileTextIcon",
                    'params' => 'facture',
                ];
            }
            if (count($devis) > 0) {
                $devisChildren = [
                    'title' => "Devis",
                    'route' => "DevisList",
                    'icon' => "FileMinusIcon",
                ];
            }
            if (count($versement) > 0) {
                $versementChildren = [
                    'title' => "Versement",
                    'route' => "versements",
                    'icon' => "DollarSignIcon",
                ];
            }
            if (count($taxe) > 0) {
                $taxeChildren = [
                    'title' => "Taxe",
                    'route' => "taxes",
                    'icon' => "PaperclipIcon",
                ];
            }
            if (count($relance) > 0) {
                $relanceChildren = [
                    'title' => "Relance",
                    'route' => "relance",
                    'icon' => "RotateCwIcon",
                ];
            }
            // if (count($historiquefacture) > 0) {
            //     $historiquefactureChildren = [
            //         'title' => "Historique des factures",
            //         'route' => "",
            //         'icon' => "LayersIcon",
            //     ];
            // }

            $childrenFacturation = [];
            if (isset($factureChildren)) {
                array_push($childrenFacturation, $factureChildren);
            }
            if (isset($devisChildren)) {
                array_push($childrenFacturation, $devisChildren);
            }
            if (isset($taxeChildren)) {
                array_push($childrenFacturation, $taxeChildren);
            }
            if (isset($relanceChildren)) {
                array_push($childrenFacturation, $relanceChildren);
            }
            if (isset($versementChildren)) {
                array_push($childrenFacturation, $versementChildren);
            }
            // if (isset($historiquefactureChildren)) {
            //     array_push($childrenFacturation, $historiquefactureChildren);
            // }
            $facturation = [
                'title' => 'Facturation',
                'icon' => "LayersIcon",
                'children' => $childrenFacturation,
            ];
            // return response($facturation, 201);
        }
        //Facturation children
        // $childrenFacturation = [];
        // if (isset($factureChildren)) {
        //     array_push($childrenFacturation, $factureChildren);
        // }
        // if (isset($devisChildren)) {
        //     array_push($childrenFacturation, $devisChildren);
        // }
        // if (isset($taxeChildren)) {
        //     array_push($childrenFacturation, $taxeChildren);
        // }
        // if (isset($relanceChildren)) {
        //     array_push($childrenFacturation, $relanceChildren);
        // }
        // if (isset($versementChildren)) {
        //     array_push($childrenFacturation, $versementChildren);
        // }
        // $facturation = [
        //     'title' => 'Facturation',
        //     'icon' => "LayersIcon",
        //     'children' => $childrenFacturation,
        // ];

        // --------------------------------------------------------------------------------------------------------------

        //Module Trésorerie liens de la side bar
        $depense = [];
        $transaction = [];
        $compte = [];
        $emprunt = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'depense')) {
                array_push($depense, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'transaction')) {
                array_push($transaction, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'compte')) {
                array_push($compte, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'emprunt')) {
                array_push($emprunt, $permissionsFront[$i]);
            }
        }
        if (count($depense) > 0 || count($transaction) > 0 || count($compte) > 0 || count($emprunt) > 0) {
            if (count($depense) > 0) {
                $depenseChildren = [
                    'title' => "Dépense",
                    'route' => "depenses",
                    'icon' => "CornerLeftUpIcon",
                    'children' => [
                        [
                            'title' => "Depense simple",
                            'route' => "liste-depense-simple",
                            'icon' => "TrendingUpIcon",
                        ],
                        [
                            'title' => "Type depense",
                            'route' => "type-depense",
                            'icon' => "ListIcon",
                        ],
                        // [
                        //     'title' => "Depense groupée",
                        //     'route' => "liste-depense-groupe",
                        //     'icon' => "TrendingUpIcon",
                        // ],
                    ]
                ];
            }
            if (count($transaction) > 0) {
                $transactionChildren = [
                    'title' => "Transaction",
                    'route' => "transaction",
                    'icon' => "TrendingUpIcon",
                ];
            }
            if (count($compte) > 0) {
                $compteChildren = [
                    'title' => "Compte",
                    'route' => "comptes",
                    'icon' => "LockIcon",
                ];
            }

            // $budgetChildren = [
            //     'title' => "Budget",
            //     'route' => "",
            //     'icon' => "LayersIcon",
            // ];

            if (count($emprunt) > 0) {
                $empruntChildren = [
                    'title' => "Emprunt",
                    'route' => "emprunt",
                    'icon' => "CornerRightDownIcon",
                ];
            }
        }
        //Trésorrerie Children
        $childrenTresorerie = [];
        if (isset($depenseChildren)) {
            array_push($childrenTresorerie, $depenseChildren);
        }
        if (isset($transactionChildren)) {
            array_push($childrenTresorerie, $transactionChildren);
        }
        if (isset($compteChildren)) {
            array_push($childrenTresorerie, $compteChildren);
        }
        // if (isset($budgetChildren)) {
        //     array_push($childrenTresorerie, $budgetChildren);
        // }
        if (isset($empruntChildren)) {
            array_push($childrenTresorerie, $empruntChildren);
        }

        $tresorerie = [
            'title' => 'Trésorerie',
            'icon' => "DollarSignIcon",
            'children' => $childrenTresorerie,
        ];
        // --------------------------------------------------------------------------------------------------------------

        //Module Catalogue liens de la sidebar
        $article = [];
        // $categorieChildren = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'article')) {
                array_push($article, $permissionsFront[$i]);
            }
        }

        //Catalogue Children
        if (count($article) > 0) {
            if (count($article) > 0) {
                $articleChildren = [
                    'title' => "Article",
                    'route' => "articles",
                    'icon' => "ShoppingBagIcon",
                ];
            }

            // $codepromoChildren = [
            //     'title' => "Code promo",
            //     'route' => "",
            //     'icon' => "TagIcon",
            // ];

            $categorieChildren = [
                'title' => "Catégorie d'article",
                'route' => "CategorieArticles",
                'icon' => "GridIcon",
            ];

            // $packChildren = [
            //     'title' => "Pack",
            //     'route' => "",
            //     'icon' => "CopyIcon",
            // ];

            $catalogueProduitChildren = [
                'title' => "Catalogue de produit",
                'route' => "catalogue",
                'icon' => "CopyIcon",
            ];
        }
        $childrenCatalogue = [];
        if (isset($articleChildren)) {
            array_push($childrenCatalogue, $articleChildren);
        }
        // if (isset($codepromoChildren)) {
        //     array_push($childrenCatalogue, $codepromoChildren);
        // }
        if (isset($categorieChildren)) {
            array_push($childrenCatalogue, $categorieChildren);
        }
        // if (isset($packChildren)) {
        //     array_push($childrenCatalogue, $packChildren);
        // }
        if (isset($catalogueProduitChildren)) {
            array_push($childrenCatalogue, $catalogueProduitChildren);
        }

        $catalogue = [
            'title' => 'Catalogue',
            'icon' => "ShoppingBagIcon",
            'children' => $childrenCatalogue,
        ];

        // --------------------------------------------------------------------------------------------------------------

        //Module CRM liens de la sidebar
        $client = [];
        $prospection = [];
        $prospect = [];
        $fournisseur = [];
        for ($i = 0; $i < count($permissionsFront); $i++) {
            if (strpos($permissionsFront[$i], 'client')) {
                array_push($client, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospection')) {
                array_push($prospection, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'prospect')) {
                array_push($prospect, $permissionsFront[$i]);
            }
            if (strpos($permissionsFront[$i], 'fournisseur')) {
                array_push($fournisseur, $permissionsFront[$i]);
            }
        }
        if (count($client) > 0 || count($prospection) > 0 || count($prospect) > 0 || count($fournisseur) > 0) {
            if (count($client) > 0) {
                $clientChildren = [
                    'title' => "Client",
                    'route' => "clients",
                    'icon' => "UserCheckIcon",
                ];
            }
            if (count($prospection) > 0) {
                $prospectionChildren = [
                    'title' => "Prospection",
                    'route' => "liste-prospection",
                    'icon' => "Minimize2Icon",
                ];
            }
            if (count($prospect) > 0) {
                $prospectChildren = [
                    'title' => "Prospect",
                    'route' => "prospect",
                    'icon' => "MehIcon",
                ];
            }
            if (count($fournisseur) > 0) {
                $fournisseurChildren = [
                    'title' => "Fournisseur",
                    'route' => "fournisseurs",
                    'icon' => "TruckIcon",
                ];
            }
        }
        $childrenCRM = [];
        if (isset($clientChildren)) {
            array_push($childrenCRM, $clientChildren);
        }
        if (isset($prospectionChildren)) {
            array_push($childrenCRM, $prospectionChildren);
        }
        if (isset($prospectChildren)) {
            array_push($childrenCRM, $prospectChildren);
        }
        if (isset($fournisseurChildren)) {
            array_push($childrenCRM, $fournisseurChildren);
        }

        $crm = [
            'title' => 'CRM',
            'icon' => "UsersIcon",
            'children' => $childrenCRM,
        ];
        // --------------------------------------------------------------------------------------------------------------
        //Entreprise les liens de la sidebar

            $personnel = [];
            $infopersonnel = [];
            $module = [];
            // $departement = [];
            // $agence = [];
            $projet = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'personnel')) {
                    array_push($personnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'infopersonnel')) {
                    array_push($infopersonnel, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'achatmodule')) {
                    array_push($module, $permissionsFront[$i]);
                }
                // if (strpos($permissionsFront[$i], 'departement')) {
                //     array_push($departement, $permissionsFront[$i]);
                // }
                // if (strpos($permissionsFront[$i], 'agence')) {
                //     array_push($agence, $permissionsFront[$i]);
                // }
                if (strpos($permissionsFront[$i], 'projet')) {
                    array_push($projet, $permissionsFront[$i]);
                }
            }
            if (count($personnel) > 0 || count($infopersonnel) > 0 || count($module) > 0 || count($departement) > 0  || count($agence) > 0  || count($projet) > 0) {
                if (count($personnel) > 0) {
                    $personnelChildren = [
                        'title' => "Personnel",
                        'route' => "employes",
                        'icon' => "UserIcon",
                    ];
                }
                if (count($infopersonnel) > 0) {
                    $infopersonnelChildren = [
                        'title' => "Info entreprise",
                        'route' => "",
                        'icon' => "FolderIcon",
                    ];
                }
                if (count($module) > 0) {
                    $moduleChildren = [
                        'title' => "Module",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                // if (count($departement) > 0) {
                //     $departementChildren = [
                //         'title' => "Département",
                //         'route' => "",
                //         'icon' => "LayoutIcon",
                //     ];
                // }
                // if (count($agence) > 0) {
                //     $agenceChildren = [
                //         'title' => "Agence",
                //         'route' => "",
                //         'icon' => "MapIcon",
                //     ];
                // }
                if (count($projet) > 0) {
                    $projetChildren = [
                        'title' => "Projet",
                        'route' => "projet",
                        'icon' => "PlusSquareIcon",
                    ];
                }
            }
            $childrenEntreprise = [];
            if (isset($personnelChildren)) {
                array_push($childrenEntreprise, $personnelChildren);
            }
            if (isset($infopersonnelChildren)) {
                array_push($childrenEntreprise, $infopersonnelChildren);
            }
            if (isset($moduleChildren)) {
                array_push($childrenEntreprise, $moduleChildren);
            }
            if (isset($departementChildren)) {
                array_push($childrenEntreprise, $departementChildren);
            }
            if (isset($agenceChildren)) {
                array_push($childrenEntreprise, $agenceChildren);
            }
            if (isset($projetChildren)) {
                array_push($childrenEntreprise, $projetChildren);
            }

            $entreprise = [
                'title' => 'Entreprise',
                'icon' => "BriefcaseIcon",
                'children' => $childrenEntreprise,
            ];
        // --------------------------------------------------------------------------------------------------------------
            //Ediqia liens de la sidebar
            $roles = [];
            $permission = [];
            $modules = [];
            $parametre = [];
            $typeparametre = [];

            for ($i = 0; $i < count($permissionsFront); $i++) {
                if (strpos($permissionsFront[$i], 'role')) {
                    array_push($roles, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'permission')) {
                    array_push($permission, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'module')) {
                    array_push($modules, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'parametre')) {
                    array_push($parametre, $permissionsFront[$i]);
                }
                if (strpos($permissionsFront[$i], 'typeparametre')) {
                    array_push($typeparametre, $permissionsFront[$i]);
                }
            }
            if (count($roles) > 0 || count($permission) > 0 || count($modules) > 0 || count($parametre) > 0 || count($typeparametre) > 0) {
                if (count($roles) > 0) {
                    $rolesChildren = [
                        'title' => "Rôles",
                        'route' => "",
                        'icon' => "FramerIcon",
                    ];
                }
                if (count($permission) > 0) {
                    $permissionChildren = [
                        'title' => "Permissions",
                        'route' => "",
                        'icon' => "KeyIcon",
                    ];
                }
                if (count($modules) > 0) {
                    $modulesChildren = [
                        'title' => "Modules",
                        'route' => "",
                        'icon' => "CommandIcon",
                    ];
                }
                if (count($parametre) > 0) {
                    $parametreChildren = [
                        'title' => "Paramètres",
                        'route' => "parametres",
                        'icon' => "SettingsIcon",
                    ];
                }
                if (count($typeparametre) > 0) {
                    $typeparametreChildren = [
                        'title' => "Type paramètres",
                        'route' => "typeparametres",
                        'icon' => "ServerIcon",
                    ];
                }
            }
            $childrenEdiqia = [];
            if (isset($rolesChildren)) {
                array_push($childrenEdiqia, $rolesChildren);
            }
            if (isset($permissionChildren)) {
                array_push($childrenEdiqia, $permissionChildren);
            }
            if (isset($modulesChildren)) {
                array_push($childrenEdiqia, $modulesChildren);
            }
            if (isset($parametreChildren)) {
                array_push($childrenEdiqia, $parametreChildren);
            }
            if (isset($typeparametreChildren)) {
                array_push($childrenEdiqia, $typeparametreChildren);
            }

            $ediqia = [
                'title' => 'Ediqia',
                'icon' => "ZapIcon",
                'children' => $childrenEdiqia,
            ];

        // --------------------------------------------------------------------------------------------------------------


        $sidebar = [['title' => 'Tableau de bord', 'route' => "home", 'icon' => "HomeIcon"]];
        array_push($sidebar, $facturation);
        array_push($sidebar, $tresorerie);
        array_push($sidebar, $catalogue);
        array_push($sidebar, $crm);
        array_push($sidebar, $entreprise);
        // array_push($sidebar, $typeparametre);
        array_push($sidebar, $ediqia);
        // --------------------------------------------------------------------------------------------------------------

        // $macAddr=false;
        // $arp=`arp -n`;
        // $lines=explode("\n", $arp);
    
        // foreach($lines as $line){
        //     $cols=preg_split('/\s+/', trim($line));
    
        //     if ($cols[0]==$_SERVER['REMOTE_ADDR']){
        //         $macAddr3=$cols[2];
        //    }
        // }

        



       
       //************************************************************************************************************ */
        $list =  DB::table('personal_access_tokens')->where('tokenable_id',$user->id)->select('name')->distinct()->get();
       // $count =  DB::table('personal_access_tokens')->where('tokenable_id',$user->id)->select('name')->distinct('name')->count();

     

      
      //  $data = DB::table('sessions')->where('user_id',3)->get();  //  $user->id
      $data = DB::table('sessions')->groupBy('user_agent')
      // ->where('user_id',$id)
       ->where('user_id','=',  $user->id ) // Auth::user()->id
       ->distinct('user_agent')
       ->orderBy('id','DESC')
       ->take(10)
       ->get();

       $count = DB::table('sessions')
        ->where('user_id','=',  $user->id ) // Auth::user()->id
        ->distinct('user_agent')
        ->orderBy('id','DESC')
        ->count();

          // return response()->json([ 'message'=> $data, 'count'=>$count  ]);
          
          
          
          if($count>4){
            return response()->json([ 
                'path'=>'code',
            	'error'=>true,
                'message'=> 'Vous avez excedé la limite requise qui est de quatre'. $count .'appareils',
                'status' => '200',
        ],200);
        }
        
	 // mac adress
        $macAddr = substr(shell_exec('getmac'), 159,20);

        $token = $user->createToken($macAddr)->plainTextToken; //monappareil


         
 
        // else{
        //     return response()->json([ 'message'=>' $data   =>$count ' ]);
        // }

          //  return response()->json([ 'message'=> 'Vous avez exced2 la limite requise qui est de '.$count.' appareils' ]);


           // $listcount = DB::table('personal_access_tokens')
        // ->where('tokenable_id',$user->id)
        // ->selectRaw("count(name) as nombre")
        // ->groupBy('name')
        // ->distinct()
        // ->get();


        //************************************************************************************************************ */
        
        //return response()->json([$list ,'count'=>$count ]);

        // $all_users_with_all_their_roles = User::with('permissions')->where('id',$user->id)->get();
        // // $list=DB::table('nom_permissions')->select('libelle')->get();

        //    for($i=0;$i<count($list);$i++)
        //    {
        //        $list2[$i] =  $list[$i]->libelle;
        //        $permissions[$i] = Permission::where('name','like' ,'%-'.$list2[$i])->get();
        //        //$permission_et_nom[$i] = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);
        //        if(count($permissions)>0){

        //            $factureChildren[$i] = [
        //                'title'=> $list[$i]->libelle,
        //                'route'=> "FactureList", //doit etre dynamic
        //                'icon'=> "FileTextIcon", //doit etre dynamic
        //            ];

        //        }

        //    }



        // // verifier si entreprise existe
         $entreprise_exists =  Entreprise::where('created_user',$user->id)->where('id',$entreprise_check->id)->first();
         $entreprise_exist = !empty($entreprise_exists);
         //verifier si il a un abonnement
         $abonnement_exists = DB::table('abonnement_entreprise')->where('Entreprise_id',$entreprise_check->id)
                                ->whereNotNull('abonnement_id')->first();
         $abonnement_exist = !empty($abonnement_exists);

        //type Abonnement
        // if($abonnement_exists){

        // }

        // if($abonnement_exists){
        //     $type_abonnement = Abonnement::where('id',$abonnement_exists->abonnement_id)
        //     ->select('libelle')
        //     ->first();

        //     $date_finals = DB::table('abonnement_entreprise')->where('entreprise_id',1)//Auth::user()->entreprise_id
        //     ->where('abonnement_id',$abonnement_exists->abonnement_id)
        //     ->select('date_final')
        //     ->get();

        //     $date = strtotime(date_format(Carbon::now(),"Y-m-d"));
        //     $date_finals = $date_finals[0]->date_final;
        //     $date_finals = strtotime($date_finals);
        //     //  return response()->json(['date'=>$date, 'date_finals'=>$date_finals]);
        //     if($date_finals > $date ){
        //    // if(Carbon::now()->addDays(10) < Carbon::now() ){
        //         $date_final = true;
        //     }else{
        //         $date_final = false;
        //     }
        // }else{
        //     $type_abonnement = null;
        //     $date_final = null;

        // }





         //return response()->json([ 'date_finals' => $date_finals , 'date'=>$date]);


       /* STORE SESSIONS DETAILS IN SESSIONS TABLE*/
        //    $macAddr = substr(shell_exec('getmac'), 159,20);

        //    //convert time to int
        //    $yourdatetime = Carbon::now();
        //    $timestamp = strtotime($yourdatetime);

        //    $session_id = DB::table('sessions')->insert([
        //          'user_id'=> $user->id,
        //          'ip_address'=> $request->ip(),
        //          'user_agent'=>$request->server('HTTP_USER_AGENT'),
        //          'payload'=>  $macAddr, // mac address
        //          'last_activity'=> $timestamp, //$request->activity()
        //          'tokens'=>$token,
        //          'created_at'=>Carbon::now(),
        //          'updated_at'=>Carbon::now()
        //         // 'deleted_at'=> Carbon::now(),
        //    ]);

        //return response()->json([  'jojo', $session_id ]);
            // $session = DB::table('sessions')->distinct('payload')->take(4)->orderBy('id','DESC')->get();
        /*END STORE SESSIONS DETAILS IN SESSIONS TABLE*/

        $response = [
            //    'session'=> $session ,
            //    'session_no'=>count($session),
            // 'entreprise_exist'=>$entreprise_exist,
            // 'abonnement_exist'=>$abonnement_exist,
            // 'type_abonnement'=>$type_abonnement,
            // 'valable'=>$date_final,
           'user_id'=>$user->id,
            'role' => $role,
            'user_connected_details' => $user_connected_details,
            $all_users_with_all_their_roles,
            'allpermissions' => $allpermissions,
            'sidebar' => $sidebar,
            'entre' => $entreprise_check->id,
            'connected_user_permission' => $connected_user_permission,
            'user_connecte' => $user_connecte,
            'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
            'checker' => $checker,
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }






























}

































// public function login(Request $request)
// {
//     //

    

//     $data = $request->validate([
//         'code' => ['required'],
//         'email' => ['required', 'string', 'email', 'max:255'],
//         'password' => ['required'],
//     ]);
//     $emails = $data['email'];


//     $user = User::where('email', $data['email'])->where('type_user','gestionnaire')->first(); //Auth::user()

//     if(!$user){
//         return response(
//             [
//                 'error' => true,
//                 'message' => 'Mot de passe ou Email incorrect',
//                 'path' => 'email',

//             ],
//             201
//         );
//     }





//     $role = $user->roles->pluck('name');

//    // return response()->json($role);

//     $allpermissions = $user->getAllPermissions();









//     // combiner
//     //$permission_et_nom = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);

//     $connected_user_permission = User::with('Permissions')
//      ->where('id', $user->id)
//     ->get();

//             // return response()->json([ $allpermissions ,$role ,$connected_user_permission]);
//         //************************************************************************************************** */
//     $user_connected_details = [];
//      array_push($user_connected_details, $connected_user_permission);
//     array_push($user_connected_details, $allpermissions);

//     // $user_connected_details =   Arr::add(['user_info'=>$connected_user_permission ], 'permissions', $allpermissions);

//     $entreprise_check = DB::table('users')
//         ->join('entreprise_user', 'entreprise_user.user_id', '=', 'users.id')
//         ->join('entreprises', 'entreprise_user.entreprise_id', '=', 'entreprises.id')
//         ->where('entreprises.code', $request->code)
//         ->where('users.email', $request->email)
//         ->where('users.password', Hash::check($data['password'], 'users.password'))
//         ->select('users.*','entreprises.id' )
//         ->first();
//     // $user2 = User::where('email',$data['email'])
//     // ->where('entreprise_id',$request->entreprise_id)
//     // ->first();

//     if ($entreprise_check == null) {
//         return response(
//             [
//                 'error' => true,
//                 'message' =>  'Compte entreprise incorrect',
//                 'path' =>  'code',
//             ],
//             201
//         );
//     }

//     if ( !$user || !Hash::check($data['password'], $user->password)) {
//         return response(
//             [
//                 'error' => true,
//                 'message' => 'Mot de passe ou Email incorrect',
//                 'path' => 'email',
//             ],
//             201
//         );
//     }

//     //check abonnements
//     $checker = DB::table('abonnements')
//         ->join('abonnement_module', 'abonnement_module.abonnement_id', '=', 'abonnements.id')
//         ->join('modules', 'abonnement_module.module_id', '=', 'modules.id')
//         ->where('abonnements.entreprise_id', $entreprise_check->id)
//         ->where('abonnement_module.date_buttoire', '<', Carbon::now()) //date expirer
//         ->select('modules.*')
//         ->get();
//     //**************************************************** */
//     //collecter id de l'employe et retirer toutes ses permissions
//     $all_users_with_all_their_roles = User::with('permissions')
//         ->where('entreprise_id', $entreprise_check->id)
//         ->get();

//     if ($all_users_with_all_their_roles != null) {
//         $user_connecte = User::find($user->id); // trouver l'utiliseur en processus de connexion
//         //trouver les permissions rataché a un module
//         $user_connecte->revokePermissionTo([]); //extraire les permissions rattachées aux modules
//     }

//     $sideperm = $user_connected_details[1];
//     $permissionsFront = [];
//     for ($i = 0; $i < count($sideperm); $i++) {
//         array_push($permissionsFront, $sideperm[$i]->name);
//     }

//    // return response()->json([$user_connected_details[1]]);


//     /******************************************/

//     // $basecontroller = new BaseAuthControlleur ;

//     //     // Use other controller's method in this controller's method
//     //    $response = $basecontroller->sidebar($email,$user,$allpermissions,$role,$all_users_with_all_their_roles,$entreprise_check,
//     //    $user_connecte,$checker,);




//     // $response = [
//     //     'role' => $role,
//     //     'user_connected_details' => $user_connected_details,
//     //     $all_users_with_all_their_roles,
//     //     'allpermissions' => $allpermissions,
//     //     //'sidebar' => $sidebar,
//     //     //'jojo'=>$jojo,
//     //     'entre' => $entreprise_check->id,
//     //     'connected_user_permission' => $connected_user_permission,
//     //     'user_connecte' => $user_connecte,
//     //     'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
//     //     'checker' => $checker,
//     //     'user' => $user,
//     //     'token' => $token,
//     // ];

//     // return response($response, 201);

//     // return response()->json($response);


//     /*****************************************/
//     /*verification du nombre d'appareil connecte*/
//     //$session = DB::table('sessions')->where('user_id',$user->id)->distinct('payload')->orderBy('id','DESC')->take(4)->get();


//     // $session = DB::select('select DISTINCT(payload),user_id,ip_address,user_agent from sessions where user_id = ? and tokens is not null', [$user->id]);


//     // SELECT DISTINCT column1, column2, ...FROM table_name;
//     //$session = DB::table('sessions')->where('user_id',$user->id)->distinct()->take(4)->get(['user_id','payload','ip_address','user_agent',]);

//    // return response()->json( [ $session, count($session) ]);

//     // if(count($session)>= 4){
//     //     return response()->json([
//     //         'error'=>"Vous n'êtes pas autorisé à vous connecter sur plus de quatre(4) Appareils",
//     //     ]);
//     // }
//      /*Fin verification du nombre d'appareil connecte*/









//     // --------------------------------------------------------------------------------------------------------------

//     //les liens dans la sidebar du module facture
//     $facture = [];
//     $devis = [];
//     $relance = [];
//     $versement = [];
//     $taxe = [];
//     // $historiquefacture = [];
//     for ($i = 0; $i < count($permissionsFront); $i++) {
//         if (strpos($permissionsFront[$i], 'facture')) {
//             array_push($facture, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'devis')) {
//             array_push($devis, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'relance')) {
//             array_push($relance, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'versement')) {
//             array_push($versement, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'taxe')) {
//             array_push($taxe, $permissionsFront[$i]);
//         }
//         // if (strpos($permissionsFront[$i], 'historiquefacture')) {
//         //     array_push($historiquefacture, $permissionsFront[$i]);
//         // }
//     }
//     if (count($facture) > 0 || count($devis) > 0 || count($versement) > 0 || count($relance) > 0 || count($taxe) > 0  || count($historiquefacture) > 0) {
//         if (count($facture) > 0) {
//             $factureChildren = [
//                 'title' => "Facture",
//                 'route' => "FactureList",
//                 'icon' => "FileTextIcon",
//                 'params' => 'facture',
//             ];
//         }
//         if (count($devis) > 0) {
//             $devisChildren = [
//                 'title' => "Devis",
//                 'route' => "DevisList",
//                 'icon' => "FileMinusIcon",
//             ];
//         }
//         if (count($versement) > 0) {
//             $versementChildren = [
//                 'title' => "Versement",
//                 'route' => "versements",
//                 'icon' => "DollarSignIcon",
//             ];
//         }
//         if (count($taxe) > 0) {
//             $taxeChildren = [
//                 'title' => "Taxe",
//                 'route' => "taxes",
//                 'icon' => "PaperclipIcon",
//             ];
//         }
//         if (count($relance) > 0) {
//             $relanceChildren = [
//                 'title' => "Relance",
//                 'route' => "relance",
//                 'icon' => "RotateCwIcon",
//             ];
//         }
//         // if (count($historiquefacture) > 0) {
//         //     $historiquefactureChildren = [
//         //         'title' => "Historique des factures",
//         //         'route' => "",
//         //         'icon' => "LayersIcon",
//         //     ];
//         // }

//         $childrenFacturation = [];
//         if (isset($factureChildren)) {
//             array_push($childrenFacturation, $factureChildren);
//         }
//         if (isset($devisChildren)) {
//             array_push($childrenFacturation, $devisChildren);
//         }
//         if (isset($taxeChildren)) {
//             array_push($childrenFacturation, $taxeChildren);
//         }
//         if (isset($relanceChildren)) {
//             array_push($childrenFacturation, $relanceChildren);
//         }
//         if (isset($versementChildren)) {
//             array_push($childrenFacturation, $versementChildren);
//         }
//         // if (isset($historiquefactureChildren)) {
//         //     array_push($childrenFacturation, $historiquefactureChildren);
//         // }
//         $facturation = [
//             'title' => 'Facturation',
//             'icon' => "LayersIcon",
//             'children' => $childrenFacturation,
//         ];
//         // return response($facturation, 201);
//     }
//     //Facturation children
//     // $childrenFacturation = [];
//     // if (isset($factureChildren)) {
//     //     array_push($childrenFacturation, $factureChildren);
//     // }
//     // if (isset($devisChildren)) {
//     //     array_push($childrenFacturation, $devisChildren);
//     // }
//     // if (isset($taxeChildren)) {
//     //     array_push($childrenFacturation, $taxeChildren);
//     // }
//     // if (isset($relanceChildren)) {
//     //     array_push($childrenFacturation, $relanceChildren);
//     // }
//     // if (isset($versementChildren)) {
//     //     array_push($childrenFacturation, $versementChildren);
//     // }
//     // $facturation = [
//     //     'title' => 'Facturation',
//     //     'icon' => "LayersIcon",
//     //     'children' => $childrenFacturation,
//     // ];

//     // --------------------------------------------------------------------------------------------------------------

//     //Module Trésorerie liens de la side bar
//     $depense = [];
//     $transaction = [];
//     $compte = [];
//     $emprunt = [];
//     for ($i = 0; $i < count($permissionsFront); $i++) {
//         if (strpos($permissionsFront[$i], 'depense')) {
//             array_push($depense, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'transaction')) {
//             array_push($transaction, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'compte')) {
//             array_push($compte, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'emprunt')) {
//             array_push($emprunt, $permissionsFront[$i]);
//         }
//     }
//     if (count($depense) > 0 || count($transaction) > 0 || count($compte) > 0 || count($emprunt) > 0) {
//         if (count($depense) > 0) {
//             $depenseChildren = [
//                 'title' => "Dépense",
//                 'route' => "depenses",
//                 'icon' => "CornerLeftUpIcon",
//                 'children' => [
//                     [
//                         'title' => "Depense simple",
//                         'route' => "liste-depense-simple",
//                         'icon' => "TrendingUpIcon",
//                     ],
//                     [
//                         'title' => "Type depense",
//                         'route' => "type-depense",
//                         'icon' => "ListIcon",
//                     ],
//                     // [
//                     //     'title' => "Depense groupée",
//                     //     'route' => "liste-depense-groupe",
//                     //     'icon' => "TrendingUpIcon",
//                     // ],
//                 ]
//             ];
//         }
//         if (count($transaction) > 0) {
//             $transactionChildren = [
//                 'title' => "Transaction",
//                 'route' => "transaction",
//                 'icon' => "TrendingUpIcon",
//             ];
//         }
//         if (count($compte) > 0) {
//             $compteChildren = [
//                 'title' => "Compte",
//                 'route' => "comptes",
//                 'icon' => "LockIcon",
//             ];
//         }

//         // $budgetChildren = [
//         //     'title' => "Budget",
//         //     'route' => "",
//         //     'icon' => "LayersIcon",
//         // ];

//         if (count($emprunt) > 0) {
//             $empruntChildren = [
//                 'title' => "Emprunt",
//                 'route' => "emprunt",
//                 'icon' => "CornerRightDownIcon",
//             ];
//         }
//     }
//     //Trésorrerie Children
//     $childrenTresorerie = [];
//     if (isset($depenseChildren)) {
//         array_push($childrenTresorerie, $depenseChildren);
//     }
//     if (isset($transactionChildren)) {
//         array_push($childrenTresorerie, $transactionChildren);
//     }
//     if (isset($compteChildren)) {
//         array_push($childrenTresorerie, $compteChildren);
//     }
//     // if (isset($budgetChildren)) {
//     //     array_push($childrenTresorerie, $budgetChildren);
//     // }
//     if (isset($empruntChildren)) {
//         array_push($childrenTresorerie, $empruntChildren);
//     }

//     $tresorerie = [
//         'title' => 'Trésorerie',
//         'icon' => "DollarSignIcon",
//         'children' => $childrenTresorerie,
//     ];
//     // --------------------------------------------------------------------------------------------------------------

//     //Module Catalogue liens de la sidebar
//     $article = [];
//     // $categorieChildren = [];
//     for ($i = 0; $i < count($permissionsFront); $i++) {
//         if (strpos($permissionsFront[$i], 'article')) {
//             array_push($article, $permissionsFront[$i]);
//         }
//     }

//     //Catalogue Children
//     if (count($article) > 0) {
//         if (count($article) > 0) {
//             $articleChildren = [
//                 'title' => "Article",
//                 'route' => "articles",
//                 'icon' => "ShoppingBagIcon",
//             ];
//         }

//         // $codepromoChildren = [
//         //     'title' => "Code promo",
//         //     'route' => "",
//         //     'icon' => "TagIcon",
//         // ];

//         $categorieChildren = [
//             'title' => "Catégorie d'article",
//             'route' => "CategorieArticles",
//             'icon' => "GridIcon",
//         ];

//         // $packChildren = [
//         //     'title' => "Pack",
//         //     'route' => "",
//         //     'icon' => "CopyIcon",
//         // ];

//         $catalogueProduitChildren = [
//             'title' => "Catalogue de produit",
//             'route' => "catalogue",
//             'icon' => "CopyIcon",
//         ];
//     }
//     $childrenCatalogue = [];
//     if (isset($articleChildren)) {
//         array_push($childrenCatalogue, $articleChildren);
//     }
//     // if (isset($codepromoChildren)) {
//     //     array_push($childrenCatalogue, $codepromoChildren);
//     // }
//     if (isset($categorieChildren)) {
//         array_push($childrenCatalogue, $categorieChildren);
//     }
//     // if (isset($packChildren)) {
//     //     array_push($childrenCatalogue, $packChildren);
//     // }
//     if (isset($catalogueProduitChildren)) {
//         array_push($childrenCatalogue, $catalogueProduitChildren);
//     }

//     $catalogue = [
//         'title' => 'Catalogue',
//         'icon' => "ShoppingBagIcon",
//         'children' => $childrenCatalogue,
//     ];

//     // --------------------------------------------------------------------------------------------------------------

//     //Module CRM liens de la sidebar
//     $client = [];
//     $prospection = [];
//     $prospect = [];
//     $fournisseur = [];
//     for ($i = 0; $i < count($permissionsFront); $i++) {
//         if (strpos($permissionsFront[$i], 'client')) {
//             array_push($client, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'prospection')) {
//             array_push($prospection, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'prospect')) {
//             array_push($prospect, $permissionsFront[$i]);
//         }
//         if (strpos($permissionsFront[$i], 'fournisseur')) {
//             array_push($fournisseur, $permissionsFront[$i]);
//         }
//     }
//     if (count($client) > 0 || count($prospection) > 0 || count($prospect) > 0 || count($fournisseur) > 0) {
//         if (count($client) > 0) {
//             $clientChildren = [
//                 'title' => "Client",
//                 'route' => "clients",
//                 'icon' => "UserCheckIcon",
//             ];
//         }
//         if (count($prospection) > 0) {
//             $prospectionChildren = [
//                 'title' => "Prospection",
//                 'route' => "liste-prospection",
//                 'icon' => "Minimize2Icon",
//             ];
//         }
//         if (count($prospect) > 0) {
//             $prospectChildren = [
//                 'title' => "Prospect",
//                 'route' => "prospect",
//                 'icon' => "MehIcon",
//             ];
//         }
//         if (count($fournisseur) > 0) {
//             $fournisseurChildren = [
//                 'title' => "Fournisseur",
//                 'route' => "fournisseurs",
//                 'icon' => "TruckIcon",
//             ];
//         }
//     }
//     $childrenCRM = [];
//     if (isset($clientChildren)) {
//         array_push($childrenCRM, $clientChildren);
//     }
//     if (isset($prospectionChildren)) {
//         array_push($childrenCRM, $prospectionChildren);
//     }
//     if (isset($prospectChildren)) {
//         array_push($childrenCRM, $prospectChildren);
//     }
//     if (isset($fournisseurChildren)) {
//         array_push($childrenCRM, $fournisseurChildren);
//     }

//     $crm = [
//         'title' => 'CRM',
//         'icon' => "UsersIcon",
//         'children' => $childrenCRM,
//     ];
//     // --------------------------------------------------------------------------------------------------------------
//     //Entreprise les liens de la sidebar

//         $personnel = [];
//         $infopersonnel = [];
//         $module = [];
//         // $departement = [];
//         // $agence = [];
//         $projet = [];

//         for ($i = 0; $i < count($permissionsFront); $i++) {
//             if (strpos($permissionsFront[$i], 'personnel')) {
//                 array_push($personnel, $permissionsFront[$i]);
//             }
//             if (strpos($permissionsFront[$i], 'infopersonnel')) {
//                 array_push($infopersonnel, $permissionsFront[$i]);
//             }
//             if (strpos($permissionsFront[$i], 'achatmodule')) {
//                 array_push($module, $permissionsFront[$i]);
//             }
//             // if (strpos($permissionsFront[$i], 'departement')) {
//             //     array_push($departement, $permissionsFront[$i]);
//             // }
//             // if (strpos($permissionsFront[$i], 'agence')) {
//             //     array_push($agence, $permissionsFront[$i]);
//             // }
//             if (strpos($permissionsFront[$i], 'projet')) {
//                 array_push($projet, $permissionsFront[$i]);
//             }
//         }
//         if (count($personnel) > 0 || count($infopersonnel) > 0 || count($module) > 0 || count($departement) > 0  || count($agence) > 0  || count($projet) > 0) {
//             if (count($personnel) > 0) {
//                 $personnelChildren = [
//                     'title' => "Personnel",
//                     'route' => "employes",
//                     'icon' => "UserIcon",
//                 ];
//             }
//             if (count($infopersonnel) > 0) {
//                 $infopersonnelChildren = [
//                     'title' => "Info entreprise",
//                     'route' => "",
//                     'icon' => "FolderIcon",
//                 ];
//             }
//             if (count($module) > 0) {
//                 $moduleChildren = [
//                     'title' => "Module",
//                     'route' => "",
//                     'icon' => "CommandIcon",
//                 ];
//             }
//             // if (count($departement) > 0) {
//             //     $departementChildren = [
//             //         'title' => "Département",
//             //         'route' => "",
//             //         'icon' => "LayoutIcon",
//             //     ];
//             // }
//             // if (count($agence) > 0) {
//             //     $agenceChildren = [
//             //         'title' => "Agence",
//             //         'route' => "",
//             //         'icon' => "MapIcon",
//             //     ];
//             // }
//             if (count($projet) > 0) {
//                 $projetChildren = [
//                     'title' => "Projet",
//                     'route' => "projet",
//                     'icon' => "PlusSquareIcon",
//                 ];
//             }
//         }
//         $childrenEntreprise = [];
//         if (isset($personnelChildren)) {
//             array_push($childrenEntreprise, $personnelChildren);
//         }
//         if (isset($infopersonnelChildren)) {
//             array_push($childrenEntreprise, $infopersonnelChildren);
//         }
//         if (isset($moduleChildren)) {
//             array_push($childrenEntreprise, $moduleChildren);
//         }
//         if (isset($departementChildren)) {
//             array_push($childrenEntreprise, $departementChildren);
//         }
//         if (isset($agenceChildren)) {
//             array_push($childrenEntreprise, $agenceChildren);
//         }
//         if (isset($projetChildren)) {
//             array_push($childrenEntreprise, $projetChildren);
//         }

//         $entreprise = [
//             'title' => 'Entreprise',
//             'icon' => "BriefcaseIcon",
//             'children' => $childrenEntreprise,
//         ];
//     // --------------------------------------------------------------------------------------------------------------
//         //Ediqia liens de la sidebar
//         $roles = [];
//         $permission = [];
//         $modules = [];
//         $parametre = [];
//         $typeparametre = [];

//         for ($i = 0; $i < count($permissionsFront); $i++) {
//             if (strpos($permissionsFront[$i], 'role')) {
//                 array_push($roles, $permissionsFront[$i]);
//             }
//             if (strpos($permissionsFront[$i], 'permission')) {
//                 array_push($permission, $permissionsFront[$i]);
//             }
//             if (strpos($permissionsFront[$i], 'module')) {
//                 array_push($modules, $permissionsFront[$i]);
//             }
//             if (strpos($permissionsFront[$i], 'parametre')) {
//                 array_push($parametre, $permissionsFront[$i]);
//             }
//             if (strpos($permissionsFront[$i], 'typeparametre')) {
//                 array_push($typeparametre, $permissionsFront[$i]);
//             }
//         }
//         if (count($roles) > 0 || count($permission) > 0 || count($modules) > 0 || count($parametre) > 0 || count($typeparametre) > 0) {
//             if (count($roles) > 0) {
//                 $rolesChildren = [
//                     'title' => "Rôles",
//                     'route' => "",
//                     'icon' => "FramerIcon",
//                 ];
//             }
//             if (count($permission) > 0) {
//                 $permissionChildren = [
//                     'title' => "Permissions",
//                     'route' => "",
//                     'icon' => "KeyIcon",
//                 ];
//             }
//             if (count($modules) > 0) {
//                 $modulesChildren = [
//                     'title' => "Modules",
//                     'route' => "",
//                     'icon' => "CommandIcon",
//                 ];
//             }
//             if (count($parametre) > 0) {
//                 $parametreChildren = [
//                     'title' => "Paramètres",
//                     'route' => "parametres",
//                     'icon' => "SettingsIcon",
//                 ];
//             }
//             if (count($typeparametre) > 0) {
//                 $typeparametreChildren = [
//                     'title' => "Type paramètres",
//                     'route' => "typeparametres",
//                     'icon' => "ServerIcon",
//                 ];
//             }
//         }
//         $childrenEdiqia = [];
//         if (isset($rolesChildren)) {
//             array_push($childrenEdiqia, $rolesChildren);
//         }
//         if (isset($permissionChildren)) {
//             array_push($childrenEdiqia, $permissionChildren);
//         }
//         if (isset($modulesChildren)) {
//             array_push($childrenEdiqia, $modulesChildren);
//         }
//         if (isset($parametreChildren)) {
//             array_push($childrenEdiqia, $parametreChildren);
//         }
//         if (isset($typeparametreChildren)) {
//             array_push($childrenEdiqia, $typeparametreChildren);
//         }

//         $ediqia = [
//             'title' => 'Ediqia',
//             'icon' => "ZapIcon",
//             'children' => $childrenEdiqia,
//         ];

//     // --------------------------------------------------------------------------------------------------------------


//     $sidebar = [['title' => 'Tableau de bord', 'route' => "home", 'icon' => "HomeIcon"]];
//     array_push($sidebar, $facturation);
//     array_push($sidebar, $tresorerie);
//     array_push($sidebar, $catalogue);
//     array_push($sidebar, $crm);
//     array_push($sidebar, $entreprise);
//     // array_push($sidebar, $typeparametre);
//     array_push($sidebar, $ediqia);
//     // --------------------------------------------------------------------------------------------------------------

//     // $macAddr=false;
//     // $arp=`arp -n`;
//     // $lines=explode("\n", $arp);

//     // foreach($lines as $line){
//     //     $cols=preg_split('/\s+/', trim($line));

//     //     if ($cols[0]==$_SERVER['REMOTE_ADDR']){
//     //         $macAddr3=$cols[2];
//     //    }
//     // }

    



   
//    //************************************************************************************************************ */
//     $list =  DB::table('personal_access_tokens')->where('tokenable_id',$user->id)->select('name')->distinct()->get();
//    // $count =  DB::table('personal_access_tokens')->where('tokenable_id',$user->id)->select('name')->distinct('name')->count();

 

  
//   //  $data = DB::table('sessions')->where('user_id',3)->get();  //  $user->id
//   $data = DB::table('sessions')->groupBy('user_agent')
//   // ->where('user_id',$id)
//    ->where('user_id','=',  $user->id ) // Auth::user()->id
//    ->distinct('user_agent')
//    ->orderBy('id','DESC')
//    ->take(10)
//    ->get();

//    $count = DB::table('sessions')
//     ->where('user_id','=',  $user->id ) // Auth::user()->id
//     ->distinct('user_agent')
//     ->orderBy('id','DESC')
//     ->count();

//       // return response()->json([ 'message'=> $data, 'count'=>$count  ]);
      
      
      
//       if($count>4){
//         return response()->json([ 
//             'path'=>'code',
//             'error'=>true,
//             'message'=> 'Vous avez excedé la limite requise qui est de quatre'. $count .'appareils',
//             'status' => '200',
//     ],200);
//     }
    
//  // mac adress
//     $macAddr = substr(shell_exec('getmac'), 159,20);

//     $token = $user->createToken($macAddr)->plainTextToken; //monappareil


     

//     // else{
//     //     return response()->json([ 'message'=>' $data   =>$count ' ]);
//     // }

//       //  return response()->json([ 'message'=> 'Vous avez exced2 la limite requise qui est de '.$count.' appareils' ]);


//        // $listcount = DB::table('personal_access_tokens')
//     // ->where('tokenable_id',$user->id)
//     // ->selectRaw("count(name) as nombre")
//     // ->groupBy('name')
//     // ->distinct()
//     // ->get();


//     //************************************************************************************************************ */
    
//     //return response()->json([$list ,'count'=>$count ]);

//     // $all_users_with_all_their_roles = User::with('permissions')->where('id',$user->id)->get();
//     // // $list=DB::table('nom_permissions')->select('libelle')->get();

//     //    for($i=0;$i<count($list);$i++)
//     //    {
//     //        $list2[$i] =  $list[$i]->libelle;
//     //        $permissions[$i] = Permission::where('name','like' ,'%-'.$list2[$i])->get();
//     //        //$permission_et_nom[$i] = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);
//     //        if(count($permissions)>0){

//     //            $factureChildren[$i] = [
//     //                'title'=> $list[$i]->libelle,
//     //                'route'=> "FactureList", //doit etre dynamic
//     //                'icon'=> "FileTextIcon", //doit etre dynamic
//     //            ];

//     //        }

//     //    }



//     // // verifier si entreprise existe
//      $entreprise_exists =  Entreprise::where('created_user',$user->id)->where('id',$entreprise_check->id)->first();
//      $entreprise_exist = !empty($entreprise_exists);
//      //verifier si il a un abonnement
//      $abonnement_exists = DB::table('abonnement_entreprise')->where('Entreprise_id',$entreprise_check->id)
//                             ->whereNotNull('abonnement_id')->first();
//      $abonnement_exist = !empty($abonnement_exists);

//     //type Abonnement
//     // if($abonnement_exists){

//     // }

//     // if($abonnement_exists){
//     //     $type_abonnement = Abonnement::where('id',$abonnement_exists->abonnement_id)
//     //     ->select('libelle')
//     //     ->first();

//     //     $date_finals = DB::table('abonnement_entreprise')->where('entreprise_id',1)//Auth::user()->entreprise_id
//     //     ->where('abonnement_id',$abonnement_exists->abonnement_id)
//     //     ->select('date_final')
//     //     ->get();

//     //     $date = strtotime(date_format(Carbon::now(),"Y-m-d"));
//     //     $date_finals = $date_finals[0]->date_final;
//     //     $date_finals = strtotime($date_finals);
//     //     //  return response()->json(['date'=>$date, 'date_finals'=>$date_finals]);
//     //     if($date_finals > $date ){
//     //    // if(Carbon::now()->addDays(10) < Carbon::now() ){
//     //         $date_final = true;
//     //     }else{
//     //         $date_final = false;
//     //     }
//     // }else{
//     //     $type_abonnement = null;
//     //     $date_final = null;

//     // }





//      //return response()->json([ 'date_finals' => $date_finals , 'date'=>$date]);


//    /* STORE SESSIONS DETAILS IN SESSIONS TABLE*/
//     //    $macAddr = substr(shell_exec('getmac'), 159,20);

//     //    //convert time to int
//     //    $yourdatetime = Carbon::now();
//     //    $timestamp = strtotime($yourdatetime);

//     //    $session_id = DB::table('sessions')->insert([
//     //          'user_id'=> $user->id,
//     //          'ip_address'=> $request->ip(),
//     //          'user_agent'=>$request->server('HTTP_USER_AGENT'),
//     //          'payload'=>  $macAddr, // mac address
//     //          'last_activity'=> $timestamp, //$request->activity()
//     //          'tokens'=>$token,
//     //          'created_at'=>Carbon::now(),
//     //          'updated_at'=>Carbon::now()
//     //         // 'deleted_at'=> Carbon::now(),
//     //    ]);

//     //return response()->json([  'jojo', $session_id ]);
//         // $session = DB::table('sessions')->distinct('payload')->take(4)->orderBy('id','DESC')->get();
//     /*END STORE SESSIONS DETAILS IN SESSIONS TABLE*/

//     $response = [
//         //    'session'=> $session ,
//         //    'session_no'=>count($session),
//         // 'entreprise_exist'=>$entreprise_exist,
//         // 'abonnement_exist'=>$abonnement_exist,
//         // 'type_abonnement'=>$type_abonnement,
//         // 'valable'=>$date_final,
//        'user_id'=>$user->id,
//         'role' => $role,
//         'user_connected_details' => $user_connected_details,
//         $all_users_with_all_their_roles,
//         'allpermissions' => $allpermissions,
//         'sidebar' => $sidebar,
//         'entre' => $entreprise_check->id,
//         'connected_user_permission' => $connected_user_permission,
//         'user_connecte' => $user_connecte,
//         'all_users_with_all_their_roles' => $all_users_with_all_their_roles,
//         'checker' => $checker,
//         'user' => $user,
//         'token' => $token,
//     ];

//     return response($response, 201);
// }