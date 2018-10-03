<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoteursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moteurs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('marque_id');
            $table->string('nom')->unique();
            $table->unique(['nom', 'marque_id']);
            $table->foreign('marque_id')->references('id')->on('marques')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('moteurs');
    }
}
