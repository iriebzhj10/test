<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $client = DB::table('users')
        ->join('entreprise_user', 'users.id', '=', 'entreprise_user.user_id')
        ->join('entreprises', 'entreprises.id', '=', 'entreprise_user.entreprise_id')
        ->where('entreprises.id',Auth::user()->entreprise_id)  //Auth::user()->entreprise_id $request->entreprise_id
        ->where('users.status_user','client')
        ->select('users.*',)
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
           'client'=>$client,
        //    'listeRole'=> $all_roles_except_a_and_b,
        //   // $all_roles_in_database,
        //     'listeEmploye'=> $user
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
