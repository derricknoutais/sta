
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProduitCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produit_commandes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('produit_id');
            $table->unsignedInteger('commande_id');
            // $table->foreign('produit_id')->references('vend_id')->on('produits')->onDelete('cascade')->onUpdate('cascade');
            // $table->foreign('commande_id')->references('id')->on('commandes')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('produit_commandes');
    }
}
