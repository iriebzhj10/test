<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use App\Models\User;
use Inertia\Inertia;
use App\Mail\SendMail;
use App\Models\Parametre;
use App\Models\TypeParametre;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     //
    //     // $auth = Auth::user()->entreprise_id;

    //     // $entreprise_id=Auth::user()->entreprise_id;
    //     //whereEntreprise_id(Auth::user()->entreprise_id)->get()->getMedia()
    //     $articles = Article::with(['media'])->where('entreprise_id',Auth::user()->entreprise_id)->get();
    //     //$mediaItems = $articles->getMedia();
    //     // return Inertia::render('Catalogues/Articles/article')->with([
    //     //     'articles'=>$articles,
    //     //     'articles_edit'=>$articles
    //     // ]);

    //     return response()->json([
    //       //  $mediaItems,
    //         $articles,
    //         // 'articles_edit'=>$articles,
    //         'collection reussi'

    //     ],200);
    // }


    public function index()
    {
        //
        // $auth = Auth::user()->entreprise_id;
        $catLib = TypeParametre::whereLibelle('Catégorie')->first();
        $catId =$catLib->id;
        $categorie = Parametre::with('article')->where('entreprise_id',Auth::user()->entreprise_id)
                                            ->where('type_parametre_id',  $catId)->get();
        //return response()->json([$nombre]);
        // $entreprise_id=Auth::user()->entreprise_id;
        //whereEntreprise_id(Auth::user()->entreprise_id)->get()->getMedia()
       // $categorie = Parametre::where('Type_parametre_id',10)->where('entreprise_id',Auth::user()->entreprise_id)->get() ;
        $articles = Article::with(['parametre','factures'])->where('entreprise_id',Auth::user()->entreprise_id)
        ->where('delete_update_at',0)
        ->get();
        $art = Article::with('parametre')->where('entreprise_id',Auth::user()->entreprise_id)->get();
        //$mediaItems = $articles->getMedia();
        // return Inertia::render('Catalogues/Articles/article')->with([
        //     'articles'=>$articles,
        //     'articles_edit'=>$articles
        // ]);

         //START OUMAR********************************************** */
        for($i=0;$i<count($articles);$i++){

            $cat[$i] = Parametre::whereId($articles[$i]->category_id)->get() ;

        }

       // return response()->json(  $articles );



        $artCatalogue = array();

        for($i=0; $i<count($articles); $i++){
            // $articles[$i]->media = null;
            // $articles[$i]->media = 'null';
            // $articles[$i]->media = $articles[$i]->getFirstMediaUrl('image');



            if( count( [$cat[0][0] ] )> 0 )
            {
                if( $articles[$i]->category_id == $cat[$i][0]->id ){

            $elt = [
                'id'=> $articles[$i]->id,
                'libelle'=> $articles[$i]->libelle,
                'prix_vente'=>$articles[$i]->prix_vente,
                'prix_achat'=> $articles[$i]->prix_achat,
                'created_at' => $articles[$i]->created_at,
                'media'=> $articles[$i]->getFirstMediaUrl('image'),
                "category_id"=> $articles[$i]->category_id,
                "parametre"=> $cat[$i] ,

            ];
            }
        }
            array_push($artCatalogue,$elt);
        };

        return response()->json([
          //  $mediaItems,
         // 'articles'=>$art,
          // 'item'=>$item,
           $articles,
          // 'articles_category_id'=>$articles[0]->category_id,
            $artCatalogue,
            $categorie,
           // 'art'=>$article,
           // '$cat[$i]'=>$cat,
            //'para'=> $cat,
            // 'articles_edit'=>$articles,
            'collection reussi'

        ],200);
    }








    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

         //Recupération des domaines d'activié
         $category= TypeParametre::where('libelle',"Categorie")->select('id')
         ->first();




         $categorie= Parametre::where("type_parametre_id",$category->id)
                                ->where('entreprise_id',Auth::user()->entreprise_id)
                                ->get();

            return response()->json($categorie, 200);
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
            'libelle'=>['required'],
            // 'type'=>['required'],
            // 'prix_vente'=>'required',
            // 'action' =>'required',
            // 'prix_achat'=>'required',
            // 'category_id'=>'required'
        ]);


        // **8*****************8*************8*****************8*
        //Start
        if($request->action == 'ancien'){
            $request->validate([
                'category'=>''
            ]);
            $valeur_pa=strval($request->prix_achat);
            $valeur_pa = str_replace(",", ".", $valeur_pa);
            $valeur_pa=doubleval($valeur_pa);

            $valeur_pv=strval($request->prix_vente);
            $valeur_pv = str_replace(",", ".", $valeur_pv);
            $valeur_pv=doubleval($valeur_pv);


            $category = Parametre::whereId($request->category)->first();
            if($category != null){
                $article = Article::firstOrCreate([
                    'libelle'=>$request->libelle,
                    'description'=>$request->description,
                    'poids'=>$request->poids,
                    'type'=>$request->type,
                    'prix_achat'=>$valeur_pa,
                    'prix_vente'=>$valeur_pv,
                    // 'category_id'=>$category_id,
                    'lien_video'=>$request->lien_video,
                    'created_user'=>$request->user()->id,
                    'entreprise_id'=>Auth::user()->entreprise_id,
                    'category_id'=>$category->id,
                ]);

                if($request->file('image'))
                {
                    $article->addMediaFromRequest('image')
                    ->toMediaCollection('image');
                }

                if ($request->file('image')) {
                    return response()->json([
                        'article'=>$article,
                        'article_img'=>$article->getFirstMediaUrl('image'),
                    ]);
                } else {
                    return response()->json([
                        'article'=>$article,
                        'article_img'=>'',
                    ]);
                }
            }



        }
        if($request->action == 'nouveau'){

            $request->validate([
                'categorie'=>'required'
            ]);

            $category = TypeParametre::where('libelle',"Categorie")->select('id')
            ->first();

            $categorie = Parametre::firstOrCreate([
                    'libelle'=>$request->categorie,
                    'entreprise_id'=> Auth::user()->entreprise_id,
                    'type_parametre_id'  =>$request->type_parametre_id,
                    'created_user'  =>Auth::user()->id,
                    //'libelle'=>$request->libelle_cat,
                    //'entreprise_id'=> $request->user()->entreprise_id,
                    'type_parametre_id'=>$category->id,
                    // 'parent_id '=> null,
            ]);

            //conversion des caleur en float( ',' en '.')
                $valeur_pa=strval($request->prix_achat);
                $valeur_pa = str_replace(",", ".", $valeur_pa);
                $valeur_pa=doubleval($valeur_pa);

                $valeur_pv=strval($request->prix_vente);
                $valeur_pv = str_replace(",", ".", $valeur_pv);
                $valeur_pv=doubleval($valeur_pv);

            //creation des articles
            $article = Article::firstOrCreate([
                'libelle'=>$request->libelle,
                'description'=>$request->description,
                'poids'=>$request->poids,
                'type'=>$request->type,
                'prix_achat'=>$valeur_pa,
                'prix_vente'=>$valeur_pv,
                'lien_video'=>$request->lien_video,
                'created_user'=>Auth::user()->id,
                'entreprise_id'=>Auth::user()->entreprise_id,
                'category_id'=>$categorie->id,
            ]);

            if($request->file('image'))
            {
                $article->addMediaFromRequest('image')
                ->toMediaCollection('image');
            }
                if ($request->file('image')) {
                    return response()->json([
                        'article'=>$article,
                        'article_img'=>$article->getFirstMediaUrl('image'),
                    ]);
                } else {
                    return response()->json([
                        'article'=>$article,
                        'article_img'=>'',
                    ]);
                }
                
         

        }
        // else{
        //     return response()->json([
        //         'message'=>'insertion db reussi',$articlesA
        //     ]);
        // }
        //End
        //********8*******************************************8****


       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categorisation(Request $request)
    {
        //
        $request->validate([
            'libelle'=> 'required',
        ]);

$catLib = TypeParametre::whereLibelle('Catégorie')->first();
$catId =$catLib->id;

        $cat = Parametre::firstOrCreate([
                'libelle'=> $request->libelle,
                'description'=> $request->description,
                'created_at'=> Carbon::now(),
                'entreprise_id'=> Auth::user()->entreprise_id,
                'created_user'=> Auth::user()->id,
                'type_parametre_id'=> $catId,
        ]);

        return response()->json([
            'categorie'=>$cat,
            'message'=>'sucess',
         ]);
    }

    public function updateCategorisation(Request $request)
    {
        //
        $request->validate([
            'id'=> 'required',
            'libelle'=> 'required',
        ]);
        $catLib = TypeParametre::whereLibelle('Catégorie')->first();
        $catId =$catLib->id;
        $cat = Parametre::find($request->id)->update([
                'libelle'=> $request->libelle,
                'description'=> $request->description,
                'created_at'=> $request->created_at,
                'entreprise_id'=> Auth::user()->entreprise_id,
                'created_user'=> Auth::user()->id,
                'type_parametre_id'=> $catId,
        ]);


        return response()->json([
            'categorie'=>$cat,
            'message'=>'sucess',
         ]);
    }

    public function deleteCategorisation(Request $request)
    {
        //
       $article = Parametre::find($request->id)->delete();
      return response()->json([
          'message'=>'suppression reussi'
      ]);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        //
        $articles = Article::find($request->id);

        return response()->json([
            'articles',$articles
        ],200);

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

        $request->validate([
            'libelle'=>['required'],
            'type'=>['required'],
            'prix_achat'=>['required'],
            'prix_vente'=>['required'],
        ]);
            /***********************************/

       // **8*****************8*************8*****************8*
        //Start
        if($request->action == 'ancien'){
            $request->validate([
                'category_id'=>''
            ]);

            $valeur_pa=strval($request->prix_achat);
            $valeur_pa = str_replace(",", ".", $valeur_pa);
            $valeur_pa=doubleval($valeur_pa);

            $valeur_pv=strval($request->prix_vente);
            $valeur_pv = str_replace(",", ".", $valeur_pv);
            $valeur_pv=doubleval($valeur_pv);


            // $category = Parametre::where('libelle', $request->category_id)
            //                      ->where('entreprise_id',$request->user()->entreprise_id)->first();

        //    if($category != null){
                $article = Article::find($request->id)->update([
                    'libelle'=>$request->libelle,
                    'description'=>$request->description,
                    'poids'=>$request->poids,
                    'type'=>$request->type,
                    'prix_achat'=>$valeur_pa,
                    'prix_vente'=>$valeur_pv,
                    // 'category_id'=>$category_id,
                    'lien_video'=>$request->lien_video,
                    'created_user'=>Auth::user()->id,
                    'entreprise_id'=>Auth::user()->entreprise_id,
                    'category_id'=>$request->category_id,
                ]);
                //  if ($request->file('image')) {
                //     return response()->json([
                //         'article'=>$article,
                //         'article_img'=>$article->getFirstMediaUrl('image'),
                //     ]);
                // } else {
                //     return response()->json([
                //         'article'=>$article,
                //         'article_img'=>'',
                //     ]);
                // }
                    if ($article = Article::find($request->id)) {

                        if ($request->file('image')) {
                               $article->clearMediaCollection('image');
                        $article->addMediaFromRequest('image')->toMediaCollection('image');
                        }
                    }



                    // if($request->file('image'))
                    // {
                    //     $article->addMediaFromRequest('image')
                    //     ->toMediaCollection('image');
                    // }
                    //     if ($request->file('image')) {
                    //         return response()->json([
                    //             'article'=>$article,
                    //             'article_img'=>$article->getFirstMediaUrl('image'),
                    //         ]);
                    //     } else {
                    //         return response()->json([
                    //             'article'=>$article,
                    //             'article_img'=>'',
                    //         ]);
                    //     }
                        
              
        //    }


           return response()->json([
            'message'=>"update reussi",
            
        ]);
            // else{
            //     return response()->json([
            //         'message'=>'Echec',
            //         'message'=>"Cet article n'a pas de categorie"
            //     ]);

            // }

        }

        if($request->action == 'nouveau'){

            $request->validate([
                'categorie'=>'required'
            ]);

            // $type_categorie = TypeParametre::firstOrCreate([
            //     'libelle'=>'type_categori'.$request->categorie,
            //     'entreprise_id'=> Auth::user()->entreprise_id,
            //     'type_parametre_id'  =>$request->type_parametre_id,
            //     'created_user'  =>Auth::user()->id,
            //     //'libelle'=>$request->libelle_cat,
            //     //'entreprise_id'=> $request->user()->entreprise_id,
            //     //'type_parametre_id'=>10,
            //     // 'parent_id '=> null,
            //  ]);

             $category_new = Parametre::where('libelle', $request->category)
                                 ->where('entreprise_id',$request->user()->entreprise_id)->first();



            $category = TypeParametre::where('libelle',"Catégorie")->select('id')
            ->first();


            $categorie = Parametre::firstOrCreate([
                    'libelle'=>$request->categorie,
                    'entreprise_id'=> Auth::user()->entreprise_id,
                    // 'type_parametre_id'  =>$request->type_parametre_id,
                    'created_user'  =>Auth::user()->id,
                    //'libelle'=>$request->libelle_cat,
                    //'entreprise_id'=> $request->user()->entreprise_id,
                    'type_parametre_id'=>$category->id,
                    // 'parent_id '=> null,
            ]);

            //conversion des caleur en float( ',' en '.')
                $valeur_pa=strval($request->prix_achat);
                $valeur_pa = str_replace(",", ".", $valeur_pa);
                $valeur_pa=doubleval($valeur_pa);

                $valeur_pv=strval($request->prix_vente);
                $valeur_pv = str_replace(",", ".", $valeur_pv);
                $valeur_pv=doubleval($valeur_pv);

            //creation des articles
            $article = Article::find($request->id)->update([
                'libelle'=>$request->libelle,
                'description'=>$request->description,
                'poids'=>$request->poids,
                'type'=>$request->type,
                'prix_achat'=>$valeur_pa,
                'prix_vente'=>$valeur_pv,
                'lien_video'=>$request->lien_video,
                'created_user'=>Auth::user()->id,
                'entreprise_id'=>Auth::user()->entreprise_id,
                'category_id'=> $categorie->id,
            ]);
        
            if ($article = Article::find($request->id)) {

                if ($request->file('image')) {
                       $article->clearMediaCollection('image');
                $article->addMediaFromRequest('image')->toMediaCollection('image');
                }
            }

            return response()->json([
                'message'=>"update reussi",
                
            ]);

        }
        // else{
        //         return response()->json([
        //         'error'=>'Echec',
        //         'message'=>'Veillez renseiger les infos de base(nouveau ou ancien)'
        //         ]);
        // }
        //End
        //********8*******************************************8****


















        // $category = TypeParametre::where('libelle',"Categorie")->select('id')
        // ->first();


        // $categorie = Parametre::find($request->categorie_id)->update([
        //         'libelle'=>$request->categorie,
        //         'entreprise_id'=> Auth::user()->entreprise_id,
        //         'type_parametre_id'  =>$request->type_parametre_id,
        //         'created_user'  =>Auth::user()->id,
        //         //'libelle'=>$request->libelle_cat,
        //         //'entreprise_id'=> $request->user()->entreprise_id,
        //         'type_parametre_id'=>$category->id,
        //         // 'parent_id '=> null,
        // ]);

      /***********************************************/





        //     $valeur_pa = $request->prix_achat;
        //     if (strpos($valeur_pa,',')) {
        //         $valeur_pa=strval($request->prix_achat);
        //         $valeur_pa = str_replace(",", ".", $valeur_pa);
        //         $valeur_pa=doubleval($valeur_pa);
        //     }

        //     $valeur_pv = $request->prix_vente;
        //     if  (strpos($valeur_pv,','))
        //         {
        //             $valeur_pv=strval($request->prix_vente);
        //             $valeur_pv = str_replace(",", ".", $valeur_pv);
        //             $valeur_pv=doubleval($valeur_pv);
        //     }

        // $articles = Article::find($request->id)->update([
        //     'libelle'=>$request->libelle,
        //     'description'=>$request->description,
        //     'poids'=>$request->poids,
        //     'type'=>$request->type,
        //     'prix_achat'=>$valeur_pa,
        //     'prix_vente'=>$valeur_pv,
        //     'lien_video'=>$request->lien_video,
        //     'created_user'=> Auth::user()->id,
        //     'category_id'=>$request->category_id,

        // ]);


        return response()->json([
            'message'=>'update reussi',
        ],200);

        // return response([
        //     'articles'=>$articles,
        //     'message'=>'update reussi',
        // ],200);

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
       $article = Article::find($request->id)->delete();
       if ($article) {
        $article_up = Article::whereId($request->id)->update(['delete_update_at'=>1]);
    }
      return response()->json([
          'message'=>'suppression reussi'
      ]);

    }

    public function mail(Article $articles, User $users)
    {
        //
        $articles = Article::where('created_user',Auth::user()->id)->get();
        $users = User::whereCreated_user(Auth::user()->id)->First();
        //    dd($users->email);
        Mail::to($users->email)->send(new SendMail($articles));

        //    return view('mail/SendMail');
        return back();

        //    return inertia ::render('mail.mail');
    }

    public function envoiCatalogue()
    {
       //with(['media'])->
       $name = 'james';
        $articles = Article::where('entreprise_id',Auth::user()->entreprise_id)->with(['media'])->get();

       // $entreprise_infos = Entreprise::latest()->first();
         Mail::send('catalogueArticle', compact('articles','name'),function ($message)use($articles,$name) {
            $message->from('info@ediqia.com');
            // $message->sender('developpeur@ediqia.com');
            $message->to('iriebzhj1@gmail.com'); //$articles[0]->id
            // $message->cc('john@johndoe.com', 'John Doe');
            // $message->bcc('john@johndoe.com', 'John Doe');
            $message->replyTo('info@ediqia.com'); //developpeur@ediqia.com
            $message->subject('Notre acatalogue est disponible');
            // $message->priority(3);
            // $message->attach('pathToFile');
        });

        return response()->json([
          //  $mediaItems,
        //  '$jojo'=>$jojo,
          'articles'=> $articles,  //getFirstMediaUrl('image'),
            $articles,
            // 'articles_edit'=>$articles,
            'collection reussi'
        ],200);
    }


    public function generateCatalogue()
    {
        $name = 'james';

        $articles = Article::with(['media'])->where('entreprise_id',Auth::user()->entreprise_id)->get();
        return view('catalogueArticle', ['name' => $name, 'relance'=> $relance]);


        return response()->json([
          'articles'=> $articles,  //getFirstMediaUrl('image'),
            $articles,
            'collection reussi'
        ],200);
    }





    public function qrcode(Request $request)
    {


        return response()->json([
            'hello'
        ]);

     return back();


    }



/**Bon mail catalogue */


    public function mailCatalogue(Request $request)
    {

        $request->validate([ 'articleList'=> 'required', ]); //validation

        $data = [  'title' => 'Welcome to ItSolutionStuff.com',   'date' => date('m/d/Y')   ];//unitile

        $article_ids = $request->articleList; //List des articles recu du front

        if( count($article_ids) > 0 )//collect des article pour le catalogue
        {
            for( $i=0; $i<count($article_ids);$i++ )
            {
                $articles[$i] = Article::where('id',$article_ids[$i])->with(['media'])->first(); //Auth::user()->entreprise_id
            }
        }

        // return response()->json([
        //     $articles,
        //     'message'=> " pas de catalogue disponible pour ces article"]);

        if(!$articles )//en cas de non article retouner un message
        {
            return response()->json([ 'messagesssss'=> " pas de catalogue disponible pour ces article"]);
        }



        //collect de l'email du destinataire
        for( $i=0; $i<count($request->client_id);$i++ )
        {
            $user_email[$i] = User::where('id',$request->client_id[$i] )
                            ->where('entreprise_id',Auth::user()->entreprise_id)->get();
        }


        //return response()->json(['mail'=> $user_email[1][0]->email , 'mail1'=> count($user_email) , 'mail3'=> $user_email ]);





        // if($request->client_id[0] != null)
        // {

        //     //->with(['articles' => $articles])             compact(['articles'])
        //     $pdf = PDF::loadView('catalogueArticle') ;

        //     for( $i=0; $i<count($request->client_id);$i++ )
        //     {

        //         Mail::send('catalogueArticle', compact('articles,data'),function ($message)use($articles,$pdf) {
        //             $message->from('developpeur@ediqia.com')    //Auth::user()->email
        //             // $message->sender('developpeur@ediqia.com');
        //             ->to('iriebzhj1@gmail.com')   //$message->to('iriebzhj1@gmail.com');  //$user_email[$i]->email         //$user_email[$i]->email
        //             // $message->cc('john@johndoe.com', 'John Doe');
        //             // $message->bcc('john@johndoe.com', 'John Doe');
        //             ->replyTo('developpeur@ediqia.com')
        //             ->subject('Votre code de connexion');
        //             //->attachData($pdf->output(),"catalogue.pdf");
        //             // $message->priority(3);
        //             // $message->attach('pathToFile');
        //         });
        //     }

        //    // $pdf = PDF::loadHTML("<p>Mon contenu HTML ici</p>");

        // }else{
        //     return response()->json([
        //         'message'=>'veillez renseigner un client',
        //     ]);
        // }


        //*********************************************************************************************

        // return response()->json([
        //     $articles,
        //     'message'=>'send with success avec les mail du frontend',
        //    // 'devis'=>$btnfacture
        //    ]);



        // Frontend ==> list des id articles (is_countable($request->emailList) &&)



        $emails = $request->emailList;
        $messages =  $request->message;

        if( count($user_email) > 0 )
        {
            for( $i=0; $i<count($user_email);$i++ )
            {
                //return response()->json([ $articles ]);
                //$pdf = PDF::loadView('catalogueArticle')->with(['articles'=>$articles]);
                Mail::send('catalogueArticle', compact('articles','messages'),function ($message)use($articles,$emails,$i,$messages,$user_email) {
                    $message->from('developpeur@ediqia.com');
                    // $message->sender('developpeur@ediqia.com');
                    $message->to($user_email[$i][0]->email);
                    // $message->cc('john@johndoe.com', 'John Doe');
                    // $message->bcc('john@johndoe.com', 'John Doe');
                    $message->replyTo('developpeur@ediqia.com');
                    $message->subject('Catalogue de produit');
                   // $message->attachData($pdf->output(),"catalogue.pdf");
                    // $message->priority(3);
                    // $message->attach('pathToFile');
                });
            }

            return response()->json([
                'message'=>'send with success avec les mail du frontend',
               // 'devis'=>$btnfacture
               ]);
        }else{

            return response()->json([
                'message'=>'veiller renseigner les mails des destinataires',
               // 'devis'=>$btnfacture
               ]);

               /***************  */
               //veiller renseigner les mails de destinations
            // a returner un response json simple et enlever la function mail


            Mail::send('catalogueArticle', compact('relance','name'),function ($message)use($relance,$name) {
                $message->from('developpeur@ediqia.com');
                // $message->sender('developpeur@ediqia.com');
                $message->to('iriebzhj1@gmail.com');
                // $message->cc('john@johndoe.com', 'John Doe');
                // $message->bcc('john@johndoe.com', 'John Doe');
                $message->replyTo('developpeur@ediqia.com');
                $message->subject('Catalogue de produit');
                // $message->priority(3);
                // $message->attach('pathToFile');
            });

            return response()->json([
                'message'=>'send with success sans',
               // 'devis'=>$btnfacture
               ]);

        }



    }

        //important
    public function mailCatalogueInfo()
    {
        $name = "james";

        $articles = Article::with(['media'])->where('entreprise_id',Auth::user()->entreprise_id)->get();  //Auth::user()->entreprise_id


        // return response()->json([
        //     $articles[0]
        // ]);
            if($articles){
                return view('catalogueArticle', ['name' => $name , 'articles'=> $articles]);
            }else{
                return response()->json([ 'message' => "il n'existe pas de facture selectionn2 pour le catalogue" ]);
            }

    }



}
