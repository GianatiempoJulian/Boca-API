<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('stadium');
            $table->string('teamHome');
            $table->string('teamAway');
            $table->string('teamHomeImage');
            $table->string('teamAwayImage');
            $table->integer('goalsHome');
            $table->integer('goalsAway');
            $table->date('gameDate');
            $table->unsignedBigInteger('competitionId');
            $table->foreign('competitionId')->references('id')->on('competitions');
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
        Schema::dropIfExists('games');
    }
};
