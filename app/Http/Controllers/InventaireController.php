<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request; //Inventaire
use App\Models\Inventaire;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventaireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\
     */
    public function index()
    {

        // $inventaires = Inventaire::whereEntreprise_id(Auth::user()->entreprise_id)
        // ->with([
        //     'articles',
        // ])->get();

        
        $inventaires = DB::table('inventaires')
        ->join('article_inventaire', 'article_inventaire.inventaire_id', '=', 'inventaires.id')
        ->join('articles', 'article_inventaire.article_id', '=', 'articles.id')
        ->where('inventaires.entreprise_id',Auth::user()->entreprise_id)
        //->whereNotNull('users.type_user_creancier')
       ->select('articles.*','inventaires.*')
        ->get();

        return response()->json([
            'inventaire'=>$inventaires,
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
        // 	libelle 	description 	agence_id 	entreprise_id 	departement_id 	user_id 	created_user 	updated_user 	status
        $request->validate([
            'libelle' => ['required'],
            'description' => ['required'],
            'article_id'=>['required'],

        ]);

        $inventaire=Inventaire::create([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'agence_id'=>$request->agence_id,
            'status'=>$request->status,
            'entreprise_id'=>Auth::user()->entreprise_id,
            'user_id'=>Auth::user()->id,
            'article_restant' =>$request->article_restant,
            'departement_id '=>$request->departement_id ,
            'created_user'=>auth()->user()->id,
        ]);

        //pivot article_inventaire
        for($i=0;$i<count($request->article_id);$i++)
        {
            DB::table('article_inventaire')->insert([
                Array(
                    'article_id' => $request->article_id[$i],
                    'inventaire_id' => $inventaire->id,
                    'article_restant' =>$request->article_restant,
                )
            ]);
        }

        return response()->json([
            $inventaire,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $request->validate([
            'libelle' => ['required'],
            'description' => ['required'],
            'article_id'=>['required'],

        ]);

        $inventaire=Inventaire::find($request->id)->update([
            'libelle'=>$request->libelle,
            'description'=>$request->description,
            'agence_id'=>$request->agence_id,
            'status'=>$request->status,

            'entreprise_id'=>Auth::user()->entreprise_id,
            'user_id'=>Auth::user()->id,
            'departement_id '=>$request->departement_id ,
            'created_user'=>auth()->user()->id,
        ]);

        //pivot article_inventaire
        for($i=0;$i<$request->count;$i++)
        {
            DB::table('article_inventaire')->find($request->id)->update([
                Array(
                    'article_id' => $request->article_id[$i],
                    'inventaire_id' => $inventaire->id,
                    // ajouter nombre d'article dans la table pivot
                )
            ]);
        }

        return response()->json([
            $inventaire,
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        Inventaire::find($request->id)->delete();
        return response()->json([
            'Messqge'=>'inventaire supprimé avec success',
        ]);
    }
}
