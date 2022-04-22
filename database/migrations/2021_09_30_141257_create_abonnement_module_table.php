<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonnementModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnement_module', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('abonnement_id')->nullable();
            $table->unsignedBigInteger('module_id')->nullable();
            $table->date('date_debut')->nullable();
            $table->date('date_buttoire')->nullable();
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
        Schema::dropIfExists('abonnement_module');
    }
}
