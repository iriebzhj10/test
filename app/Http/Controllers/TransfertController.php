<?php

namespace App\Http\Controllers;

use App\Models\Transfert;
use App\Http\Requests\StoreTransfertRequest;
use App\Http\Requests\UpdateTransfertRequest;

class TransfertController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTransfertRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransfertRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transfert  $transfert
     * @return \Illuminate\Http\Response
     */
    public function show(Transfert $transfert)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transfert  $transfert
     * @return \Illuminate\Http\Response
     */
    public function edit(Transfert $transfert)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTransfertRequest  $request
     * @param  \App\Models\Transfert  $transfert
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTransfertRequest $request, Transfert $transfert)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transfert  $transfert
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transfert $transfert)
    {
        //
    }
}
