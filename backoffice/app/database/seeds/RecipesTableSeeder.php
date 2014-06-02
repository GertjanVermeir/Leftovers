<?php
/**
 * Created by PhpStorm.
 * User: gertjan
 * Date: 06/11/13
 * Time: 18:05
 */

class IngredientTableSeeder extends Seeder
{
    public function run()
    {
        $ingredient = [
            'name' => 'bloemkool',
            'description' => 'Populaire groente',
            'category' => 'Groente',
            'calories' => 50,
        ];

        Ingredient::create($ingredient);
    }
} 