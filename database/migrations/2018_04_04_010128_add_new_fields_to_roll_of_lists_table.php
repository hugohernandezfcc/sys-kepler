<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFieldsToRollOfListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roll_of_lists', function (Blueprint $table) {
            $table->integer('percentage');
            $table->text('missing')->nullable();
            $table->integer('group_id')->unsigned();
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roll_of_lists', function (Blueprint $table) {
            $table->dropColumn('percentage');
            $table->dropColumn('missing');
            $table->dropForeign(['group_id']);
            $table->dropColumn('group_id');
        });
    }
}
