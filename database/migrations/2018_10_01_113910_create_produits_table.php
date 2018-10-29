<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produits', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vend_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('nom')->nullable();
            $table->string('variante_une')->nullable();
            $table->string('variante_deux')->nullable();
            $table->string('variante_trois')->nullable();
            $table->string('marque')->nullable();
            $table->integer('fournisseur_id')->nullable();
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
        Schema::dropIfExists('produits');
    }
}
