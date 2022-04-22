<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('IdCompte')->unique()->nullable();
            $table->string('nom')->nullable();
            $table->string('prenoms')->nullable();
            $table->string('slug')->nullable();
            $table->string('contact')->nullable();
            $table->string('indicateur')->nullable();
            $table->string('numero_fixe')->nullable();
            $table->string('ville')->nullable();
            $table->string('profession')->nullable();
            $table->string('type_client')->nullable();
            $table->string('sexe')->nullable();
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('adresse_ip')->nullable();
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('username')->nullable();
            $table->string('status_user')->nullable();
            $table->string('email',250)->nullable();
            $table->boolean('status')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('type_user_creancier')->nullable();
            $table->unsignedBigInteger('creancier_id')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable();
            $table->unsignedBigInteger('type_appareil_id')->nullable();
            $table->string('type_user')->nullable();
            $table->unsignedBigInteger('pays_id')->nullable();
            $table->json('localisation')->nullable();
            $table->string('prospection_name')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();


            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('salaire')->nullable();
            $table->string('numero_assurance')->nullable();
            $table->string('taux_renumeration')->nullable();
            $table->string('paie_additionnelle')->nullable();
            $table->string('echeancier_paiement')->nullable();
            $table->string('mode_paiement')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->string('nombre_enfant')->nullable();
            $table->date('date_embauche')->nullable();
            $table->string('lieu_travail')->nullable();
            $table->string('poste')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('nom_usuel')->nullable();
            $table->string('type_piece')->nullable();
            $table->string('numero_piece')->nullable();
            $table->string('nationalite')->nullable();
            $table->boolean('delete_update_at')->default(0);

            

            // $table->string('pays')->nullable();
            // $table->string('ville')->nullable();
            // $table->string('date_de_naissance')->nullable();
            // $table->string('lieu_naissance')->nullable();


            $table->unsignedBigInteger('domaine_id')->nullable();
            $table->unsignedBigInteger('departement_id')->nullable();
            $table->unsignedBigInteger('etat_id')->nullable();
            $table->unsignedBigInteger('contrat_id')->nullable();
            $table->unsignedBigInteger('urgence_contact_id')->nullable();





            $table->rememberToken()->nullable();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
