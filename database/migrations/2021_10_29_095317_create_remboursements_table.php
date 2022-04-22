<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemboursementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     *      * @return void
     */
    public function up()
    {
        Schema::create('remboursements', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique()->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('libelle')->nullable();
            $table->text('description')->nullable();
            $table->double('montant_remboursement')->nullable();
            $table->double('montant_verse')->nullable();
            $table->date('date_remboursement')->nullable();
            $table->string('status')->nullable();//solde,apayer,partiel


            $table->unsignedBigInteger('emprunt_id')->nullable();
            $table->unsignedBigInteger('entreprise_id')->nullable();
            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();

            $table->foreign('emprunt_id')
                    ->nullable()
                    ->references('id')
                    ->on('emprunts')
                    ->onDelete('set null')
                    ->onUpdate('cascade');

            $table->foreign('entreprise_id')
                    ->nullable()
                    ->references('id')
                    ->on('entreprises')
                    ->onDelete('set null')
                    ->onUpdate('cascade');

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
        Schema::dropIfExists('remboursements');
    }
}
