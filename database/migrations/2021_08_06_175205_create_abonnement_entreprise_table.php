<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbonnementEntrepriseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonnement_entreprise', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();

            $table->foreignId('abonnement_id')
            ->nullable()
            ->constrained('abonnements')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreignId('entreprise_id')
            ->nullable()
            ->constrained('entreprises')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreignId('module_id')
            ->nullable()
            ->constrained('modules')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreignId('created_user')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('set null');

            $table->foreignId('updated_user')
            ->nullable()
            ->constrained('users')
            ->onUpdate('cascade')
            ->onDelete('set null');

           // $table->unsignedBigInteger('abonnement_id');

            $table->string('moyen_paiement')->nullable();
            $table->string('token')->nullable();
            $table->double('montant_ht')->nullable();
            $table->double('montant_tva')->nullable();
            $table->double('montant_remise')->nullable();
            $table->double('montant_ttc')->nullable();
            $table->double('duree')->nullable();
            $table->date('date_final')->nullable();
            $table->json('options')->nullable();
            $table->boolean('status_paiement')->nullable();
            $table->boolean('active')->nullable();
            $table->integer('nbr_abonnes')->nullable();
            $table->integer('nbr_usr_created')->nullable();
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
        Schema::dropIfExists('abonnement_entreprises');
    }
}
