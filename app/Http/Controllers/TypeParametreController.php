<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TypeParametre;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Http\Response;

class TypeParametreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(TypeParametre $typeparametre)
    {
        $this->middleware("auth");
        $this->typeparametre=$typeparametre;
    }

    public function index()
    {
        // parametre

        $data = TypeParametre::all();

        return response()->json([
            'data' =>  $data ,
            'message' => 'Collecter avec success',
        ]);

        //return Inertia::render('parametrage/typeparametre_home')->with('data',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = TypeParametre::all();
       

        return response()->json([
            'data' =>  $data ,
            'message' => 'Collecter avec success',
        ]);

        // return Inertia::render('parametrage/typeparametre_home')->with('data',$data);
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
            'libelle'       => 'required',
            'description'   => [],
            'icone'          =>[]
        ]);

        $libelle_verifier =TypeParametre::where('libelle',$request->libelle)->first();
        // dd($libelle_verifier->toArray());
        if(!$libelle_verifier)
            $outcome = TypeParametre::create([
                'libelle' => $request->libelle,
                'description'=> $request->description,
                'icone'=> $request->icone,
            ]);

            return response()->json([
                'message' => 'enregistrer avec success',
            ]);
    



            
            // return redirect()->route('typeparametre')
            // ->with('message', 'Type parametre creer avec success.');


        //return redirect::back()->with('succes','Tpye Parametres a ete enregistre avec sucess');

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
       $edit =  TypeParametre::find($id);

        return response()->json([
            'data' =>  $edit ,
            'message' => 'Collecter avec success',
        ]);

        // return Inertia::render('parametrage/update_page',[
        //     'edit' => $edit
        // ]);

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

       
    //    $libelle_verifier =TypeParametre::where('libelle',$request->libelle)->first();

    //    if(!$libelle_verifier)
          TypeParametre::find($request->id)->update($request->all());


          return response()->json([
            'message' => 'Modifié avec success',
        ]);

        //   return redirect()->route('typeparametre')
        //  ->with('message', 'Type parametre edité avec success.');

        //return Inertia::render('parametrage/parametre_home');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        TypeParametre::find($request->id)->delete();
      //  return redirect()->route('typeparametre')

      return response()->json([
        'message' => 'Type Parametre supprimé avec succes.',
    ]);


        // return back()->with('message', 'Type Parametre supprimé avec succes.');
        //dd($id);

    }
}
