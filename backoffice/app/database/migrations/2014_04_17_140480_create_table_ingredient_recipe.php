<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableIngredientRecipe extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingredient_recipe', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('ingredient_id')->nullable();
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            $table->unsignedInteger('recipe_id')->nullable();
            $table->foreign('recipe_id')->references('id')->on('recipes');
            $table->integer('amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ingredient_recipe');
    }

}