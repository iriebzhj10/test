<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartModuleController extends Controller
{




    public function cartList()
    {
        $cartItems = Cart::all();
        //->whereNull('deleted_at')
        //->where("entreprise_id",Auth::user()->entreprise_id)
        //->get();

        return response()->json([
            $cartItems,
            'cest bon'
        ]);
    }


    public function store(Request $request)
    {
    $jojo = Cart::create([
        'id' => $request->id,
        'libelle' => $request->libelle,
        'montant' => $request->montant,
        'description' => $request->description,
        //'entreprise_id' => Auth::user()->entreprise_id,
        //'created_user' => Auth::user()->id,
    ]);

    if($request->file('image'))
    {
        $jojo->addMediaFromRequest('image')
        ->toMediaCollection('image');
    }

    return response()->json([
        $jojo,
        'cest bon'
    ]);

}

public function update(Request $request)
{
    //$item = Cart::find($request->id);
for($i=0;$i<count($request->libelle);$i++){
    $sol[$i] =Cart::find($request->id[$i])->update([
        'id' => $request->id[$i],
        'libelle' => $request->libelle[$i],
        'montant' => $request->montant[$i],
        'description' => $request->description[$i],

    ]);
}
    $sol =Cart::find($request->id)->update([
        'id' => $request->id,
        'libelle' => $request->libelle,
        'montant' => $request->montant,
        'description' => $request->description,

    ]);

    return response()->json([
        $sol,
        'cest bon'
    ]);
}

public function destroy(Request $request)
{
    Cart::find($request->id)->delete();

    return response()->json([
        'supprime avec succes'
    ]);
}

public function destroyAll()
{
    Cart::clear();

    session()->flash('success', 'All Item Cart Clear Successfully !');

    return response()->json([
        'cest bon'
    ]);
}


















    //

}
