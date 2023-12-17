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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->integer('goals')->nullable();
            $table->integer('assists')->nullable();
            $table->integer('cleansheets')->nullable();
            $table->integer('redcards')->nullable();
            $table->string('position');
            $table->integer('trophies')->nullable();
            $table->integer('wins')->nullable();
            $table->integer('draws')->nullable();
            $table->integer('loses')->nullable();
            $table->integer('goals_today')->nullable();
            $table->integer('assists_today')->nullable();
            $table->integer('cleansheets_today')->nullable();
            $table->integer('redcard_today')->nullable();
            $table->string('image');
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
        Schema::dropIfExists('players');
    }
};
