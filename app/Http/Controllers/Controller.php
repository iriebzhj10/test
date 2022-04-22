<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Compte;
use App\Models\Entreprise;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function create()
    {
        //
        //$datas = Compte::all();
        return Inertia::render('Success');

    }

    public function header(){

        // // $entreprise_id=Auth::user()->entreprise_id;
        // // $entreprise= Entreprise::where('id',$entreprise_id)->get();
        // // return Inertia::render('Header1',[

        // //     'entreprise'=> $entreprise,


        //  ]);
    }
}
