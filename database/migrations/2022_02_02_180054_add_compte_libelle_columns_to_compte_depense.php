<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompteLibelleColumnsToCompteDepense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('compte_depense', function (Blueprint $table) {
            //
            $table->string('compte_libelle')->nullable();
            $table->integer('date_recurrente')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('compte_depense', function (Blueprint $table) {
            //
        });
    }
}
