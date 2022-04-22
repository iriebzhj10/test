<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nom_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->nullable();
            // $table->string('title')->nullable();
            // $table->string('route')->nullable();
            // $table->string('icon')->nullable();

            //$table->string('slug')->unique()->nullable();
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
        Schema::dropIfExists('nom_permissions');
    }
}
