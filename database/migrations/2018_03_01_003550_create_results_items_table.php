<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results_items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('indication');
            $table->string('answer');
            $table->integer('result')->unsigned();
            $table->foreign('result')->references('id')->on('results');
            $table->integer('by')->unsigned();
            $table->foreign('by')->references('id')->on('users');
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
        Schema::dropIfExists('results_items');
    }
}
