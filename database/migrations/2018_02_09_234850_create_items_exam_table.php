<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_exam', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned()->nullable()->after('id');
            $table->foreign('parent')->references('id')->on('items_exam');
            $table->string('name');
            $table->enum('type', ['Question', 'Answer'])->nullable();
            $table->enum('subtype', ['Open', 'Single option', 'Multiple option'])->nullable();
            $table->timestamps();
            $table->integer('by')->unsigned();
            $table->foreign('by')->references('id')->on('users');
            $table->integer('exam')->unsigned();
            $table->foreign('exam')->references('id')->on('exams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_exam');
    }
}
