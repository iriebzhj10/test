<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEcheanciersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('echeanciers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('libelle')->unique()->nullable();
            $table->string('description')->nullable();
            $table->boolean('state')->nullable();
            $table->date('date_echeance')->nullable();
            $table->double('montant')->nullable();
            $table->boolean('status')->default(0)->change();
            $table->unsignedBigInteger('facture_id')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable();
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
        Schema::dropIfExists('echeanciers');
    }
}
