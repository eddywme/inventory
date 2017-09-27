<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('item_id');
            $table->dateTime('pickup_time');
            $table->integer('approved_by')->nullable();
            $table->dateTime('approved_on')->nullable();
            $table->boolean('is_accepted')->default(false); // Whether the admin has accepted the request If not accepted = It is  pending
            $table->boolean('is_concluded')->default(0); // Whether The User Has Taken The Item

            $table->boolean('is_rejected')->default(false);
            $table->integer('rejected_by')->nullable();
            $table->dateTime('rejected_on')->nullable();
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
        Schema::dropIfExists('item_requests');
    }
}
