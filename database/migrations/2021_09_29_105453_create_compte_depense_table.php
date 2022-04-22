<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompteDepenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compte_depense', function (Blueprint $table) {
            $table->id();
            $table->foreignId('depense_id')->nullable();
            $table->foreignId('compte_id')->nullable();
            $table->date('date_reglement')->nullable();
            $table->double('montant_reglement')->nullable();
            $table->string('compte_libelle')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('compte_depense');
    }
}
