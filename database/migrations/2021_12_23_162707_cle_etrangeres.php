<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CleEtrangeres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('type_appareil_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            // $table->foreign('type_user')
            //     ->nullable()
            //     ->references('id')
            //     ->on('parametres')
            //     ->onDelete('set null')
            //     ->onUpdate('cascade');

            $table->foreign('pays_id')
                ->nullable()
                ->references('id')
                ->on('localisations')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });




        Schema::table('user_infos', function (Blueprint $table) {
            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('type_user_info_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('entreprises', function (Blueprint $table) {
            $table->foreign('taille_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('pays_id')
                ->nullable()
                ->references('id')
                ->on('localisations')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('ville_id')
                ->nullable()
                ->references('id')
                ->on('localisations')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('domaine_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('type_entreprise_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('entreprise_infos', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('type_entreprise_info_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('entreprise_user', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('departements', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('commandes', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('fournisseur_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('client_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('type_parametres', function (Blueprint $table) {
            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('parametres', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('type_parametre_id')
                ->nullable()
                ->references('id')
                ->on('type_parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('parent_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('prospections', function (Blueprint $table) {

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('employe_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('abonnements', function (Blueprint $table) {
            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('modules', function (Blueprint $table) {
            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('depenses', function (Blueprint $table) {

            $table->foreign('type_depense_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('agence_id')
                ->nullable()
                ->references('id')
                ->on('agences')
                ->onDelete('set null')
                ->onUpdate('cascade');

            // $table->foreign('departement_id')
            //     ->nullable()
            //     ->references('id')
            //     ->on('departements')
            //     ->onDelete('set null')
            //     ->onUpdate('cascade');

            $table->foreign('created_user')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        // Schema::table('sous_depenses', function (Blueprint $table) {

        //     $table->foreign('depense_id')
        //         ->nullable()
        //         ->references('id')
        //         ->on('depenses')
        //         ->onDelete('set null')
        //         ->onUpdate('cascade');

        // });

        Schema::table('comptes', function (Blueprint $table) {

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('type_compte_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('emprunts', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('compte_id')
                ->nullable()
                ->references('id')
                ->on('comptes')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('creancier_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('patrimoines', function (Blueprint $table) {

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('projets', function (Blueprint $table) {

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('agence_id')
                ->nullable()
                ->references('id')
                ->on('agences')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('departement_id')
                ->nullable()
                ->references('id')
                ->on('departements')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

        });

        Schema::table('taxes', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('inventaires', function (Blueprint $table) {
            $table->foreign('agence_id')
                ->nullable()
                ->references('id')
                ->on('agences')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('departement_id')
                ->nullable()
                ->references('id')
                ->on('departements')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('approvisionnements', function (Blueprint $table) {
            $table->foreign('agence_id')
                ->nullable()
                ->references('id')
                ->on('agences')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('departement_id')
                ->nullable()
                ->references('id')
                ->on('departements')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('receveid_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('previsions', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('type_depense_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('factures', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('devise_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

                $table->foreign('taxe_id')
                ->nullable()
                ->references('id')
                ->on('taxes')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('type_facture_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

                $table->foreign('client_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');


            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('articles', function (Blueprint $table) {

            $table->foreign('type_article_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

                $table->foreign('category_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('echanges', function (Blueprint $table) {
            $table->foreign('ticket_id')
                ->nullable()
                ->references('id')
                ->on('tickets')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('received_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('agences', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('pays_id')
                ->nullable()
                ->references('id')
                ->on('localisations')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('activites', function (Blueprint $table) {
            $table->foreign('projet_id')
                ->nullable()
                ->references('id')
                ->on('projets')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('localisations', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('type_localisation_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('parent_id')
                ->nullable()
                ->references('id')
                ->on('localisations')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('promotions', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        //////////////////////////////////////// Tables pivots  ////////////////////////////////////////////////

        Schema::table('abonnement_module', function (Blueprint $table) {
            $table->foreign('abonnement_id')
                ->nullable()
                ->references('id')
                ->on('abonnements')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('module_id')
                ->nullable()
                ->references('id')
                ->on('modules')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('abonnement_entreprise', function (Blueprint $table) {
            // $table->foreign('abonnement_id')
            //     ->nullable()
            //     ->references('id')
            //     ->on('abonnements')
            //     ->onDelete('set null')
            //     ->onUpdate('cascade');

            //
        });

        Schema::table('entreprise_module', function (Blueprint $table) {

            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('module_id')
                ->nullable()
                ->references('id')
                ->on('modules')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('facture_taxe', function (Blueprint $table) {
            $table->foreign('facture_id')
                ->nullable()
                ->references('id')
                ->on('factures')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('taxe_id')
                ->nullable()
                ->references('id')
                ->on('taxes')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('article_facture', function (Blueprint $table) {
            $table->foreign('facture_id')
                ->nullable()
                ->references('id')
                ->on('factures')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('article_id')
                ->nullable()
                ->references('id')
                ->on('articles')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('article_promotion', function (Blueprint $table) {
            $table->foreign('promotion_id')
                ->nullable()
                ->references('id')
                ->on('promotions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('article_id')
                ->nullable()
                ->references('id')
                ->on('articles')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('article_inventaire', function (Blueprint $table) {
            $table->foreign('inventaire_id')
                ->nullable()
                ->references('id')
                ->on('inventaires')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('article_id')
                ->nullable()
                ->references('id')
                ->on('articles')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('approvisionnement_article', function (Blueprint $table) {
            $table->foreign('approvisionnement_id')
                ->nullable()
                ->references('id')
                ->on('approvisionnements')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('article_id')
                ->nullable()
                ->references('id')
                ->on('articles')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('promotion_user', function (Blueprint $table) {
            $table->foreign('promotion_id')
                ->nullable()
                ->references('id')
                ->on('promotions')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('notification_user', function (Blueprint $table) {
            $table->foreign('notification_id')
                ->nullable()
                ->references('id')
                ->on('notifications')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });


        Schema::table('versements', function (Blueprint $table) {
            $table->foreign('entreprise_id')
                ->nullable()
                ->references('id')
                ->on('entreprises')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('facture_id')
                ->nullable()
                ->references('id')
                ->on('factures')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('moyen_paiement_id')
                ->nullable()
                ->references('id')
                ->on('parametres')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

                $table->foreign('compte_id')
                ->nullable()
                ->references('id')
                ->on('comptes')
                ->onDelete('set null')
                ->onUpdate('cascade');

                $table->foreign('emprunt_id')
                ->nullable()
                ->references('id')
                ->on('emprunts')
                ->onDelete('set null')
                ->onUpdate('cascade');

                $table->foreign('echeancier_id')
                ->nullable()
                ->references('id')
                ->on('echeanciers')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('created_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('updated_user')
                ->nullable()
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

        Schema::table('departement_depense', function (Blueprint $table) {
            $table->foreign('departement_id')
                ->nullable()
                ->references('id')
                ->on('departements')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('depense_id')
                ->nullable()
                ->references('id')
                ->on('depenses')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });

    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
