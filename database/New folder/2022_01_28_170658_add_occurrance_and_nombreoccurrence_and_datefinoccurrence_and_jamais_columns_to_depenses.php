<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOccurranceAndNombreoccurrenceAndDatefinoccurrenceAndJamaisColumnsToDepenses extends Migration
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
            $table->string('occurrence')->nullable();
            $table->integer('nombreoccurrence')->nullable();
            $table->date('datefinoccurrence')->nullable();
            $table->string('jamais')->nullable();  

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
        });
    }
}
