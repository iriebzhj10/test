<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('libelle')->nullable();
            $table->date('date_echeance')->nullable();
            $table->date('date_emission')->nullable();
            $table->string('designation')->nullable();
            $table->text('description')->nullable();
            $table->double('quantite')->nullable();
            $table->double('total_ht')->nullable();
            $table->double('total_taxe')->nullable();
            $table->double('total_livraison')->nullable();
            $table->float('remise')->nullable();
            $table->double('total_ttc')->nullable();
            $table->string('state')->nullable();  //solde,a payer,partiel
            $table->string('etat')->nullable();  //brouillon,valide,termine
            $table->string('transition')->nullable();  //soit uniquement que dans devis soit dans devis et facture

            // $table->float('tva')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable();
            $table->unsignedBigInteger('devise_id')->nullable();
            $table->unsignedBigInteger('taxe_id')->nullable();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('type_facture_id')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->string('status')->nullable(); //  devis , facture ,bon de commande
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
        Schema::dropIfExists('factures');
    }
}
