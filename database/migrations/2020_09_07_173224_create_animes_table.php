<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("name_origin");
            $table->text("description");
            $table->string("country");
            $table->string("studio");
            $table->string("type");
            $table->integer("current_episodes");
            $table->integer("count_episodes");
            $table->date("release_date");
            $table->integer("views")->default(0);
            $table->integer("poster_id")->nullable();
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
        Schema::dropIfExists('animes');
    }
}
