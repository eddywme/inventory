<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('items', function (Blueprint $table) {
				$table->increments('id');
				$table->string('name');
				$table->text('description');
				$table->integer('time_span');// in hours
				$table->string('photo_url')->nullable();
				$table->string('serial_number')->unique();
				$table->string('identifier');
				$table->string('slug')->unique();
				$table->string('location');
				$table->decimal('price', 11, 2);

				/* Item status : 0 = Taken, 1 = Reserved, 2 = Available*/
				$table->tinyInteger('status')->default(2);

				$table->string('model_number');
				$table->dateTime('date_acquired');

				$table->integer('lastly_edited_by')->nullable();
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
	public function down() {
		Schema::dropIfExists('items');
	}
}
