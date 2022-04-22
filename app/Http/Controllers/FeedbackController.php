<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //
    public function index(){
       $feedback = Feedback::all();

       return response()->json([
        'feedback'=> $feedback,
        'message'=>'collecter avec success'
      ]);
    }

    public function store(Request $request){

        $request->validate([ 
            'libelle'=> 'required',
            'text'=> 'required',
        ]);
        

        $store = Feedback::create([
            'libelle'=> $request->libelle,
            'text'=> $request->text,
            'user_id'=> Auth::user()->id,
        ]);

        
        return response()->json([
            'feedback'=> $store,
            'message'=>'enregistrer avec success'
        ]);
    }
}
