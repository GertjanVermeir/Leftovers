<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecipesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('recipes', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name',128);
            $table->integer('time');
            $table->integer('persons');
            $table->string('level',45);
            $table->text('description');
            $table->string('course',45);
            $table->string('type',45);
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedInteger('user_id');
            $table->text('image');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('recipes');
	}

}