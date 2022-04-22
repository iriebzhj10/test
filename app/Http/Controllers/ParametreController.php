<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parametre;
use App\Models\TypeParametre;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use App\Models\User;
// use Auth ;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Collection;
use Illuminate\Http\Response;

class ParametreController extends Controller
{
    /**
     * Display a listing of the resource.n!
     *
     *ßb @return \Illuminate\Http\Response
     */
    //  ¡¬public function __construct(Parametre $parametre)
    // {
    //     $this->middleware("auth");
    //     $this->parametre=$parametre;
    //     $this->authorizeResource(Parametre::class);

    // }

    public function parametreList(){
        // $paraList = Parametre::whereNull('entreprise_id')
        // ->whereNull('deleted_at')
        // ->get();
        $paraList =DB::table('parametres')
         ->whereNull('deleted_at')
         ->whereNull('entreprise_id')
         ->get();
        return response()->json([
            'parametre_liste' => $paraList,
        ]);
    }


    public function index(Request $request)
    {
  

            //script pour retourner les parametres en fonction des types parametres

        $type_parametre = TypeParametre::whereId($request->id)->first();
        $type_parametre_id = $type_parametre->id;
        $parametre = Parametre::whereType_parametre_id($type_parametre_id)
        ->get();


        $type_parametre = TypeParametre::whereId($request->id)->first();
        $type_parametre_id = $type_parametre->id;
        $parametre_entreprise = Parametre::whereType_parametre_id($type_parametre_id)
        ->whereEntreprise_id(Auth::user()->entreprise_id)
        ->get();

        //liste des categorie avec les produits et services
        $cat = Parametre::where('type_parametre_id','')->get();

        return response()->json([
      
           'parametre' => $parametre,
           'parametre_entreprise' =>  $parametre_entreprise,
           'categorie'=> $cat,
          

            'message' => 'Collecter avec success3',
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
        $data = TypeParametre::with('parametre')->get();
        $data1 = TypeParametre::all();

        $depense = TypeParametre::whereLibelle('Depense')->first();
        $depenseId = $depense->id;
        $type_depense = parametre::where('type_parametre_id', $depenseId)->get();

        return response()->json([
            // 'data' =>  $data ,
                $depense,
                $depenseId,
                $type_depense,
            // 'data' =>  $data ,
            'message' => 'Collecter avec success2',
        ]);

    }


    public function item(){
        $depense = TypeParametre::whereLibelle('Depense')->first();
        $depenseId = $depense->id;

        $type_depense = parametre::where('type_parametre_id', $depenseId)
        ->whereNull('entreprise_id')
        ->get();

        $type_depense_entreprise = parametre::where('type_parametre_id', $depenseId)
        ->where('entreprise_id',Auth::user()->entreprise_id)
        ->get();

        //duplication des types depenses
    //     $depense = TypeParametre::whereLibelle('Depense')->first();
    //     $depenseId = $depense->id;
    //     $type_depense = parametre::where('type_parametre_id', $depenseId)
    //     ->whereStatus('admin')
    //     ->get();

    // foreach ($type_depense as $item) {
    //     $type_depenseId[]=$item->id;
    //     $depense_replicate = Parametre::find($item->id)->replicate();
    //     $depense_replicate->entreprise_id = Auth::user()->entreprise_id;
    //     $depense_replicate->save();
    // }
          


        return response()->json([
            'message' => 'Collecter avec success1',
            // 'type_depense'=>$type_depense,
                'type_depense_entreprise'=>$type_depense_entreprise,
        ]);
    }


    public function replicate(){
        
        $depense = TypeParametre::whereLibelle('Depense')->first();
        $depenseId = $depense->id;

        $type_depense = parametre::where('type_parametre_id', $depenseId)
        ->whereNull('entreprise_id')
        ->get();


            $data = [];
            for ($i=0; $i <count($type_depense) ; $i++) { 
               $id = $type_depense[$i]->id;

        $replique= Parametre::find($id)->replicate();
               $replique->entreprise_id = Auth::user()->entreprise_id;
               $replique->save();
               array_push($data,$id);
            }
        return response()->json($data);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'libelle'       => 'required',
            'description'   => [],
            'icone'          =>[],
        ]);



        $type_depense_id = TypeParametre::whereLibelle('Depense')->first();
        // $type_depense = TypeParametre::whereDeleted_at('null')->first();
            $type_depense_id = $type_depense_id->id;

            // $depense_exist = Parametre::whereLibelle($request->libelle)
            // ->whereEntreprise_id(Auth::user()->entreprise_id)
            // ->first();
            
            // if (!$depense_exist) {
                $depense = Parametre::firstOrCreate([
                    'libelle'=>$request->libelle,
                    'description'=>$request->description,
                    'icone'=> $request->icone,
                    'type_parametre_id'=>$type_depense_id,
                    'entreprise_id'=>Auth::user()->entreprise_id,
                    'created_user'=>Auth::user()->id
                ]);
                return response()->json([
                    'depense'=> $depense,
                    'insertion reussi',
                    ] ,200);

            // }else {
            //     return response()->json([
            //         'depense existe déjà',
            //         $depense_exist ,
            //         ] ,200);
            // }

          



        //dd($typePara->id);
        //return redirect::back()->with('message','Enregistrer avec Succes');

        // return redirect()->route('parametre')
        // ->with('message', 'Product created successfully.');

    }


    public function storeAdmin(Request $request){
        $request->validate([
            'libelle'       => 'required',
            'description'   => [],
            'icone'          =>[],
        ]);

                     $type_parametre = TypeParametre::whereId($request->id)->first();
                          $type_parametre_id = $type_parametre->id;

                              $parametre = Parametre::firstOrCreate([
                                  'libelle' => $request->libelle,
                                  'description'=> $request->description,
                                  'icone'=> $request->icone,
                                  'type_parametre_id'=>$type_parametre_id,
                                  'created_user'=>auth()->user()->id,
                                  'parent_id' =>$request->domaineId,
                                //   'status'=>'admin',
                                //   'entreprise_id'=>Auth::user()->entreprise_id,
                              ]);

                              $replique= Parametre::find($parametre->id)->replicate();
                              $replique->entreprise_id = Auth::user()->entreprise_id;
                              $replique->save();

                            return response()->json([
                                      'message' => 'Enregistrement effectué avec success.',
                                      'infos'=>  $parametre
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
      //  $cc = Parametre::type_parametres()->with(['parametre']);

        $edit =  TypeParametre::find($id);
        $edit2 = Parametre::where('id', $edit->type_parametre_id )->get();
       // echo '<pre>'.$edit;

       return response()->json([
        'edit' =>  $edit ,
        'edit2' =>  $edit2 ,
        'message' => 'modification effectué avec  success.',
    ]);
    // dd($cc);
        // return Inertia::render('parametrage/update_type_page',[
        //     'edit' => $edit,
        //     'edit2' =>$edit2,
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
        //
        $request->validate([
            'libelle'       => ['required'],
            'description'   => [],
            'icone'          =>[]
        ]);

        //$typePara = TypeParametre::where('libelle',$request->edit2)->first();
        // $similaire = Parametre::where('libelle',$request->libelle);//->where('type_parametre_id',$request->id)->first();

        // if(!$similaire)
        Parametre::find($request->id)->update($request->all());

        return response()->json([
            'message' => 'update effectué avec  success.',
        ]);
        // return redirect()->route('parametre')->with('message','enregistrer avec success');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {


        Parametre::find($request->id)->delete();

        return response()->json([
          'message' => 'Parametre supprimé avec succes.',
      ]);



        // return redirect()->route('parametre')
        //                  ->with('message', 'Product created successfully.');
    }






    public function collect($id)
    {
        //$edit =  Parametre::find($id);
        $solution = Parametre::where('id', $id)->get();
        //$solution = Parametre::where('type_parametre_id', $id)->get();
        //dd( $solution );
       // echo '<pre>'.$edit;

       return response()->json([
        'solution ' => $solution ,
        'message' => 'update effectué avec  success.',
    ]);

        // return Inertia::render('parametrage/parametre_home',[
        //     'solution ' => $solution ,
        // ]);
    }


    public function search($id)
    {
            // $resultat = Parametre::where('type_parametre_id',$id)->get();
            // $data_1 = Typeparametre::all();
            //dd($data_1)
            //return back()->with(['resultat ' => $resultat]);
            //dd($resultat->toArray());
           // return Inertia::render('parametrage/para')->with(['resultat ' => $resultat ,'data_1 ' => $data_1 ]);


            // $clients = User::where('created_user',Auth::user()->id)->get();
            $resultat = Parametre::where('type_parametre_id',$id)->get();
            $data_1 = Typeparametre::all();


            return response()->json([
                'resultat'=>$resultat,
                'data_1'=>$data_1,
                'message' => 'update effectué avec  success.',
            ]);

    }



}
