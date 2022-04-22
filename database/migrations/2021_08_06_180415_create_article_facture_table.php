<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleFactureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_facture', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facture_id')->nullable();
            $table->double('taxe_id')->nullable();
            $table->double('prix')->nullable();
            $table->double('quantite')->nullable();
            $table->double('prix_vente')->nullable();    	// Prix de vente d'un article
            $table->double('qte_un_article')->nullable();  	// qtes d'un article
            $table->double('prix_total')->nullable();      // Prix de vente total d'un meme article selon la quantite
            $table->double('options')->nullable();
            $table->unsignedBigInteger('article_id')->nullable();
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
        Schema::dropIfExists('facture_articles');
    }
}
