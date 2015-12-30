<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create("patients",function($table){
			$table->increments("id_patient");
			$table->string("firstname");
			$table->string("middelname");
			$table->string("lastname");
			$table->string("phonenumber");
			$table->string("displayname");
			$table->string("email");
			$table->string("address");
			$table->string("city");
			$table->string("state");
			$table->string("postalcode");
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
