<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsConversationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items_conversations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent')->unsigned()->nullable()->after('id');
            $table->foreign('parent')->references('id')->on('items_conversations');
            $table->string('name');
            $table->enum('type', ['Question', 'Answer', 'Answer to Answer'])->nullable();
            $table->timestamps();
            $table->integer('by')->unsigned();
            $table->foreign('by')->references('id')->on('users');
            $table->integer('conversation')->unsigned();
            $table->foreign('conversation')->references('id')->on('conversations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items_conversations');
    }
}
