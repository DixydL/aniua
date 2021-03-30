<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimeViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anime_views', function (Blueprint $table) {
            $table->unsignedBigInteger("anime_id");
            $table->string("ip");
            $table->timestamps();


            $table->index(["anime_id", "ip"]);
            $table->unique(["anime_id", "ip"]);
            $table->foreign('anime_id')->references('id')->on('animes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('anime_views');
    }
}
