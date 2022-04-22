<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role ;

class Gestion_userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // list des utilisateurs de l'entreprise connecté
        $user = DB::table('users')
        ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
        ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        ->select('users.*',)
        ->get();

        return response()->json([
           // $auth,
            $user
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createUser(Request $request)
    {
        //

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', ],
            //'indicateur' => ['required'],
            //'contact' => ['required', 'string', 'max:255'],
            //'password' => ['required'],
        ]);

        $abonnement = DB::table('abonnements')
        ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
        ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        ->select('abonnements.*',)
        ->get();

            $nombre_user = User::where('entreprise_id',2)->count();  //Auth::user()->entreprise_id //  $abonnement[0]->nbr_abonnes


            if($abonnement != null  && $abonnement[0]->date_buttoire >= Carbon::now() && $nombre_user <= 5 &&  $abonnement[0]->libelle == 'gratuit')
            {
                $password = 'Users';


                $user=User::create([
                    'nom' => $data['nom'],
                    'prenoms' => $request['prenoms'],
                    'email' => $data['email'],
                    //'contact' => $data['contact'],
                    //'indicateur' => $data['indicateur'],
                    'password' => Hash::make($password),
                  //  'entreprise_id' =>
                ]);


                // Creation de pivot
                DB::table('entreprise_user')->insert([
                    'entreprise_id'=> Auth::user()->entreprise_id, //retirer pour test avec postman
                    'user_id'=> $user->id
                ]);
                $role=$user->assignRole('employee');

                //Role and permission
                $users_connect = User::where('id',$request->user_id)->first();  //Auth::user()->id





                $response=[
                    'nomre'=>$nombre_user,
                    'role'=>$role,
                    'user'=>$user,
                    'message'=> 'utilisateur creer avec succes',
                ];
                return response($response,201);


            }
            elseif($abonnement != null  && $abonnement[0]->date_buttoire >= Carbon::now() && $nombre_user <= 15 &&  $abonnement[0]->libelle != 'gratuit')
            {
                $password = 'Users';

                $user=User::create([
                    'nom' => $data['nom'],
                    'prenoms' => $request['prenoms'],
                    'email' => $data['email'],
                    //'contact' => $data['contact'],
                    //'indicateur' => $data['indicateur'],
                    'password' => Hash::make($password),
                ]);

                 // Creation de pivot
                 DB::table('entreprise_user')->insert([
                    //  'entreprise_id'=> Auth::user()->entreprise_id,
                      'user_id'=> $user->id
                  ]);
                 //debut
                 //Role and permission
                 $role=$user->assignRole($request->role);


                $response=[
                    'user'=>$user,
                    'role'=>$role,
                    'message'=> 'utilisateur creer avec succes',
                ];
                return response($response,201);

            }
            else{
                $response=[
                    Auth::user()->entreprise_id,
                    'message'=> "veillez verifier le nombre d'utilisateur  ou renouvelez votre abonnement",
                ];
                return response($response,201);

            }



            $response=[
                Auth::user()->entreprise_id,
                'message'=> "echec",
            ];
            return response($response,201);


    }






    public function updateUser(Request $request){

        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'prenoms' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', ],
            //'indicateur' => ['required'],
            //'contact' => ['required', 'string', 'max:255'],
            'password' => [],
        ]);

        $abonnement = DB::table('abonnements')
        ->join('abonnement_entreprise', 'abonnements.id', '=', 'abonnement_entreprise.abonnement_id')
        ->join('entreprises', 'entreprises.id', '=', 'abonnement_entreprise.entreprise_id')
        ->where('entreprises.id',$request->entreprise_id)  //Auth::user()->entreprise_id
        ->select('abonnements.*',)
        ->get();


            if($abonnement != null  && $abonnement[0]->date_buttoire >= Carbon::now() && $abonnement[0]->nbr_abonnes = 5 )
            {
               // $password = 'Users';

                $user=User::find(Auth::user()->id)->update([
                    'nom' => $data['nom'],
                    'prenoms' => $request['prenoms'],
                    'email' => $data['email'],
                    //'contact' => $data['contact'],
                    //'indicateur' => $data['indicateur'],
                    'password' => Hash::make($request->password),
                ]);


                // Creation de pivot
                DB::table('entreprise_user')->insert([
                    'entreprise_id'=> Auth::user()->entreprise_id,
                    'user_id'=>1// $user->id
                ]);

                //Role and permission
                $users_connect = User::where('id',Auth::user()->id)->first();

                if($request->role != null){
                   $role=$users_connect->assignRole($request->role);
                }elseif($request->role_name != null){

                    $test =Role::find($request->id);
                    $this->validate($request,[
                       'name'=> 'required',
                        'permissions'=> 'nullable'
                    ]);
                    Role::find($request->id)->update([
                       'name' => $request->name,
                        ]);
                    $test->permissions()->sync($request->perm);

                }else{

                    $response=[
                        'message'=> 'veillez verifier vos donnees',
                    ];
                    return response($response,201);
                 }
                 //EndRole and permission







                $response=[
                    'role'=>$role,
                    'user'=>$user,
                    'message'=> 'utilisateur creer avec succes',
                ];
                return response($response,201);


            }
            elseif($abonnement != null  && $abonnement[0]->date_buttoire >= Carbon::now() && $abonnement[0]->nbr_abonnes = 15 )
            {
                $password = 'Users';

                $user=User::create([
                    'nom' => $data['nom'],
                    'prenoms' => $request['prenoms'],
                    'email' => $data['email'],
                    //'contact' => $data['contact'],
                    //'indicateur' => $data['indicateur'],
                    'password' => Hash::make($password['password']),
                ]);

                 // Creation de pivot
                 DB::table('entreprise_user')->insert([
                        'entreprise_id'=> Auth::user()->entreprise_id,
                        'user_id'=>1// $user->id
                  ]);

                  //Role and permission
                  $users_connect = User::where('id',Auth::user()->id)->first();

                  if($request->role != null){
                     $role=$users_connect->assignRole($request->role);
                  }elseif($request->role_name != null){

                    $test =Role::find($request->id);
                    $this->validate($request,[
                       'name'=> 'required',
                        'permissions'=> 'nullable'
                    ]);
                    Role::find($request->id)->update([
                       'name' => $request->name,
                        ]);
                    $test->permissions()->sync($request->perm);

                  }else{

                      $response=[
                          'message'=> 'veillez verifier vos donnees',
                      ];
                      return response($response,201);
                   }
                   //End Role and permission


                $response=[
                    'user'=>$user,
                    'role'=>$role,
                    'message'=> 'utilisateur creer avec succes',
                ];
                return response($response,201);

            }
            else{
                $response=[
                    'message'=> "veillez verifier le nombre d'utilisateur  ou renouvelez votre abonnement",
                ];
                return response($response,201);

            }



            $response=[
                'message'=> "echec",
            ];
            return response($response,201);

    }








    public function reinitUser(Request $request)
    {//reinitialiser password

        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', ],
        ]);

        $users = DB::table('users')
        ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
        ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        ->where('entreprises.id',1)  //Auth::user()->entreprise_id
        ->where('users.email',$request->email)
        ->select('users.*',)
        ->get();

        // return[
        //     'message'=>$users,
        //   ];

        $password = 'Users';
        if($users != null )
        {
            $user=User::find($users[0]->id)->update([
                'password' => Hash::make($password),
            ]);

            return[
                'message'=>'reinitialiser avec succes 111',
            ];

        }else{
            return[
                'message'=>'aucun Ulitilisateur existe pour ce mail',
              ];
        }




      return[
        'message'=>'Echec reinitialiser ',
      ];
        //
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
        //
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
    }
}
