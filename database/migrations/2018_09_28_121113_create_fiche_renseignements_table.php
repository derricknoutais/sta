<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFicheRenseignementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fiche_renseignements', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('marque_id');
            $table->unsignedInteger('type_id');
            $table->unsignedInteger('moteur_id');
            $table->year('année');
            $table->string('chassis')->nullable();
            $table->text('détails')->nullable();
            $table->unsignedInteger('modèle_id');
            $table->foreign('modèle_id')->references('id')->on('modèles')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('marque_id')->references('id')->on('marques')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('moteur_id')->references('id')->on('moteurs')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('fiche_renseignements');
    }
}
