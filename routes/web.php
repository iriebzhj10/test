<?php

use Inertia\Inertia;
use App\Models\Article;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;

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


/*
|--------------------------------------------------------------------------
| Web Routes *********COMPTES*************
|--------------------------------------------------------------------------
|
|
|
|
*/

Route::get('/facture/pdf', 'App\Http\Controllers\FactureController@facturePdf')->name('facture.facturePdf');

Route::get('/', function () {
    return Inertia::render('Accueil');
})->name('accueil');

Route::get('/pack', function () {
    return Inertia::render('pack');
})->name('pack')->middleware('auth');


Route::post('/entreprise', 'App\Http\Controllers\EntrepriseController@store')->name('entreprise.store');


Route::middleware([
    'auth',
    'finalisationinscription'
    ])
    ->group(function () {

        Route::get('/welcome', 'App\Http\Controllers\Controller@create')->name('welcome');
        // Route::get('/header', 'App\Http\Controllers\Controller@header')->name('header');

        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        //pack

        //Emprunts
       // Route::resource('/emprunt', 'App\Http\Controllers\EmpruntController');
        Route::get('/emprunt', 'App\Http\Controllers\EmpruntController@index')->name('emprunt');
        Route::get('/emprunt/create', 'App\Http\Controllers\EmpruntController@create')->name('emprunt.create');
        Route::get('/emprunt/edit/{id}', 'App\Http\Controllers\EmpruntController@edit')->name('emprunt.edit');
        Route::post('/emprunt/store', 'App\Http\Controllers\EmpruntController@store')->name('emprunt.store');
        Route::delete('/emprunt/destroy/{id}', 'App\Http\Controllers\EmpruntController@destroy')->name('emprunt.destroy');
        Route::patch('/emprunt/update/{id}', 'App\Http\Controllers\EmpruntController@update')->name('emprunt.update');





        //Creanciers
        Route::resource('/creancier', 'App\Http\Controllers\CreancierController');
        //Departements
        Route::resource('/departement', 'App\Http\Controllers\DepartementController');
        //Projet
        Route::resource('/projet', 'App\Http\Controllers\ProjetController');
        //Activités
        Route::resource('/activite', 'App\Http\Controllers\ActiviteController');

        //Agences
        // Route::resource('/agence','App\Http\Controllers\AgenceController');

        Route::get('/agence', 'App\Http\Controllers\AgenceController@index')->name('agence');
        Route::get('/agence/create', 'App\Http\Controllers\AgenceController@create')->name('agence.create');
        Route::get('/agence/edit/{id}', 'App\Http\Controllers\AgenceController@edit')->name('agence.edit');
        Route::post('/agence/store', 'App\Http\Controllers\AgenceController@store')->name('agence.store');
        Route::delete('/agence/destroy/{id}', 'App\Http\Controllers\AgenceController@destroy')->name('agence.destroy');
        Route::patch('/agence/update/{id}', 'App\Http\Controllers\AgenceController@update')->name('agence.update');

        //Versements
        Route::resource('/versement','App\Http\Controllers\VersementController');

        //Taxe
        Route::get('/taxe', 'App\Http\Controllers\TaxeController@index')->name('taxe');
        Route::get('/taxe/create', 'App\Http\Controllers\TaxeController@create')->name('taxe.create');
        Route::post('/taxe/store', 'App\Http\Controllers\TaxeController@store')->name('taxe.store');
        Route::delete('/taxe/destroy/{id}', 'App\Http\Controllers\TaxeController@destroy')->name('taxe.destroy');
        Route::put('/taxe/update/{id}', 'App\Http\Controllers\TaxeController@update')->name('taxe.update');



        //Devis
        Route::get('/devis', 'App\Http\Controllers\DevisController@create')->name('devis');
        Route::post('/devis/store', 'App\Http\Controllers\DevisController@store')->name('devis.store');


        //Article
        Route::get('/SendMail', 'App\Http\Controllers\ArticleController@mail')->name('article');
        Route::get('/article', 'App\Http\Controllers\ArticleController@index')->name('article');
        Route::get('/article/create', 'App\Http\Controllers\ArticleController@create')->name('article.create');
        Route::get('/article/edit/{id}', 'App\Http\Controllers\ArticleController@edit')->name('article.edit');
        Route::post('/article/store', 'App\Http\Controllers\ArticleController@store')->name('article.store');
        Route::patch('/article/update/{id}', 'App\Http\Controllers\articleController@update')->name('article.update');
        Route::delete('/article/destroy/{id}', 'App\Http\Controllers\ArticleController@destroy')->name('article.destroy');

        //Entreprise
        // Route::middleware(['auth:sanctum', 'verified'])->group(function () {
        //     Route::get('/entreprise', 'App\Http\Controllers\EntrepriseController@create')->name('entreprise');
        //     Route::post('/entreprise', 'App\Http\Controllers\EntrepriseController@store')->name('entreprise.store');
        // });


        //Client
        Route::get('/client', 'App\Http\Controllers\ClientController@index')->name('client');
        Route::get('/client/create', 'App\Http\Controllers\ClientController@create')->name('client.create');
        Route::post('/client/store', 'App\Http\Controllers\ClientController@store')->name('client.store');
        Route::delete('/client/destroy{id}', 'App\Http\Controllers\ClientController@destroy')->name('client.delete');
        Route::get('/client/edit/{id}', 'App\Http\Controllers\ClientController@edit')->name('client.edit');
        Route::patch('/client/update/{id}', 'App\Http\Controllers\ClientController@update')->name('client.update');


        /*
        |--------------------------------------------------------------------------
        | Web Routes *********parametrages*************
        |--------------------------------------------------------------------------
        |
        */


        //taxes --->


        //Route::get('/type-parametre/create', 'App\Http\Controllers\TypeParametreController@create')->name('typeparametre.create');
        //Route::post('/type-parametre/store', 'App\Http\Controllers\TypeParametreController@store')->name('typeparametre.store');
        //Route::get('/type-parametre/edit/{id}', 'App\Http\Controllers\TypeParametreController@edit')->name('typeparametre.update');
        //Route::patch('/type-parametre/update/{id}', 'App\Http\Controllers\TypeParametreController@update')->name('typeparametre.update');
        //Route::delete('/type-parametre/destroy/{id}', 'App\Http\Controllers\TypeParametreController@destroy')->name('typeparametre.destroy');

        /*
        |--------------------------------------------------------------------------
        | Web Routes ***********ROLES ET PERMISSIONS ************
        |--------------------------------------------------------------------------
        |
        */



        /*
        |--------------------------------------------------------------------------
        | Web Routes ***********  facture  ************
        |--------------------------------------------------------------------------
        |
        */

    }
);
Route::get('/client_facture/{id}', 'App\Http\Controllers\FactureController@client_facture')->name('client_facture');
Route::get('/facture', 'App\Http\Controllers\FactureController@index')->name('facture');

Route::get('/facturecreate', 'App\Http\Controllers\FactureController@create')->name('facture.create');
Route::post('/facture/store', 'App\Http\Controllers\FactureController@store')->name('facture.store');

Route::get('/facturepreview', 'App\Http\Controllers\FactureController@preview')->name('facture.preview');
Route::get('/factureedit', 'App\Http\Controllers\FactureController@edit')->name('facture.edit');


        Route::get('/facture/relance', 'App\Http\Controllers\FactureController@preview')->name('facture.preview');
        Route::get('/factureedit/edit/{id}', 'App\Http\Controllers\FactureController@edit')->name('facture.edit');


       //rols et permissions --->
       Route::get('/role', 'App\Http\Controllers\RoleController@index')->name('role');
       Route::get('/role/create', 'App\Http\Controllers\RoleController@create')->name('role.create');
       Route::post('/role/store', 'App\Http\Controllers\RoleController@store')->name('role.store');
       Route::get('/role/edit/{id}', 'App\Http\Controllers\RoleController@edit')->name('role.edit');
       Route::get('/role/{id}', 'App\Http\Controllers\RoleController@edit')->name('role.edit');
       Route::patch('/role/update/{id}', 'App\Http\Controllers\RoleController@update')->name('role.update');
       Route::delete('/role/destroy/{id}', 'App\Http\Controllers\RoleController@destroy')->name('role.delete');


       // Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
       //     return Inertia::render('Dashboard');
       // })->name('dashboard');



       Route::get('/permission', 'App\Http\Controllers\PermissionController@index')->name('permission');
       Route::get('/permission/create', 'App\Http\Controllers\PermissionController@create')->name('permission.create');
       Route::post('/permission/store', 'App\Http\Controllers\PermissionController@store')->name('permission.store');
       Route::get('/permission/edit/{id}', 'App\Http\Controllers\PermissionController@edit')->name('permission.edit');
       Route::get('/permission/{id}', 'App\Http\Controllers\PermissionController@edit')->name('permission.edit');
       Route::patch('/permission/update/{id}', 'App\Http\Controllers\PermissionController@update')->name('permission.update');
       Route::delete('/permission/destroy/{id}', 'App\Http\Controllers\PermissionController@destroy')->name('permission.delete');

       Route::get('/entreprise', 'App\Http\Controllers\EntrepriseController@create')->name('entreprise');





         //parametrage (typeparametres & parametres)  /parametre/search/
         Route::get('/parametre', 'App\Http\Controllers\ParametreController@index')->name('parametre');
         Route::get('/parametre/create', 'App\Http\Controllers\ParametreController@create')->name('parametre.create');
         Route::post('/parametre/store', 'App\Http\Controllers\ParametreController@store')->name('parametre.store');
         Route::delete('parametre/destroy/{id}', 'App\Http\Controllers\ParametreController@destroy')->name('parametre.destroy');
         Route::get('parametre/edit/{id}', 'App\Http\Controllers\ParametreController@edit')->name('parametre.update');
         Route::patch('parametre/update/{id}', 'App\Http\Controllers\ParametreController@update')->name('parametre.update');
         Route::post('/parametre/{id}', 'App\Http\Controllers\ParametreController@collect')->name('parametre.collect');
         Route::get('/parametre/{id}', 'App\Http\Controllers\ParametreController@search')->name('parametre.search');
         //Route::get('/parametre', 'App\Http\Controllers\ParametreController@search')->name('parametre.search');

         //type_parametre(Done)
         Route::get('/type-parametre', 'App\Http\Controllers\TypeParametreController@index')->name('typeparametre');
         Route::get('/type-parametre/create', 'App\Http\Controllers\TypeParametreController@create')->name('typeparametre.create');
         Route::post('/type-parametre/store', 'App\Http\Controllers\TypeParametreController@store')->name('typeparametre.store');
         Route::get('/type-parametre/edit/{id}', 'App\Http\Controllers\TypeParametreController@edit')->name('typeparametre.update');
         Route::patch('/type-parametre/update/{id}', 'App\Http\Controllers\TypeParametreController@update')->name('typeparametre.update');
         Route::delete('/type-parametre/destroy/{id}', 'App\Http\Controllers\TypeParametreController@destroy')->name('typeparametre.destroy');



         //Depenses
        Route::resource('/depense', 'App\Http\Controllers\DepenseController');
        Route::post('/depense/store', 'App\Http\Controllers\DepenseController@store')->name('depense.store');
        Route::patch('/depense/update/{id}', 'App\Http\Controllers\DepenseController@update')->name('depense.update');
        Route::delete('/depense/destroy/{id}', 'App\Http\Controllers\DepenseController@destroy')->name('depense.destroy');


        //Comptes
        Route::resource('/compte', 'App\Http\Controllers\CompteController');
        Route::post('/compte/store', 'App\Http\Controllers\CompteController@store')->name('compte.store');
        Route::patch('/compte/update/{id}', 'App\Http\Controllers\CompteController@update')->name('compte.update');
        Route::delete('/compte/destroy/{id}', 'App\Http\Controllers\CompteController@destroy')->name('compte.destroy');


        //Echeanciers
        Route::get('/echeancier', 'App\Http\Controllers\EcheancierController@index')->name('echeancier');
        Route::post('/echeancier/store', 'App\Http\Controllers\EcheancierController@store')->name('echeancier.store');
        Route::patch('/echeancier/update/{id}', 'App\Http\Controllers\EcheancierController@update')->name('echeancier.update');
        Route::delete('/echeancier/destroy/{id}', 'App\Http\Controllers\EcheancierController@destroy')->name('echeancier.delete');

         //Departements
         Route::resource('/departement', 'App\Http\Controllers\DepartementController');
        Route::get('/departement', 'App\Http\Controllers\DepartementController@index')->name('echeancier');
        Route::post('/departement/store', 'App\Http\Controllers\DepartementController@store')->name('echeancier.store');
        Route::patch('/departement/update/{id}', 'App\Http\Controllers\DepartementController@update')->name('echeancier.update');
        Route::delete('/departement/destroy/{id}', 'App\Http\Controllers\DepartementController@destroy')->name('echeancier.delete');


        //Relance()
        // Route::get('/relance', 'App\Http\Controllers\RelanceController@index')->name('relance');
        // Route::get('/relance/create', 'App\Http\Controllers\RelanceController@create')->name('relance.create');
        // Route::post('/relance/store', 'App\Http\Controllers\RelanceController@store')->name('relance.store');
        // Route::get('/relance/edit/{id}', 'App\Http\Controllers\RelanceController@edit')->name('relance.update');
        // Route::patch('/relance/update/{id}', 'App\Http\Controllers\RelanceController@update')->name('relance.update');
        // Route::delete('/relance/destroy/{id}', 'App\Http\Controllers\RelanceController@destroy')->name('relance.destroy');

        Route::middleware('auth:sanctum')->get('/users/{user}', function (Request $request) {
            return $request->user();
        });

