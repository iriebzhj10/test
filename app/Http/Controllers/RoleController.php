<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role ;
//use Spatie\Permission\Contracts\Role as ContractsRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

// use Illuminate\Database\Eloquent\Model;
// use Spatie\Activitylog\Traits\LogsActivity;
// use Spatie\Activitylog\LogOptions;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function __construct(Role $role)
    {
          $this->middleware("auth");
         // $this->middleware(['role:Gestionnaire']);
         $this->role=$role;
    }


    public function index()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        $role_permissions = Role::with('permissions')->get();

        activity()
            //->performedOn($web)
            ->log('Role-index');

        return response()->json([
            'role_permissions'=>$role_permissions,
            'roles' =>  $roles ,
            'permissions' =>  $permissions ,
            'message' => 'Collecter avec success',
        ]);


        // return Inertia::render('Role/role_home')->with(['roles'=>$roles,'permissions'=>$permissions]);
        //dd($roles);


         // //$data = ModelsRole::all();
        // $data = DB::table('roles')->get();
        // if($data)
        // {
        //     return Inertia::render('Role/role_home')->with('data',$data);
        // }
        // return Inertia::render('Role/role_home')->with('data',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $roles = Role::all();
        $permissions = Permission::all();
        $data = Role::with('permissions')->get();

        activity()
             //->performedOn($web)
            ->log('Role-Form-Create')
            ->causedBy(Auth::user()->id)
            ->subject(2)
            ->withProperties(['test' => 'value']);

        return response()->json([
            'data' =>  $data ,
            'roles' =>  $roles ,
            'permissions' =>  $permissions ,
            'message' => 'Collecter avec success',
        ]);

       //dd($permissions);
        // return Inertia::render('Role/role')->with(['roles'=>$roles,'permissions'=>$permissions]);
        // return view('Creer', compact(['roles'=>$roles,'permissions'=>$permissions]));
        // return view('searchmodal', compact('customers'));


        //$data = DB::table('roles')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request,Permission $permission)
    {

        //dd($request->all());
        $this->validate($request,[
            'name'=> 'required|string|unique:roles',
            'permissions'=> 'nullable'
        ]);


       $role = $this->role->create([
        'name' => $request->name,
        'guard_name' => 'web'
         ]);

        $role->givePermissionTo($request->perm);

        // activity('Store_Role_Acitivity')->log("hi");
        // Activity::all()->last()->log_name; //returns 'other-log';

        activity()
        //->performedOn($web)
       ->log('Role-Form-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Role enregistrement effectué avec sucess.',
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

        activity()
            //->performedOn($web)
            ->log('Role-Form-Edit');

        $edit  =  Role::find($id)->get();
        $role = Role::findById($id);
        $edit2  = $role->permissions()->get();




        $role = Role::findById($id);

        return response()->json([
            'edit' =>  $edit ,
            'edit2' =>  $edit2 ,
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
       $test =Role::find($request->id);

         $this->validate($request,[
            'name'=> 'required',
            'permissions'=> 'nullable'
         ]);

         $role =Role::find($request->id)->update([
            'name' => $request->name,
             ]);


          $test->syncPermissions($request->perm);

          return response()->json([
            $role,
            'message' => 'Collecter avec success',
        ]);

        //  return redirect()->route('role')->with('message','Modification effectuée avec succes');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        activity()
        //->performedOn($web)
        ->log('Role-form-Destroy');


        Role::find($id)->delete();
        return response()->json([
            'message' => 'Collecter avec success',
        ]);

    }

    // public function attribue()
        // {
        //     $data = DB::table('roles')->get();//permission
        //     $permission = DB::table('permissions')->get();

        //     if($data)
        //     {
        //         return Inertia::render('Role/attibuee_role')->with(['data' => $data,'permission'=>$permission]);
        //     }
    //     return Inertia::render('Role/attibuee_role')->with(['data' => $data,'permission'=>$permission]);// ('data',[$data,$permission]);
    // }

    // public function rolepermission(Request $request)
        // {
        //     $permission = $request->permission;
        //     $role = $request->role;


        //    // for($i=0; $i<count($permission); $i++)
        //    // {
        //     //    $savedata = [
        //      //       'permission_id ' => $permission[$i],
        //    //         'role_id' => $role ,
        //     //    ];
        //    // }
        //     //DB::table('role_has_permissions')->insert($savedata);

        //     DB::table('role_has_permissions')->insert([
        //         //'permission_id ' => $request->permission,
        //         'role_id ' => $request->role ,
        //      ]);


        //     return redirect()->route('role')
        //         ->with('success', 'Product created successfully.');
    // }
}
