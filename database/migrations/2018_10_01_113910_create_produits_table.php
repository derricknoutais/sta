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
            $table->string('vend_id')->unique();
            $table->string('sku');
            $table->string('nom');
            $table->string('variante_une')->nullable();
            $table->string('variante_deux')->nullable();
            $table->string('variante_trois')->nullable();
            $table->double('prix')->default(0);
            $table->string('marque')->nullable();
            $table->string('nom_fournisseur')->nullable();
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
