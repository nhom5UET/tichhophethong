<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePacientes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::connection('mysql2')->table('pacientes', function($table)
		{
			$table->string("nome",80);
			$table->string("profissao",80);
			$table->string("endereco",150);
			$table->string("cidade",40);
			$table->string("estado",50);
			$table->string("pais",50);
			$table->string("celular",15);
			$table->string("email",100);
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
