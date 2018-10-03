<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandeAchatProduitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demande_achat_produits', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('demande_achat_id');
            $table->unsignedInteger('produit_id');
            $table->double('coût')->nullable();
            $table->boolean('checked')->default(0);
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
        Schema::dropIfExists('demande_achat_produits');
    }
}
