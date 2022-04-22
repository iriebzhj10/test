<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVersementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('versements', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->double('montant')->nullable();
            $table->unsignedBigInteger('facture_id')->nullable();
            $table->unsignedBigInteger('moyen_paiement_id')->nullable();
            $table->boolean('status')->nullable();
            $table->unsignedBigInteger('compte_id')->nullable();
            $table->unsignedBigInteger('emprunt_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('echeancier_id')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable();
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
        Schema::dropIfExists('versements');
    }
}

