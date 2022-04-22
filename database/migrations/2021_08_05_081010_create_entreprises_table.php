<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntreprisesTable extends Migration
{
    /**
     * Run the migrations.  username
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('immatricule')->unique()->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('libelle')->nullable();
            $table->string('username')->nullable();
            $table->text('description')->nullable();
            $table->string('ville')->nullable();
            $table->string('contact')->nullable();
            $table->string('indicateur')->nullable();
            $table->string('fixe')->nullable();
            $table->string('adresse')->nullable();
            $table->string('boite_postale')->nullable();
           // $table->string('devise_id')->nullable();
            $table->integer('nombre_employe')->nullable();
            $table->integer('nombre_agence')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('site_internet')->nullable();
            $table->boolean('status')->nullable();
            //$table->text('taille')->nullable();

            $table->unsignedBigInteger('taille_id')->nullable();
            $table->unsignedBigInteger('pays_id')->nullable();
            $table->string('pays')->nullable();
            $table->json('localisation')->nullable();
            $table->unsignedBigInteger('ville_id')->nullable();

            $table->unsignedBigInteger('domaine_id')->nullable();
            $table->unsignedBigInteger('type_entreprise_id')->nullable();
            $table->unsignedBigInteger('devise_id')->nullable();

            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();

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
        Schema::dropIfExists('entreprises');
    }
}
