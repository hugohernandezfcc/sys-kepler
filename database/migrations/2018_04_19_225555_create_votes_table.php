<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['Positivo', 'Negativo'])->nullable();
            $table->integer('by')->unsigned();
            $table->foreign('by')->references('id')->on('users');
            $table->integer('question_forum')->unsigned();
            $table->foreign('question_forum')->references('id')->on('questions_forums');
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
        Schema::dropIfExists('votes');
    }
}
