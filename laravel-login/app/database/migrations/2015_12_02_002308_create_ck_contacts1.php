<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCkContacts1 extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::connection('mysql3')->table('ck_contacts', function($table)
		{
			$table->string("first_name",50);
			$table->string("middle_name",50);
			$table->string("last_name",50);
			$table->string("phone_number",15);
			$table->string("display_name");
			$table->string("email",150);
			$table->string("address_line_1",150);
			$table->string("city",50);
			$table->string("state",50);
			$table->string("postal_code",50);
			$table->string("country",50);
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
