<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableBookRecipe extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_recipe', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('book_id')->nullable();
            $table->foreign('book_id')->references('id')->on('books');
            $table->unsignedInteger('recipe_id')->nullable();
            $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->text('notes');
            $table->integer('order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('book_recipe');
    }

}