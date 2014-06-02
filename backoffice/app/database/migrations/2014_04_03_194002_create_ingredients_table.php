<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIngredientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('ingredients', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',45)->unique();
            $table->text('description');
            $table->string('type',128);
            $table->string('unit',45);
            $table->integer('calories');
            $table->timestamps();
            $table->softDeletes();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('ingredients');
	}

}