<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $auth = Auth::user()->entreprise_id;
        $ticket = Ticket::where('entreprise_id',$auth )->get();
        $users = User::where("entreprise_id",$auth)->get();
        //$tickets = Ticket::all();

        activity()
        //->performedOn($web)
       ->log('Ticket-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'auth'=> $auth,
            'users' => $users,
            'ticket' => $ticket,
            //'tickets' => $tickets,
            'message' => 'Tickets collectées avec success',
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
        $ticket = Ticket::where('entreprise_id',$auth )->get();
        $users = User::where("entreprise_id",$auth)->get();

        activity()
        //->performedOn($web)
       ->log('Ticket-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

       return response()->json([
        'auth'=> $auth,
        'users' => $users,
        'ticket' => $ticket,
        'message' => 'Ticket collectées avec success',
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
        //
        $request->validate([
            'libelle' => ['required'],
            'description' => ['required'],
           // 'user_id' => ['required'],

        ]);

        $auth = Auth::user()->entreprise_id;
        $users = User::where("entreprise_id",$auth)->get();
        //$ticket = Ticket::where('entreprise_id',$auth )->get();

        Ticket::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'user_id' => $request->user_id,
        ]);

        activity()
        //->performedOn($web)
       ->log('Ticket-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Ticket enregistrer avec success',
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
        $edit =  Ticket::find($id);

        activity()
        //->performedOn($web)
       ->log('Ticket-Form-Edit')
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
    public function update(Request $request, $id)
    {
        //

        $request->validate([
            'libelle' => ['required'],
            'description' => ['required'],
            //'user_id' => ['required'],

        ]);

        Ticket::find($request->id)->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'user_id'=> $request->user_id,

        ]);

        activity()
        //->performedOn($web)
       ->log('Ticket-Update')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Ticket Modifié avec success',
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
        $emprunts=Ticket::find($id)->delete();

        activity()
        //->performedOn($web)
       ->log('Ticket-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Ticket Supprimé avec success',
        ]);
    }
}
