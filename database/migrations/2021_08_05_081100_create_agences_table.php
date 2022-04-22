<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agences', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('matricule')->unique()->nullable();
            $table->string('libelle')->nullable();
            $table->string('adresse')->nullable();
            $table->string('slug')->nullable();
            $table->string('contact')->nullable();
            $table->string('email')->unique();
            $table->float('longitude')->nullable();
            $table->float('latitude')->nullable();
            $table->text('description')->nullable();
            $table->string('ville')->nullable();
            $table->boolean('status')->nullable();

            $table->unsignedBigInteger('pays_id')->nullable();
            $table->json('localisation')->nullable();
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
        Schema::dropIfExists('agences');
    }
}
