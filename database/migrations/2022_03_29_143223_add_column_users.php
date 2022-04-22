<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::table('users', function (Blueprint $table) {
            //

            $table->string('salaire')->nullable();
            $table->string('situation_matrimoniale')->nullable();
            $table->string('nombre_enfant')->nullable();
            $table->string('etat')->nullable();
            $table->string('departement')->nullable();
            $table->json('lieu_travail')->nullable();
            $table->string('mode_paiemment')->nullable();
            $table->string('n_assurance')->nullable();
            $table->string('contact_1')->nullable();
            $table->string('contact_2')->nullable();
            $table->string('relation')->nullable();
            $table->string('nom_urgence')->nullable();
            $table->string('prenom_urgence')->nullable();
            $table->json('localisation_urgence')->nullable();
            $table->string('full_name_Urgence')->nullable();

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
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
