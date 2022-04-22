<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable();
            $table->string('matricule')->unique()->nullable();
            $table->string('libelle')->nullable();
            $table->string('type')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->double('prix_achat')->nullable();
            $table->double('prix_vente')->nullable();
            $table->float('poids')->nullable();
            $table->string('lien_video')->nullable();

            $table->unsignedBigInteger('type_article_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->unsignedBigInteger('entreprise_id')->nullable();

            $table->unsignedBigInteger('created_user')->nullable();
            $table->unsignedBigInteger('updated_user')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('delete_update_at')->default(0);

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
        Schema::dropIfExists('articles');
    }
}
