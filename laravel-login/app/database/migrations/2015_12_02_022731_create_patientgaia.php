<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientgaia extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::connection('mysql4')->table('patient_demographics', function($table)
		{
			$table->string("fname");
			$table->string("mname");
			$table->string("lname");
			$table->string("address");
			$table->string("city");
			$table->string("state");
			$table->string("country");
			$table->string("mobile_phone");
			$table->string("email");
			$table->text("zipcode");
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
