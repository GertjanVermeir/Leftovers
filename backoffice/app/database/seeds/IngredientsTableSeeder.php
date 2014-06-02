<?php
/**
 * Created by PhpStorm.
 * User: gertjan
 * Date: 06/11/13
 * Time: 18:05
 */

class IngredientsTableSeeder extends Seeder
{
    public function run()
    {
        $ingredient = [
            'name' => 'bloemkool',
            'description' => 'Populaire groente',
            'type' => 'Groente',
            'calories' => 50,
            'unit' => 'gr',
        ];

        Ingredient::create($ingredient);
    }
} 