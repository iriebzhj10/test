<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSousDepensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_depenses', function (Blueprint $table) {
            $table->id();
            $table->string('article')->nullable();;
            $table->double('prix')->nullable();
            $table->double('quantite')->nullable();
            $table->unsignedBigInteger('depense_id')->nullable();
            $table->foreign('depense_id')
            ->nullable()
            ->references('id')
            ->on('depenses')
            ->onDelete('set null')
            ->onUpdate('cascade');
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
        Schema::dropIfExists('sous_depenses');
    }
}
