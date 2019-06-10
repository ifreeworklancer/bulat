<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->increments('id');
			$table->unsignedInteger('product_id');
            $table->float('price');
			$table->unsignedInteger('user_id')->nullable();
			$table->string('name')->nullable();
			$table->string('contact')->nullable();
			$table->text('message')->nullable();
			$table->text('comment')->nullable();
			$table->string('status')->default('processing');
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
		Schema::dropIfExists('orders');
	}
}
