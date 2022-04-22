<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->id();
            $table->string('code') ->nullable();  
            $table->string('libelle') ->nullable();  
            $table->string('commentaire') ->nullable();

            $table->foreignId('client_id')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('set null');  //client_id 

            $table->foreignId('facture_id')
            ->nullable()
            ->constrained('factures')
            ->onUpdate('cascade')
            ->onDelete('set null');  // facture_id


            $table->foreignId('employee_id')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('set null'); //employee_id 


            $table->foreignId('created_user')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('set null'); //user_id 

            $table->foreignId('entreprise_id')
            ->nullable()
            ->constrained('entreprises')
            ->onUpdate('cascade')
            ->onDelete('set null'); //user_id 

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
        Schema::dropIfExists('commentaires');
    }
}
