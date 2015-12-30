<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCkContact extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create("ck_contact",function($table){
			$table->increments("contact_id");
			$table->string("first_name");
			$table->string("middel_name");
			$table->string("last_name");
			$table->string("phone_number");
			$table->string("display_name");
			$table->string("email");
			$table->string("address_line_1");
			$table->string("city");
			$table->string("state");
			$table->string("postal_code");
			$table->string("country");
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
		//
	}

}
