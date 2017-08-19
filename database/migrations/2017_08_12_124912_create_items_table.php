<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->integer('time_span'); // in hours
            $table->string('photo_url')->nullable();
            $table->string('serial_number')->unique();
            $table->string('identifier');
            $table->string('slug')->unique();
            $table->string('location');
            $table->decimal('price',11,2);
            $table->boolean('is_available')->default(true);
            $table->string('model_number');
            $table->dateTime('date_acquired');

            $table->integer('lastly_edited_by')->nullabe();
            $table->integer('recorded_by');

            $table->integer('owned_by');
            $table->integer('category_id');

            $table->integer('condition_id');

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
        Schema::dropIfExists('items');
    }
}
