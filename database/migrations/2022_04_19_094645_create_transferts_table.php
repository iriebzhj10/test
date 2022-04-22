<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferts', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->double('montant')->nullable();

            $table->foreignId('compte_crediteur')
            ->nullable()
            ->constrained('comptes')
            ->onUpdate('cascade')
            ->onDelete('set null');  

            $table->foreignId('compte_debiteur')
            ->nullable()
            ->constrained('comptes')
            ->onUpdate('cascade')
            ->onDelete('set null');  
            
            $table->foreignId('entreprise_id')
            ->nullable()
            ->constrained('entreprises')
            ->onUpdate('cascade')
            ->onDelete('set null');  

            $table->foreignId('created_user')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('set null');  

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
        Schema::dropIfExists('transferts');
    }
}
