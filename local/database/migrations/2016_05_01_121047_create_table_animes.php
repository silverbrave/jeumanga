<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateTableAnimes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->integer('nb_ep');
            $table->longText('synopsis');
            $table->string('imgAnime');
            $table->string('logo');
            $table->string('op');
            $table->integer('idgenre');
            $table->date('annee');
            $table->string('statut');
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
        Schema::drop('animes');
    }
}
