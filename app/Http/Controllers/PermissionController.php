<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role ;
use \Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(Permission $permission)
     {
         // $this->middleware("auth");
         $this->permission=$permission;
     }

    public function index()
    {
        //role and permissions developpeur
       // $list1=['facture','devis','bondecommande','versement','emprunt','role','permission','typeparametre','creancier','agence','depense','article','compte'];

       //gestion de permissions et role pour developpeurs Qenium
       $list=DB::table('nom_permissions')->select('libelle')->get();

        for($i=0;$i<count($list);$i++)
        {
            $list2[$i] =  $list[$i]->libelle;
            $permissions[$i] = Permission::where('name','like' ,'%-'.$list2[$i])->get();
            $permission_et_nom[$i] = Arr::add(['permissions'=>$permissions[$i]], 'nom', $list[$i]->libelle);
            //  $merged[$i] = $permissions[$i]->merge(['nom' => $list[$i]->libelle]);
            // $permissions[$i]->push($list2[$i]);
            //$nom_permissions[$i] =
            //$array = array_merge($list2, $permissions);
            // $array = Arr::add([$list2,$permissions], 'price', 100);
        }


        //End gestion de permissions et role pour developpeurs Qenium

        //gestion de permissions et role pour developpeurs Entreprise
        $perm_entreprise = Permission::where('entreprise_id',Auth::user()->entreprise_id);
        $all_users_with_all_direct_permissions = User::with('permissions')->get();

        //End gestion de permissions et role pour developpeurs Entreprise


        $all_roles_in_database = Permission::all()->pluck('name');

            $response =  [
            'element'=>$permission_et_nom ,
            'all_roles_in_database'=>$all_roles_in_database[0],
            'permissions'=>$permissions,

            'list'=>$list2,
            //'nom_permissions'=>$nom_permissions,
            //'permissions_edit'=>$permissions,
            'message' => 'Collecter avec success',
            ];

        return response()->json(
             array($response),
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $permissions = Permission::all();


        return response()->json([
            'permissions'=>$permissions,
            'message' => 'Collecter avec success',
        ]);

        // return Inertia::render('permissions/permission')->with([
        //     'permissions'=>$permissions,
        //     'sucess'=>'Envoyer avec success'
        // ]);
        //

        //$data = DB::table('permissions')->get();
        //return Inertia::render('permissions/permission')->with('data',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'name' => 'required'
        ]);
        $libelle_verifier = Permission::where('name',$request->name)->get();
        // return response()->json([
        //     'message'=>$libelle_verifier,
        // ]);

        if(count($libelle_verifier) == null)
            // $this->permission->create([
            //     'name' => $request->name
            // ]);

            //  $this->permission->create([
            //     'name' => $request->name
            //  ]);
                {
                    $save = Permission::firstOrCreate([
                        'name'=>$request->name,
                        'guard_name' => 'web',
                    ]);
                }




            //enregistrament des entitiees-permissions dans la tablee
            $keywords = preg_split("/[\s,-]+/",$request->name);

            //   return response()->json([
            //             'message'=>  $keywords,
            //         ]);

            $result=DB::table('nom_permissions')->where('libelle',$keywords[1])->get();

            //enregistrer la donne si elle n'existe pas encore
            if(count($result) == null)
            {
                DB::table('nom_permissions')->insert([
                    'libelle'=>$keywords[1],
                ]);
            }


            return response()->json([
                '$result'=>$result,
                'keywords'=>$keywords[1],
                //'$save'=>$save,
                'message' => 'Permission crée avec succes.',
            ]);


            // return redirect()->route('permission')->with('message', 'Permission crée avec succes.');

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
        $edit =  Permission::find($id);

        return response()->json([
            'edit' => $edit ,
            'message' => 'collecté crée avec succes.',
        ]);
        // return Inertia::render('permissions/permission_home',[ 'edit' => $edit]);
        // return Inertia::render('permissions/update_page',[ 'edit' => $edit]);
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
        $libelle_verifier = Permission::where('name',$request->name)->first();
         //echo'<pre>'.$libelle_verifier;
        if(!$libelle_verifier)
        // {

         Permission::find($request->id)->update($request->all());

         //enregistrament des entitiees-permissions dans la tablee
         $keywords = preg_split("/[\s,-]+/",$request->name);

        //  return response()->json([
        //     'message'=>  $keywords,
        // ]);

         $result=DB::table('nom_permissions')->where('libelle',$keywords[1])->get();

         //enregistrer la donne si elle n'existe pas encore
         if(count($result) == null)
         {
             DB::table('nom_permissions')->insert([
                 'libelle'=>$keywords[1],
             ]);
         }

           return response()->json([
            'message' => 'Modification effectue effectue avec success',
        ]);

        //  return redirect()->route('permission')->with('message','Modification effectue effectue avec success');
       //  }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
    //     //
    //     Permission::find($id)->delete($id);

    //     return response()->json([
    //         'message' => 'suppression effectue effectue avec success',
    //     ]);


    //     // return redirect()->route('permission')
    //     //                  ->with('message', 'Permission supprimée avec succes.');
    // }


    public function destroy(Request $request)
    {
        //
       $permission = Permission::find($request->id)->Forcedelete();
           return response()->json([
          'message'=>'suppression reussi'
      ]);

    }
}








// public function index()
// {
//     //role and permissions developpeur
//    // $list1=['facture','devis','bondecommande','versement','emprunt','role','permission','typeparametre','creancier','agence','depense','article','compte'];
//     $list=DB::table('nom_permissions')->select('libelle')->get();

//     for($i=0;$i<count($list);$i++)
//     {
//         $list2[$i] =  $list[$i]->libelle;
//         $permissions[$i] = Permission::where('name','like' ,'%_'.$list2[$i])->get();
//         // $nom_permissions[$i]
//         //$list2[$i] =  $list[$i]->libelle;
//     }



//     // for($i=0;$i<count($list);$i++)
//     // {
//     //     $permissions[$i] = Permission::where('name','like' ,'%_'.$list[$i])->get();
//     //     $nom_permissions[$i]=$list[$i];
//     // }

//     $all_roles_in_database = Permission::all()->pluck('name');

//    // $list=['facture','devis'];

//     // for($i=0;$i<count($all_roles_in_database);$i++)
//     // {
//     //     $echant[$i] = $all_roles_in_database[$i];


//     //     if($list[0] == $echant[0] )
//     //     {
//     //         $myString = 'This is from itsolutionstuff.com website.';
//     //         $contains[$i] = Str::contains($myString, 'itsolutionstuff.com');
//     //     }



//     // }




//    // $group = $all_roles_in_database->groupBy('name','like','%-facture')->first() ;
//     //where('entreprise_id',Auth::user()->entreprise_id);

//         $response =  [
//                //  $contains,
//        // 'list_element'=>$list[0],
//        // 'echant'=>$echant[0],
//         'all_roles_in_database'=>$all_roles_in_database[0],
//         // 'permissions'=>$permissions,
//         // '$nom_permissions'=>$nom_permissions,
//         //'permissions_edit'=>$permissions,
//         'message' => 'Collecter avec success',
//         ];



//     return response()->json([
//         //count($list),
//         'permissions'=>$permissions,
//         'lists'=>$list2,
//       //  $list[0]->libelle,
//        // $list1,

//         'response'=>$response,
//     ]);

//     // return Inertia::render('permissions/permission_home')->with([
//     //     'permissions'=>$permissions,
//     //     'permissions_edit'=>$permissions
//     // ]);

//     //
//     // $data = DB::table('permissions')->get();
//     // if($data)
//     // {
//     //     return Inertia::render('permissions/permission_home')->with('data',$data);
//     // }
//     // return Inertia::render('permissions/permission_home')->with('data',$data);
// }
