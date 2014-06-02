<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('email', 128)->unique();
            $table->string('givenname', 45);
            $table->string('surname', 45);
            $table->timestamp('birthday');
            $table->string('password', 60);
            $table->text('picture')->nullable();
            $table->string('role');
            $table->boolean('chef');
            $table->boolean('blacklist');
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
        Schema::drop('users');
	}

}