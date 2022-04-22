<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Echange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EchangeController extends Controller
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
        $echanges = Echange::all();

        activity()
        //->performedOn($web)
       ->log('Echange-Index')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'auth' => $auth,
            'ticket' => $ticket,
            'echange' => $echanges,
            'message' => 'Echange collectées avec success',
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
        $echanges = Echange::all();

        activity()
        //->performedOn($web)
       ->log('Echange-Form-Create')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'auth' => $auth,
            'ticket' => $ticket,
            'echange' => $echanges,
            'message' => 'Echange collectées avec success',
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
            'ticket_id' => ['required'],

        ]);

        $auth = Auth::user()->entreprise_id;
        //$ticket = Ticket::where('entreprise_id',$auth )->get();

        Echange::create([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'ticket_id' => $request->ticket_id,
        ]);

        activity()
        //->performedOn($web)
       ->log('Echange-Store')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Echange enregistrer avec success',
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
        $edit = Echange::find($id);

        activity()
        //->performedOn($web)
       ->log('Echange-Form-Edit')
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
            'ticket_id' => ['required'],

        ]);

        Echange::find($request->id)->update([
            'libelle' => $request->libelle,
            'description' => $request->description,
            'ticket_id'=> $request->ticket_id,

        ]);

        activity()
        //->performedOn($web)
       ->log('Echange-Update')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Echange Modifié avec success',
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
        $echange=Echange::find($id)->delete();

        activity()
        //->performedOn($web)
       ->log('Echange-Destroy')
       // ->causedBy(Auth::user()->id)
       ->subject(2)
       ->withProperties(['test' => 'value']);

        return response()->json([
            'message' => 'Echange Supprimé avec success',
        ]);

    }
}
