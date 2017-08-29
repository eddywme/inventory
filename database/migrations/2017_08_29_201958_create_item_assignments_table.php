<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_assignments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('item_id');
            $table->integer('user_id');

            $table->dateTime('assigned_at');
            $table->dateTime('supposed_returned_at');
            $table->dateTime('returned_at')->nullable();


            $table->integer('assigned_by');
            $table->integer('marked_returned_by')->nullable();

            $table->integer('assigned_condition');
            $table->text('assigned_comment')->nullable();

            $table->integer('returned_condition')->nullable();
            $table->text('returned_comment')->nullable();
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
        Schema::dropIfExists('item_assignments');
    }
}
