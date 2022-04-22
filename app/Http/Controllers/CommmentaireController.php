<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commmentaire;

class CommmentaireController extends Controller
{
    //
    public function index()
    {

    }

    public function store(Request $request)
    {

        $request->validate([
            // 'client_id'=>['required'],
            // 'employee_id'=>['required'],
            'facture_id'=>['required'],
           // 'facture_id'=>$request->employee_id,
        ]);

        $comment = Commmentaire::create([
            'facture_id'=>$request->facture_id,
            'employee_id'=>$request->employee_id,
            'client_id'=>$request->client_id,
            'created_user'=>  1,//$request->user()->id,
            'entreprise_id'=>  31,//$request->user()->entreprise_id,
            'libelle'=>$request->libelle,
            'commentaire'=>$request->commentaire,
        ]);

        return response()->json([
            'commentaire'=> $comment,
            'message'=> 'effectu2 avec success',
        ]);


        
    }

    public function update(Request $request)
    {

        $request->validate([
           // 'facture_id'=>$request->employee_id,
            'commentaire_id'=>$request->commentaire_id,
        ]);


        $comment = Comment::find($request->commentaire_id)->update([
            'commentaire'=>$request->commentaire,
        ]);

        return response()->json([
            'mesaage'=> 'modifie avec success'
        ]);
        
    }

    public function destroy()
    {
        
    }


}
