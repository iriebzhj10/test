<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjetAndEmployeAndDepartementAndAgenceColumnsToDepenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('depenses', function (Blueprint $table) {
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('depenses', function (Blueprint $table) {
            //
          $table->string('projet')->nullable();
          $table->string('departement')->nullable();
          $table->string('agence')->nullable();
          $table->string('employe')->nullable();
        });
    }
}
