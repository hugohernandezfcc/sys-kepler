<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('concept')->nullable();
            $table->decimal('amount', 8, 2)->nullable();
            $table->enum('type', ['Active', 'Pasive']);
            $table->enum('cost_by', ['user', 'course']);
            $table->integer('course')->unsigned();
            $table->foreign('course')->references('id')->on('school_cycles');
            $table->integer('user')->unsigned();
            $table->foreign('user')->references('id')->on('users');
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('costs');
    }
}
