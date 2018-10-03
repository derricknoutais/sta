<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonCommandeProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bon_commande_produits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('bon_commande_id');
            $table->unsignedInteger('produit_id');
            $table->double('coût');
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
        Schema::dropIfExists('bon_commande_produits');
    }
}
