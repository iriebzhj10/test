<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('libelle')->nullable();
            $table->text('description')->nullable();
            $table->string('fournisseur')->nullable();
            $table->string('facture_fournisseur')->nullable();
            $table->double('montant_depense')->nullable();
            $table->date('date_emission')->nullable();
            $table->unsignedBigInteger('categorie_id')->nullable();
            $table->unsignedBigInteger('type_depense_id')->nullable();
            // $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('entreprise_id')->nullable();
            $table->unsignedBigInteger('agence_id')->nullable();
            $table->unsignedBigInteger('projet_id')->nullable();
            $table->unsignedBigInteger('departement_id')->nullable();
            $table->unsignedBigInteger('employe_id')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->string('status')->nullable();
            $table->string('occurrence')->nullable();
            $table->string('type_depense')->nullable();
            $table->integer('date_recurrente')->nullable();
            $table->integer('nombreoccurrence')->nullable();
            $table->date('datefinoccurrence')->nullable();
            $table->string('status_depense')->nullable();
            $table->double('impaye')->nullable();
            $table->double('paye')->nullable();
            $table->string('jamais')->nullable();  
            $table->string('projet')->nullable();
            $table->string('departement')->nullable();
            $table->string('agence')->nullable();
            $table->string('employe')->nullable();

            // $table->boolean('status')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('depenses');
    }
}
