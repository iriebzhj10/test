<?php
use Inertia\Inertia;
use App\Models\Article;
use Illuminate\Http\Request;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ProspectionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\ParametreController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\Gestion_userController;

use App\Http\Controllers\CartModuleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// rediriger sur cette page pour unevisualiser les pages des relances    collectDeCommentaire
Route::post('/collectDeFichier','App\Http\Controllers\FactureController@collectDeFichier')->name('facture.collectDeFichier');
Route::post('/ajoutDeCommentaire','App\Http\Controllers\FactureController@ajoutDeCommentaire')->name('facture.ajoutDeCommentaire');
Route::post('/ajoutDeFichierfacture','App\Http\Controllers\FactureController@ajoutDeFichier')->name('facture.ajoutDeFichier');
Route::post('/updateDeFichierfacture','App\Http\Controllers\FactureController@updateDeFichier')->name('facture.updateDeFichier');
Route::post('/deleteDeFichier','App\Http\Controllers\FactureController@deleteDeFichier')->name('facture.deleteDeFichier');
Route::post('/collectDeCommentaire','App\Http\Controllers\FactureController@collectDeCommentaire')->name('facture.collectDeCommentaire');
Route::post('/updateDeCommentaire','App\Http\Controllers\FactureController@updateDeCommentaire')->name('facture.updateDeCommentaire');
Route::post('/deleteDeCommentaire','App\Http\Controllers\FactureController@deleteDeCommentaire')->name('facture.deleteDeCommentaire');
//relance sending mail

Route::post('/mailRelance','App\Http\Controllers\FactureController@mailRelance')->name('facture.mailRelance');
Route::get('/mailRelanceInfo','App\Http\Controllers\FactureController@mailRelanceInfo')->name('facture.mailRelanceInfo');
//catalogue sending mail
Route::post('/mailCatalogue','App\Http\Controllers\ArticleController@mailCatalogue')->name('facture.mailCatalogue');
Route::get('/mailCatalogueInfo','App\Http\Controllers\ArticleController@mailCatalogueInfo')->name('facture.mailCatalogueInfo');

Route::get('/article/envoiCatalogue', 'App\Http\Controllers\ArticleController@envoiCatalogue')->name('article.envoiCatalogue');

Route::get('/prospect', [ProspectionController::class,'indexProspect']);
Route::post('/prospect/store', [ProspectionController::class,'createProspect']);
Route::post('/prospect/newProspect', [ProspectionController::class,'addNewProspect']);
Route::post('/prospect/update', [ProspectionController::class,'updateProspect']);
Route::post('/prospect/destroy', [ProspectionController::class,'deleteProspect']);

Route::get('/prospection', [ProspectionController::class,'index']);
Route::post('/prospection/store', [ProspectionController::class,'store']);
Route::post('/prospection/update', [ProspectionController::class,'update']);
Route::post('/prospection/destroy', [ProspectionController::class,'destroy']);








/*
|--------------------------------------------------------------------------
| Web Routes *********COMPTES*************
|--------------------------------------------------------------------------
|
|
|
|
*/
Route::post('/commentaire/store','App\Http\Controllers\CommmentaireController@store')->name('facture.factureCommentsStore');
//liste detail d un employe

// Route::get('/detail_employe', [UserController::class,'index']);
Route::get('/detail_employe', [AuthController::class,'index1']);
Route::post('/resetPassword', [AuthController::class,'resetUserPassword']);


// Route::get('/ind/jojo', [Controller::class,'index']);
Route::get('/liste_employee', [AuthController::class,'index']);
Route::get('/user_info', [AuthController::class,'user_info']);
Route::post('/register', [AuthController::class,'register']);
Route::post('/registerOriginal', [AuthController::class,'registerOriginal']);
Route::get('/verification', [AuthController::class,'Verification']);



Route::post('/Update_Profil_Employe', [AuthController::class,'updateEmployeProfil']);
Route::post('/Update_Paiemment_Employe', [AuthController::class,'UpdatePaiemmentEmploye']);
Route::post('/Update_Emploi', [AuthController::class,'UpdateEmploi']);
Route::post('/urgence_user', [AuthController::class,'UrgenceUser']);
Route::get('/paiemment_Employe', [AuthController::class,'paiemmentEmploye']);






Route::post('/users_info', [AuthController::class,'index2']);  //checktokens
Route::post('/update_Users', [AuthController::class,'UpdateUsers']);
Route::post('/update_Entreprise', [AuthController::class,'updateEntreprise']);
Route::post('/update_presentation', [AuthController::class,'updatePresentation']);
Route::get('/checktokens', [AuthController::class,'checktokens']);
Route::post('/checkpass',[AuthController::class,'checkPass']);


//FEEDBACK
Route::get('/feedback', [FeedbackController::class,'index']);
Route::post('/feedback/store', [FeedbackController::class,'store']);


Route::post('/createUser', [AuthController::class,'createUser']);
Route::post('/updateUser', [AuthController::class,'updateUser']);
// Route::post('/updateUser', [AuthController::class,'updateUser']);
Route::post('/reinitUser', [AuthController::class,'reinitUser']);
Route::post('/employe/destroy', 'App\Http\Controllers\AuthController@destroy')->name('employe.delete');


// Route::get('/index1', [Gestion_userController::class,'index']);
// Route::post('/createUser1', [Gestion_userController::class,'createUser']);
// Route::post('/updateUser1', [Gestion_userController::class,'updateUser']);
// Route::post('/reinitUser1', [Gestion_userController::class,'reinitUser']);

// Route::post('/createUser', [AuthController::class,'createUser']);
// Route::post('/updateUser', [AuthController::class,'updateUser']);
// Route::post('/reinitUser', [AuthController::class,'reinitUser']);

// Route::post('/login/{entreprise_code}', [AuthController::class,'login']);  updateUser  reinitUser
Route::post('/login', [AuthController::class,'login']);
Route::post('/loginOriginal', [AuthController::class,'loginOriginal']);
Route::post('/login/ajuster', [AuthController::class,'loginAjuster']);
Route::get('/user_createur', [AuthController::class,'user_createur']);
Route::get('/user_connecte', [AuthController::class,'user_connecte']);  //remoutlylogout
Route::post('/remoutlylogout', [AuthController::class,'remoutlylogout']);

Route::post('/loginTest', [AuthController::class,'loginTest']); 

 // loginTest




// Route::group(['middleware'=>['auth:sanctum']], function () {
//     Route::post('/logout', [AuthController::class,'logout']);

// });

//Route::get('/facture/pdf', 'App\Http\Controllers\FactureController@facturePdf')->name('facture.facturePdf');  //facture pdf


Route::middleware(['auth:sanctum'])->group(function () {


      //Auth::logout
    Route::post('/logout', [AuthController::class,'logout']);

     //Remboursement RemboursementController remboursement
     Route::get('/remboursement', 'App\Http\Controllers\RemboursementController@index')->name('remboursement');
     Route::get('/remboursement/create', 'App\Http\Controllers\RemboursementController@create')->name('remboursement.create');
     Route::post('/remboursement/store', 'App\Http\Controllers\RemboursementController@store')->name('remboursement.store');
     Route::delete('/remboursement/destroy{id}', 'App\Http\Controllers\RemboursementController@destroy')->name('remboursement.delete1');
     Route::get('/remboursement/edit/{id}', 'App\Http\Controllers\RemboursementController@edit')->name('remboursement.edit');
     Route::post('/remboursement/update', 'App\Http\Controllers\RemboursementController@update')->name('remboursement.update');

     Route::post('/client/destroy', 'App\Http\Controllers\ClientController@destroy')->name('client.delete');

    //Client
        Route::get('/client', 'App\Http\Controllers\ClientController@index')->name('client');
        Route::get('/client/all', 'App\Http\Controllers\ClientController@customer_filter')->name('client.all');
        Route::get('/client/create', 'App\Http\Controllers\ClientController@create')->name('client.create');
        Route::post('/client/store', 'App\Http\Controllers\ClientController@store')->name('client.store');
        Route::delete('/client/destroy{id}', 'App\Http\Controllers\ClientController@destroy')->name('client.delete1');
        Route::get('/client/edit/{id}', 'App\Http\Controllers\ClientController@edit')->name('client.edit');
        Route::post('/client/update', 'App\Http\Controllers\ClientController@update')->name('client.update');
        Route::post('/client/destroy', 'App\Http\Controllers\ClientController@destroy')->name('client.delete');
        Route::post('/client/destroy', 'App\Http\Controllers\ClientController@destroy')->name('client.delete');
        Route::get('/client/CollectDeCommentaireClient', 'App\Http\Controllers\ClientController@CollectDeCommentaireClient')->name('client.CollectDeCommentaireClient');
        Route::post('/client/historique', 'App\Http\Controllers\ClientController@historique')->name('client.historique');

        //customer_filter

        //Fournisseur
         Route::get('/fournisseur', 'App\Http\Controllers\FournisseurController@index')->name('fournisseur');
         Route::get('/fournisseur/create', 'App\Http\Controllers\FournisseurController@create')->name('fournisseur.create');
         Route::post('/fournisseur/store', 'App\Http\Controllers\FournisseurController@store')->name('fournisseur.store');
         Route::delete('/fournisseur/destroy{id}', 'App\Http\Controllers\FournisseurController@destroy')->name('fournisseur.delete1');
         Route::get('/fournisseur/edit/{id}', 'App\Http\Controllers\FournisseurController@edit')->name('fournisseur.edit');
         Route::post('/fournisseur/update', 'App\Http\Controllers\FournisseurController@update')->name('fournisseur.update');
         Route::post('/fournisseur/destroy', 'App\Http\Controllers\FournisseurController@destroy')->name('fournisseur.delete');



    //Previsions
        Route::get('/prevision', 'App\Http\Controllers\PrevisionController@index')->name('prevision');
        Route::get('/prevision/create', 'App\Http\Controllers\PrevisionController@create')->name('prevision.create');
        Route::post('/prevision/store', 'App\Http\Controllers\PrevisionController@store')->name('prevision.store');
        Route::delete('/prevision/destroy{id}', 'App\Http\Controllers\PrevisionController@destroy')->name('prevision.delete1');
        Route::get('/prevision/edit/{id}', 'App\Http\Controllers\PrevisionController@edit')->name('prevision.edit');
        Route::post('/prevision/update', 'App\Http\Controllers\PrevisionController@update')->name('prevision.update');

        Route::post('/prevision/destroy', 'App\Http\Controllers\ClientController@destroy')->name('prevision.delete');



    //Article
        Route::get('/SendMail', 'App\Http\Controllers\ArticleController@mail')->name('article');
        Route::get('/article', 'App\Http\Controllers\ArticleController@index')->name('article');
        Route::get('/article/create', 'App\Http\Controllers\ArticleController@create')->name('article.create');
        Route::get('/article/edit/{id}', 'App\Http\Controllers\ArticleController@edit')->name('article.edit');
        Route::post('/article/store', 'App\Http\Controllers\ArticleController@store')->name('article.store');
        Route::post('/article/categorisation', 'App\Http\Controllers\ArticleController@categorisation')->name('article.categorisation');
        Route::post('/article/updateCategorisation', 'App\Http\Controllers\ArticleController@updateCategorisation')->name('article.updateCategorisation');
        Route::post('/article/deleteCategorisation', 'App\Http\Controllers\ArticleController@deleteCategorisation')->name('article.deleteCategorisation');
        Route::post('/article/update', 'App\Http\Controllers\ArticleController@update')->name('article.update');
        Route::post('/article/destroy', 'App\Http\Controllers\ArticleController@destroy')->name('article.destroy');



    //Taxe
         Route::get('/taxe', 'App\Http\Controllers\TaxeController@index')->name('taxe');
         Route::get('/taxe/create', 'App\Http\Controllers\TaxeController@create')->name('taxe.create');
         Route::post('/taxe/store', 'App\Http\Controllers\TaxeController@store')->name('taxe.store');
         Route::post('/taxe/destroy', 'App\Http\Controllers\TaxeController@destroy')->name('taxe.destroy');
         Route::post('/taxe/update', 'App\Http\Controllers\TaxeController@update')->name('taxe.update');


     //Type-parametre
        Route::get('/type-parametre', 'App\Http\Controllers\TypeParametreController@index')->name('typeparametre.create');
        Route::get('/type-parametre/create', 'App\Http\Controllers\TypeParametreController@create')->name('typeparametre.create');
        Route::post('/type-parametre/store', 'App\Http\Controllers\TypeParametreController@store')->name('typeparametre.store');
        Route::post('/type-parametre/edit/', 'App\Http\Controllers\TypeParametreController@edit')->name('typeparametre.update');
        Route::post('/type-parametre/update/', 'App\Http\Controllers\TypeParametreController@update')->name('typeparametre.update');
        Route::post('/type-parametre/destroy/', 'App\Http\Controllers\TypeParametreController@destroy')->name('typeparametre.destroy');

    //parametrage (typeparametres & parametres)  /parametre/search/
    Route::get('/parametre/replicate', 'App\Http\Controllers\ParametreController@replicate');

          Route::get('/parametreListe', 'App\Http\Controllers\ParametreController@parametreList')->name('parametre.liste');
          Route::post('/parametre', 'App\Http\Controllers\ParametreController@index')->name('parametre');
          Route::get('/parametre/create', 'App\Http\Controllers\ParametreController@create')->name('parametre.create');
          Route::get('/parametre/item', 'App\Http\Controllers\ParametreController@item')->name('parametre.item');
          Route::post('/parametre/store', 'App\Http\Controllers\ParametreController@store')->name('parametre.store');
          Route::post('/parametre/storeAdmin', 'App\Http\Controllers\ParametreController@storeAdmin')->name('parametre.storeAdmin');
          Route::post('parametre/destroy/', 'App\Http\Controllers\ParametreController@destroy')->name('parametre.destroy');
          Route::post('parametre/edit/{id}', 'App\Http\Controllers\ParametreController@edit')->name('parametre.update');
          Route::post('parametre/update/', 'App\Http\Controllers\ParametreController@update')->name('parametre.update');
          Route::post('/parametre/{id}', 'App\Http\Controllers\ParametreController@collect')->name('parametre.collect');
        //   Route::post('/parametre/{id}', 'App\Http\Controllers\ParametreController@search')->name('parametre.search');
        //   Route::get('/parametre', 'App\Http\Controllers\ParametreController@search')->name('parametre.search');

    //rols et permissions --->
        Route::get('/role', 'App\Http\Controllers\RoleController@index')->name('role');
        Route::get('/role/create', 'App\Http\Controllers\RoleController@create')->name('role.create');
        Route::post('/role/store', 'App\Http\Controllers\RoleController@store')->name('role.store');
        Route::get('/role/edit/{id}', 'App\Http\Controllers\RoleController@edit')->name('role.edit');
        Route::get('/role/{id}', 'App\Http\Controllers\RoleController@edit')->name('role.edit');
        Route::post('/role/update', 'App\Http\Controllers\RoleController@update')->name('role.update');
        Route::post('/role/destroy', 'App\Http\Controllers\RoleController@destroy')->name('role.delete');

    //permissions --->
          Route::get('/permission', 'App\Http\Controllers\PermissionController@index')->name('permission');
          Route::get('/permission/create', 'App\Http\Controllers\PermissionController@create')->name('permission.create');
          Route::post('/permission/store', 'App\Http\Controllers\PermissionController@store')->name('permission.store');
          Route::get('/permission/edit/{id}', 'App\Http\Controllers\PermissionController@edit')->name('permission.edit');
          Route::get('/permission/{id}', 'App\Http\Controllers\PermissionController@edit')->name('permission.edit');
          Route::post('/permission/update', 'App\Http\Controllers\PermissionController@update')->name('permission.update');
          Route::post('/permission/destroy', 'App\Http\Controllers\PermissionController@destroy')->name('permission.delete');

    //Depenses
        //  Route::resource('/depense', 'App\Http\Controllers\DepenseController');
        Route::get('/test',[DepenseController::class,'test']);
        Route::post('/depense', 'App\Http\Controllers\DepenseController@index')->name('depense.index');
        Route::post('/depenseR', 'App\Http\Controllers\DepenseController@dateR')->name('depense.dateR');
        Route::post('/depense/item', 'App\Http\Controllers\DepenseController@item')->name('depense.item');
        Route::post('/depense/store', 'App\Http\Controllers\DepenseController@store')->name('depense.store');
        Route::post('/depense/storeRecurrente', 'App\Http\Controllers\DepenseController@storeRecurrente')->name('depense.storeRecurrente');
        Route::post('/depense/storeGroupe', 'App\Http\Controllers\DepenseController@storeGroupe')->name('depense.storeGroupe');
        Route::post('/depense/storeReglement', 'App\Http\Controllers\DepenseController@storeReglement')->name('depense.storeReglement');
        Route::post('/depense/update', 'App\Http\Controllers\DepenseController@update')->name('depense.update');
        Route::post('/depense/destroy', 'App\Http\Controllers\DepenseController@destroy')->name('depense.destroy');
        Route::get('/depense/edit', 'App\Http\Controllers\DepenseController@edit')->name('role.edit');
                    //Type depense
                Route::post('/type_depense/store', 'App\Http\Controllers\DepenseController@type_depense_store')->name('type_depense.store');
                Route::post('/type_depense/update', 'App\Http\Controllers\DepenseController@type_depense_update')->name('type_depense.update');
                Route::post('/type_depense/destroy', 'App\Http\Controllers\DepenseController@type_depense_destroy')->name('type_depense.destroy');

        //Transaction TransactionController
        Route::get('/transaction', 'App\Http\Controllers\TransactionController@index')->name('transaction.index');





   //Depensescop
        //  Route::resource('/depense', 'App\Http\Controllers\DepenseController');
        //  Route::post('/depense/store', 'App\Http\Controllers\DepenseController@store')->name('depense.store');
        //  Route::patch('/depense/update/{id}', 'App\Http\Controllers\DepenseController@update')->name('depense.update');



    //Comptes
        //  Route::resource('/compte', 'App\Http\Controllers\CompteController');
         Route::get('/compte', 'App\Http\Controllers\CompteController@index')->name('compte.index');
         Route::post('/compte/transfert', 'App\Http\Controllers\CompteController@transfert')->name('compte.transfert');
         Route::post('/compte/store', 'App\Http\Controllers\CompteController@store')->name('compte.store');
         Route::post('/compte/update', 'App\Http\Controllers\CompteController@update')->name('compte.update');
         Route::post('/compte/destroy', 'App\Http\Controllers\CompteController@destroy')->name('compte.destroy');
         Route::post('/compte/edit', 'App\Http\Controllers\CompteController@edit')->name('compte.edit');


    //Echeanciers
         Route::get('/echeancier', 'App\Http\Controllers\EcheancierController@index')->name('echeancier');
         Route::post('/echeancier/store', 'App\Http\Controllers\EcheancierController@store')->name('echeancier.store');
         Route::patch('/echeancier/update/{id}', 'App\Http\Controllers\EcheancierController@update')->name('echeancier.update');
         Route::delete('/echeancier/destroy/{id}', 'App\Http\Controllers\EcheancierController@destroy')->name('echeancier.delete');

    //Departements
        // Route::resource('/departement', 'App\Http\Controllers\DepartementController');
         Route::get('/departement', 'App\Http\Controllers\DepartementController@index')->name('departement');
         Route::get('/departement/userless', 'App\Http\Controllers\DepartementController@index1')->name('departement'); // liste user sans departement
         Route::post('/departement/store', 'App\Http\Controllers\DepartementController@store')->name('departement.store');
         Route::post('/departement/update', 'App\Http\Controllers\DepartementController@update')->name('departement.update');
         Route::post('/departement/destroy', 'App\Http\Controllers\DepartementController@destroy')->name('departement.delete');

         Route::post('/departement/ajoutDeCommentaireDepartement', 'App\Http\Controllers\DepartementController@ajoutDeCommentaireDepartement')->name('departement.store');
         Route::post('/departement/collectDeCommentaireDepartement', 'App\Http\Controllers\DepartementController@collectDeCommentaire')->name('departement.store');
         Route::post('/departement/ajoutDeFichierDepartement', 'App\Http\Controllers\DepartementController@ajoutDeFichierDepartement')->name('departement.store');
         Route::post('/departement/collectDeFichierDepartement', 'App\Http\Controllers\DepartementController@collectDeFichierDepartement')->name('departement.store');



    //Agences
       // Route::resource('/agence','App\Http\Controllers\AgenceController');
        Route::get('/agence', 'App\Http\Controllers\AgenceController@index')->name('agence');
        Route::get('/agence/create', 'App\Http\Controllers\AgenceController@create')->name('agence.create');
        Route::get('/agence/edit/{id}', 'App\Http\Controllers\AgenceController@edit')->name('agence.edit');
        Route::post('/agence/store', 'App\Http\Controllers\AgenceController@store')->name('agence.store');
        Route::delete('/agence/destroy/{id}', 'App\Http\Controllers\AgenceController@destroy')->name('agence.destroy');
        Route::patch('/agence/update/{id}', 'App\Http\Controllers\AgenceController@update')->name('agence.update');

    //Entreprise
        Route::get('/entreprise', 'App\Http\Controllers\EntrepriseController@index')->name('entreprise');
        Route::get('/entreprise_info', 'App\Http\Controllers\EntrepriseController@index1')->name('entreprise_info');
        Route::get('/entreprise/create', 'App\Http\Controllers\EntrepriseController@create')->name('entreprise.create');
        Route::post('/entreprise/store', 'App\Http\Controllers\EntrepriseController@store')->name('entreprise.store');



        Route::post('/update_logo', 'App\Http\Controllers\EntrepriseController@updateLogo');
        Route::post('add_cover', 'App\Http\Controllers\EntrepriseController@addCover');
        Route::post('/ajout_entete', 'App\Http\Controllers\EntrepriseController@ajoutEntete');
        Route::post('/update_entete', 'App\Http\Controllers\EntrepriseController@updateEntete');
        Route::get('/entreprise/edit/{id}', 'App\Http\Controllers\EntrepriseController@edit')->name('entreprise.edit');
        Route::patch('/entreprise/update/{id}', 'App\Http\Controllers\EntrepriseController@update')->name('entreprise.update');
        Route::delete('/entreprise/destroy/{id}', 'App\Http\Controllers\EntrepriseController@destroy')->name('entreprise.delete');
        Route::get('/entreprise/lien', 'App\Http\Controllers\EntrepriseController@lien')->name('entreprise_lien');

        Route::get('/entreprise/email', 'App\Http\Controllers\EntrepriseController@email')->name('entreprise.email');
        Route::get('/entreprise/analysis', 'App\Http\Controllers\EntrepriseController@analysis')->name('entreprise.analysis');


    //Projet
//       Route::resource('/projet', 'App\Http\Controllers\ProjetController');
        //Route::resource('/projet','App\Http\Controllers\ProjetController');
        Route::get('/projet', 'App\Http\Controllers\ProjetController@index')->name('projet');
        Route::get('/projet/create', 'App\Http\Controllers\ProjetController@create')->name('projet.create');
        Route::get('/projet/edit', 'App\Http\Controllers\ProjetController@edit')->name('projet.edit');
        Route::post('/projet/store', 'App\Http\Controllers\ProjetController@store')->name('projet.store');
        Route::post('/projet/destroy', 'App\Http\Controllers\ProjetController@destroy')->name('projet.destroy');
        Route::post('/projet/update', 'App\Http\Controllers\ProjetController@update')->name('projet.update');

    //Echeanciers    checkenvoi
        Route::get('/echeancier', 'App\Http\Controllers\EcheancierController@index')->name('echeancier');
        Route::get('/echeancier/create', 'App\Http\Controllers\EcheancierController@create')->name('echeancier.create');
        Route::post('/echeancier/store', 'App\Http\Controllers\EcheancierController@store')->name('echeancier.store');
        Route::get('/echeancier/edit/{id}', 'App\Http\Controllers\EcheancierController@edit')->name('echeancier.edit');
        Route::patch('/echeancier/update/{id}', 'App\Http\Controllers\EcheancierController@update')->name('echeancier.update');
        Route::delete('/echeancier/destroy/{id}', 'App\Http\Controllers\EcheancierController@destroy')->name('echeancier.delete');

        Route::get('/echeancier/checkenvoi/{id}', 'App\Http\Controllers\EcheancierController@checkenvoi')->name('echeancier.checkenvoi');
        Route::post('/echeancier/envoiauto/{id}', 'App\Http\Controllers\EcheancierController@envoiauto')->name('echeancier.envoiauto');
        Route::patch('/echeancier/cancel/{id}', 'App\Http\Controllers\EcheancierController@cancel')->name('echeancier.cancel');

    //Facture   changerEtatDeFacture
        Route::get('/client_facture/{id}', 'App\Http\Controllers\FactureController@client_facture')->name('client_facture');
        Route::get('/facture', 'App\Http\Controllers\FactureController@index')->name('facture.index');
        Route::get('/facture/create', 'App\Http\Controllers\FactureController@create')->name('facture.create');
        Route::post('/facture/changerEtatDeFacture', 'App\Http\Controllers\FactureController@changerEtatDeFacture')->name('facture.changerEtatDeFacture');
        Route::post('/facture/store', 'App\Http\Controllers\FactureController@store')->name('facture.store');
        Route::get('/facture/preview/{id}', 'App\Http\Controllers\FactureController@preview')->name('facture.preview');
        Route::get('/facture/edit/{id}', 'App\Http\Controllers\FactureController@edit')->name('facture.edit');
        Route::post('/facture/update', 'App\Http\Controllers\FactureController@update')->name('facture.update');
        Route::post('/facture/destroy', 'App\Http\Controllers\FactureController@destroy')->name('facture.destroy');
        Route::get('/facture/items', 'App\Http\Controllers\FactureController@items')->name('facture.items');
        Route::post('/facture/change', 'App\Http\Controllers\FactureController@btnfacture')->name('facture.change');
        // Route::post('/facture/email', 'App\Http\Controllers\FactureController@factureEmail')->name('facture.email');
        Route::post('/facture/sendmailpdf', 'App\Http\Controllers\FactureController@facturePdf')->name('facture.sendmailpdf');
        Route::get('/facture/sumVersement', 'App\Http\Controllers\FactureController@sumVersement')->name('facture.sumVersement');//versement effectue par un client
        Route::post('/relanceInfo', 'App\Http\Controllers\FactureController@relanceInfo')->name('facture./relanceInfo');
        Route::post('/historique', 'App\Http\Controllers\FactureController@factureactivity_log')->name('facture.factureactivity_log');
        Route::post('/versementFacture','App\Http\Controllers\FactureController@reglementFacture')->name('facture.reglementFacture');

        Route::post('/listFactureClient','App\Http\Controllers\FactureController@listFactureClient')->name('facture.listFactureClient');





        //CommmentaireController   CommmentaireController
        //Route::post('/commentaire/store','App\Http\Controllers\CommmentaireController@store')->name('facture.factureCommentsStore');
        Route::post('/commentaire/update','App\Http\Controllers\CommmentaireController@store')->name('facture.factureCommentSstore');
        Route::post('/commentaire/destroy','App\Http\Controllers\CommmentaireController@destroy')->name('facture.factureCommentsDestroy');



       //Inventaires
       Route::get('/inventaire', 'App\Http\Controllers\InventaireController@index')->name('inventaire');
       Route::get('/inventaire/create', 'App\Http\Controllers\InventaireController@create')->name('inventaire.create');
       Route::get('/inventaire/edit/{id}', 'App\Http\Controllers\InventaireController@edit')->name('inventaire.edit');
       Route::post('/inventaire/store', 'App\Http\Controllers\InventaireController@store')->name('inventaire.store');
       Route::post('/inventaire/destroy', 'App\Http\Controllers\InventaireController@destroy')->name('inventaire.destroy');
       Route::post('/inventaire/update', 'App\Http\Controllers\InventaireController@update')->name('inventaire.update');

     //Emprunts
     Route::post('/emprunt/updateStatut', 'App\Http\Controllers\EmpruntController@updateStatut')->name('updateStatut');
       Route::post('/emprunt/remboursement', 'App\Http\Controllers\EmpruntController@remboursement')->name('remboursement');
       Route::get('/emprunt', 'App\Http\Controllers\EmpruntController@index')->name('emprunt');
       Route::get('/emprunt/create', 'App\Http\Controllers\EmpruntController@create')->name('emprunt.create');
       Route::get('/emprunt/edit/{id}', 'App\Http\Controllers\EmpruntController@edit')->name('emprunt.edit');
       Route::post('/emprunt/store', 'App\Http\Controllers\EmpruntController@store')->name('emprunt.store');
       Route::post('/emprunt/destroy', 'App\Http\Controllers\EmpruntController@destroy')->name('emprunt.destroy');
       Route::post('/emprunt/update', 'App\Http\Controllers\EmpruntController@update')->name('emprunt.update');

       //Versement
       Route::get('/versement', 'App\Http\Controllers\VersementController@index')->name('versement');
       Route::get('/versement/create', 'App\Http\Controllers\VersementController@create')->name('versement.create');
       Route::post('/versement/edit', 'App\Http\Controllers\VersementController@edit')->name('versement.edit');
       Route::post('/versement/store', 'App\Http\Controllers\VersementController@store')->name('versement.store');
       Route::post('/versement/destroy', 'App\Http\Controllers\VersementController@destroy')->name('versement.destroy');
       Route::post('/versement/update', 'App\Http\Controllers\VersementController@update')->name('versement.update');


        //Versement
        // Route::get('/versement', 'App\Http\Controllers\VersementController@index')->name('versement');
        // Route::get('/versement/create', 'App\Http\Controllers\VersementController@create')->name('versement.create');
        // Route::get('/versement/edit/{id}', 'App\Http\Controllers\VersementController@edit')->name('versement.edit');
        // Route::post('/versement/store', 'App\Http\Controllers\VersementController@store')->name('versement.store');
        // Route::delete('/versement/destroy/{id}', 'App\Http\Controllers\VersementController@destroy')->name('versement.destroy');
        // Route::patch('/versement/update/{id}', 'App\Http\Controllers\VersementController@update')->name('versement.update');


       //Creancier
       Route::get('/creancier', 'App\Http\Controllers\CreancierController@index')->name('creancier');
       Route::get('/creancier/create', 'App\Http\Controllers\CreancierController@create')->name('creancier.create');
       Route::get('/creancier/edit/{id}', 'App\Http\Controllers\CreancierController@edit')->name('creancier.edit');
       Route::post('/creancier/store', 'App\Http\Controllers\CreancierController@store')->name('creancier.store');
       Route::delete('/creancier/destroy/{id}', 'App\Http\Controllers\CreancierController@destroy')->name('creancier.destroy');
       Route::patch('/creancier/update/{id}', 'App\Http\Controllers\CreancierController@update')->name('creancier.update');


        //Activites
        Route::get('/activite', 'App\Http\Controllers\ActiviteController@index')->name('activite');
        Route::get('/activite/create', 'App\Http\Controllers\ActiviteController@create')->name('activite.create');
        Route::get('/activite/edit/{id}', 'App\Http\Controllers\ActiviteController@edit')->name('activite.edit');
        Route::post('/activite/store', 'App\Http\Controllers\ActiviteController@store')->name('activite.store');
        Route::patch('/activite/update/{id}', 'App\Http\Controllers\ActiviteController@update')->name('activite.update');
        Route::delete('/activite/destroy/{id}', 'App\Http\Controllers\ActiviteController@destroy')->name('activite.destroy');


        //Tickets
        Route::get('/ticket', 'App\Http\Controllers\TicketController@index')->name('ticket');
        Route::get('/ticket/create', 'App\Http\Controllers\TicketController@create')->name('ticket.create');
        Route::get('/ticket/edit/{id}', 'App\Http\Controllers\TicketController@edit')->name('ticket.edit');
        Route::post('/ticket/store', 'App\Http\Controllers\TicketController@store')->name('ticket.store');
        Route::patch('/ticket/update/{id}', 'App\Http\Controllers\TicketController@update')->name('ticket.update');
        Route::delete('/ticket/destroy/{id}', 'App\Http\Controllers\TicketController@destroy')->name('ticket.destroy');

        //Echanges
        Route::get('/echange', 'App\Http\Controllers\EchangeController@index')->name('echange');
        Route::get('/echange/create', 'App\Http\Controllers\EchangeController@create')->name('echange.create');
        Route::get('/echange/edit/{id}', 'App\Http\Controllers\EchangeController@edit')->name('echange.edit');
        Route::post('/echange/store', 'App\Http\Controllers\EchangeController@store')->name('echange.store');
        Route::patch('/echange/update/{id}', 'App\Http\Controllers\EchangeController@update')->name('echange.update');
        Route::delete('/echange/destroy/{id}', 'App\Http\Controllers\EchangeController@destroy')->name('echange.destroy');


        //Abonnements
        Route::get('/abonnement', 'App\Http\Controllers\AbonnementController@index')->name('abonnement');
        Route::get('/abonnement/create', 'App\Http\Controllers\AbonnementController@create')->name('abonnement.create');
        Route::get('/abonnement/edit/{id}', 'App\Http\Controllers\AbonnementController@edit')->name('abonnement.edit');
        Route::post('/abonnement/store-abonnement', 'App\Http\Controllers\AbonnementController@storeAbonnement')->name('abonnement.storeAbonnement');
        Route::post('/abonnement/store', 'App\Http\Controllers\AbonnementController@store')->name('abonnement.store');
        Route::post('/abonnement/update', 'App\Http\Controllers\AbonnementController@update')->name('abonnement.update');
        Route::post('/abonnemente/destroy', 'App\Http\Controllers\AbonnementController@destroy')->name('abonnement.destroy');
        Route::post('/abonnement/reabonnement', 'App\Http\Controllers\AbonnementController@reabonnement')->name('abonnement.reabonnement');

       Route::post('/paiement', 'App\Http\Controllers\AbonnementController@paiement')->name('paiement');

        //Modules
        Route::get('/module', 'App\Http\Controllers\ModuleController@index')->name('module');
        Route::get('/module/create', 'App\Http\Controllers\ModuleController@create')->name('module.create');
        Route::get('/module/edit', 'App\Http\Controllers\ModuleController@edit')->name('module.edit');
        Route::post('/module/store', 'App\Http\Controllers\ModuleController@store')->name('module.store');
        Route::post('/module/update', 'App\Http\Controllers\ModuleController@update')->name('module.update');
        Route::post('/module/destroy', 'App\Http\Controllers\ModuleController@destroy')->name('module.destroy');

        Route::post('/module/achat-module', 'App\Http\Controllers\ModuleController@achatModule')->name('module.achatModule');


          //Patrimoine
          Route::get('/patrimoine', 'App\Http\Controllers\PatrimoineController@index')->name('patrimoine');
          Route::get('/patrimoine/create', 'App\Http\Controllers\PatrimoineController@create')->name('patrimoine.create');
          Route::get('/patrimoine/edit/{id}', 'App\Http\Controllers\PatrimoineController@edit')->name('patrimoine.edit');
          Route::post('/patrimoine/store', 'App\Http\Controllers\PatrimoineController@store')->name('patrimoine.store');
          Route::patch('/patrimoine/update/{id}', 'App\Http\Controllers\PatrimoineController@update')->name('patrimoine.update');
          Route::delete('/patrimoine/destroy/{id}', 'App\Http\Controllers\PatrimoineController@destroy')->name('patrimoine.destroy');

});

  // Password Reset...
//   Route::post('/email_reset_password', 'App\Http\Controllers\AuthController@email_reset_passwordreset_password')->name('email_reset_password');
    Route::get('/form_email', [AuthController::class,'form_email'])->name('form_email');
    Route::post('/email_reset_password', [AuthController::class,'email_reset_password'])->name('email_reset_password');
    Route::get('/show_token/{token}', [AuthController::class,'show_token'])->name('show_token');
    Route::post('/reset_password', [AuthController::class,'reset_password'])->name('reset_password');
    Route::post('/resetIdCompte', [AuthController::class,'resetIdCompte'])->name('resetIdCompte');








Route::get('/paiement', 'App\Http\Controllers\AbonnementController@paiement')->name('paiement');

Route::get('/paiement_status', 'App\Http\Controllers\AbonnementController@paiement_status')->name('paiement_status');


































// Route::get('/', function () {
//     return Inertia::render('Accueil');
// })->name('accueil');

// Route::get('/pack', function () {
//     return Inertia::render('pack');
// })->name('pack')->middleware('auth');


// Route::post('/entreprise', 'App\Http\Controllers\EntrepriseController@store')->name('entreprise.store');





// Route::middleware([
//     'auth',
//     'finalisationinscription'
//     ])
//     ->group(function () {

//         Route::get('/welcome', 'App\Http\Controllers\Controller@create')->name('welcome');
//         // Route::get('/header', 'App\Http\Controllers\Controller@header')->name('header');

//         Route::get('/dashboard', function () {
//             return Inertia::render('Dashboard');
//         })->name('dashboard');

//         //pack





//         //Emprunts
//         Route::resource('/emprunt', 'App\Http\Controllers\EmpruntController');
//         //Creanciers
//         Route::resource('/creancier', 'App\Http\Controllers\CreancierController');
//         //Departements
//         Route::resource('/departement', 'App\Http\Controllers\DepartementController');
//         //Projet
//         Route::resource('/projet', 'App\Http\Controllers\ProjetController');
//         //Activités
//         Route::resource('/activite', 'App\Http\Controllers\ActiviteController');

//         //Agences
//         // Route::resource('/agence','App\Http\Controllers\AgenceController');

//         Route::get('/agence', 'App\Http\Controllers\AgenceController@index')->name('agence');
//         Route::get('/agence/create', 'App\Http\Controllers\AgenceController@create')->name('agence.create');
//         Route::get('/agence/edit/{id}', 'App\Http\Controllers\AgenceController@edit')->name('agence.edit');
//         Route::post('/agence/store', 'App\Http\Controllers\AgenceController@store')->name('agence.store');
//         Route::delete('/agence/destroy/{id}', 'App\Http\Controllers\AgenceController@destroy')->name('agence.destroy');
//         Route::patch('/agence/update/{id}', 'App\Http\Controllers\AgenceController@update')->name('agence.update');

//         //Versements
//         Route::resource('/versement','App\Http\Controllers\VersementController');

//



//         //Devis
//         Route::get('/devis', 'App\Http\Controllers\DevisController@create')->name('devis');
//         Route::post('/devis/store', 'App\Http\Controllers\DevisController@store')->name('devis.store');


//         //Article
//         Route::get('/SendMail', 'App\Http\Controllers\ArticleController@mail')->name('article');
//         Route::get('/article', 'App\Http\Controllers\ArticleController@index')->name('article');
//         Route::get('/article/create', 'App\Http\Controllers\ArticleController@create')->name('article.create');
//         Route::get('/article/edit/{id}', 'App\Http\Controllers\ArticleController@edit')->name('article.edit');
//         Route::post('/article/store', 'App\Http\Controllers\ArticleController@store')->name('article.store');
//         Route::patch('/article/update/{id}', 'App\Http\Controllers\articleController@update')->name('article.update');
//         Route::delete('/article/destroy/{id}', 'App\Http\Controllers\ArticleController@destroy')->name('article.destroy');

//         //Entreprise
//         // Route::middleware(['auth:sanctum', 'verified'])->group(function () {
//         //     Route::get('/entreprise', 'App\Http\Controllers\EntrepriseController@create')->name('entreprise');
//         //     Route::post('/entreprise', 'App\Http\Controllers\EntrepriseController@store')->name('entreprise.store');
//         // });


//         //Client
//         // Route::get('/client', 'App\Http\Controllers\ClientController@index')->name('client');
//         // Route::get('/client/create', 'App\Http\Controllers\ClientController@create')->name('client.create');
//         // Route::post('/client/store', 'App\Http\Controllers\ClientController@store')->name('client.store');
//         // Route::delete('/client/destroy{id}', 'App\Http\Controllers\ClientController@destroy')->name('client.delete');
//         // Route::get('/client/edit/{id}', 'App\Http\Controllers\ClientController@edit')->name('client.edit');
//         // Route::patch('/client/update/{id}', 'App\Http\Controllers\ClientController@update')->name('client.update');


//         /*
//         |--------------------------------------------------------------------------
//         | Web Routes *********parametrages*************
//         |--------------------------------------------------------------------------
//         |
//         */


//         //taxes --->


//         //Route::get('/type-parametre/create', 'App\Http\Controllers\TypeParametreController@create')->name('typeparametre.create');
//         //Route::post('/type-parametre/store', 'App\Http\Controllers\TypeParametreController@store')->name('typeparametre.store');
//         //Route::get('/type-parametre/edit/{id}', 'App\Http\Controllers\TypeParametreController@edit')->name('typeparametre.update');
//         //Route::patch('/type-parametre/update/{id}', 'App\Http\Controllers\TypeParametreController@update')->name('typeparametre.update');
//         //Route::delete('/type-parametre/destroy/{id}', 'App\Http\Controllers\TypeParametreController@destroy')->name('typeparametre.destroy');

//         /*
//         |--------------------------------------------------------------------------
//         | Web Routes ***********ROLES ET PERMISSIONS ************
//         |--------------------------------------------------------------------------
//         |
//         */



//         /*
//         |--------------------------------------------------------------------------
//         | Web Routes ***********  facture  ************
//         |--------------------------------------------------------------------------
//         |
//         */

//     }
// );
// Route::get('/client_facture/{id}', 'App\Http\Controllers\FactureController@client_facture')->name('client_facture');
// Route::get('/facture', 'App\Http\Controllers\FactureController@index')->name('facture');

// Route::get('/facturecreate', 'App\Http\Controllers\FactureController@create')->name('facture.create');
// Route::post('/facture/store', 'App\Http\Controllers\FactureController@store')->name('facture.store');

// Route::get('/facturepreview', 'App\Http\Controllers\FactureController@preview')->name('facture.preview');
// Route::get('/factureedit', 'App\Http\Controllers\FactureController@edit')->name('facture.edit');


//         Route::get('/facture/relance', 'App\Http\Controllers\FactureController@preview')->name('facture.preview');
//         Route::get('/factureedit/edit/{id}', 'App\Http\Controllers\FactureController@edit')->name('facture.edit');


//        //rols et permissions --->
//        Route::get('/role', 'App\Http\Controllers\RoleController@index')->name('role');
//        Route::get('/role/create', 'App\Http\Controllers\RoleController@create')->name('role.create');
//        Route::post('/role/store', 'App\Http\Controllers\RoleController@store')->name('role.store');
//        Route::get('/role/edit/{id}', 'App\Http\Controllers\RoleController@edit')->name('role.edit');
//        Route::get('/role/{id}', 'App\Http\Controllers\RoleController@edit')->name('role.edit');
//        Route::patch('/role/update/{id}', 'App\Http\Controllers\RoleController@update')->name('role.update');
//        Route::delete('/role/destroy/{id}', 'App\Http\Controllers\RoleController@destroy')->name('role.delete');


//        // Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
//        //     return Inertia::render('Dashboard');
//        // })->name('dashboard');



//        Route::get('/permission', 'App\Http\Controllers\PermissionController@index')->name('permission');
//        Route::get('/permission/create', 'App\Http\Controllers\PermissionController@create')->name('permission.create');
//        Route::post('/permission/store', 'App\Http\Controllers\PermissionController@store')->name('permission.store');
//        Route::get('/permission/edit/{id}', 'App\Http\Controllers\PermissionController@edit')->name('permission.edit');
//        Route::get('/permission/{id}', 'App\Http\Controllers\PermissionController@edit')->name('permission.edit');
//        Route::patch('/permission/update/{id}', 'App\Http\Controllers\PermissionController@update')->name('permission.update');
//        Route::delete('/permission/destroy/{id}', 'App\Http\Controllers\PermissionController@destroy')->name('permission.delete');

//        Route::get('/entreprise', 'App\Http\Controllers\EntrepriseController@create')->name('entreprise');





//          //parametrage (typeparametres & parametres)  /parametre/search/
//          Route::get('/parametre', 'App\Http\Controllers\ParametreController@index')->name('parametre');
//          Route::get('/parametre/create', 'App\Http\Controllers\ParametreController@create')->name('parametre.create');
//          Route::post('/parametre/store', 'App\Http\Controllers\ParametreController@store')->name('parametre.store');
//          Route::delete('parametre/destroy/{id}', 'App\Http\Controllers\ParametreController@destroy')->name('parametre.destroy');
//          Route::get('parametre/edit/{id}', 'App\Http\Controllers\ParametreController@edit')->name('parametre.update');
//          Route::patch('parametre/update/{id}', 'App\Http\Controllers\ParametreController@update')->name('parametre.update');
//          Route::post('/parametre/{id}', 'App\Http\Controllers\ParametreController@collect')->name('parametre.collect');
//          Route::get('/parametre/{id}', 'App\Http\Controllers\ParametreController@search')->name('parametre.search');
//          //Route::get('/parametre', 'App\Http\Controllers\ParametreController@search')->name('parametre.search');

//          //type_parametre(Done)
//          Route::get('/type-parametre', 'App\Http\Controllers\TypeParametreController@index')->name('typeparametre');
//          Route::get('/type-parametre/create', 'App\Http\Controllers\TypeParametreController@create')->name('typeparametre.create');
//          Route::post('/type-parametre/store', 'App\Http\Controllers\TypeParametreController@store')->name('typeparametre.store');
//          Route::get('/type-parametre/edit/{id}', 'App\Http\Controllers\TypeParametreController@edit')->name('typeparametre.update');
//          Route::patch('/type-parametre/update/{id}', 'App\Http\Controllers\TypeParametreController@update')->name('typeparametre.update');
//          Route::delete('/type-parametre/destroy/{id}', 'App\Http\Controllers\TypeParametreController@destroy')->name('typeparametre.destroy');



//          //Depenses
//         Route::resource('/depense', 'App\Http\Controllers\DepenseController');
//         Route::post('/depense/store', 'App\Http\Controllers\DepenseController@store')->name('depense.store');
//         Route::patch('/depense/update/{id}', 'App\Http\Controllers\DepenseController@update')->name('depense.update');
//         Route::delete('/depense/destroy/{id}', 'App\Http\Controllers\DepenseController@destroy')->name('depense.destroy');


//         //Comptes
//         Route::resource('/compte', 'App\Http\Controllers\CompteController');
//         Route::post('/compte/store', 'App\Http\Controllers\CompteController@store')->name('compte.store');
//         Route::patch('/compte/update/{id}', 'App\Http\Controllers\CompteController@update')->name('compte.update');
//         Route::delete('/compte/destroy/{id}', 'App\Http\Controllers\CompteController@destroy')->name('compte.destroy');


//         //Echeanciers
//         Route::get('/echeancier', 'App\Http\Controllers\EcheancierController@index')->name('echeancier');
//         Route::post('/echeancier/store', 'App\Http\Controllers\EcheancierController@store')->name('echeancier.store');
//         Route::patch('/echeancier/update/{id}', 'App\Http\Controllers\EcheancierController@update')->name('echeancier.update');
//         Route::delete('/echeancier/destroy/{id}', 'App\Http\Controllers\EcheancierController@destroy')->name('echeancier.delete');

//          //Departements
//          Route::resource('/departement', 'App\Http\Controllers\DepartementController');
//         Route::get('/departement', 'App\Http\Controllers\DepartementController@index')->name('echeancier');
//         Route::post('/departement/store', 'App\Http\Controllers\DepartementController@store')->name('echeancier.store');
//         Route::patch('/departement/update/{id}', 'App\Http\Controllers\DepartementController@update')->name('echeancier.update');
//         Route::delete('/departement/destroy/{id}', 'App\Http\Controllers\DepartementController@destroy')->name('echeancier.delete');


//         //Relance()
//         // Route::get('/relance', 'App\Http\Controllers\RelanceController@index')->name('relance');
//         // Route::get('/relance/create', 'App\Http\Controllers\RelanceController@create')->name('relance.create');
//         // Route::post('/relance/store', 'App\Http\Controllers\RelanceController@store')->name('relance.store');
//         // Route::get('/relance/edit/{id}', 'App\Http\Controllers\RelanceController@edit')->name('relance.update');
//         // Route::patch('/relance/update/{id}', 'App\Http\Controllers\RelanceController@update')->name('relance.update');
//         // Route::delete('/relance/destroy/{id}', 'App\Http\Controllers\RelanceController@destroy')->name('relance.destroy');

        // Route::middleware('auth:sanctum')->get('/users/{user}', function (Request $request) {
        //     return $request->user();
        // });
//         Route::middleware('auth:api')->get('/users/{user}', function (Request $request) {
//             return $request->user();
//         });















Route::get('/cart', [CartModuleController::class, 'cartList'])->name('cart.list');
Route::post('/cart/store', [CartModuleController::class, 'store'])->name('cart.store');
Route::post('/cart/update', [CartModuleController::class, 'update'])->name('cart.update');
Route::post('/cart/destroy', [CartModuleController::class, 'destroy'])->name('cart.destroy');
Route::post('/cart/destroyAll', [CartModuleController::class, 'destroyAll'])->name('cart.destroyAll');

Route::get('/paiement-status', 'App\Http\Controllers\AbonnementController@paiement_status')->name('paiement-status');
Route::post('/paiement-status', 'App\Http\Controllers\AbonnementController@paiement_status')->name('paiement-status');

Route::get('/article/generateCatalogue', 'App\Http\Controllers\ArticleController@generateCatalogue')->name('article.generateCatalogue');
