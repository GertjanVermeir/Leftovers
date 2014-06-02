<?php

class TypeRecipe
{
    public $types = [
        'Chinees',
        'Grieks',
        'Afrikaans',
        'Fast-Food',
        'Vegetarisch',
        'Stoofpot',
    ];

    public function typeslist(){
        $sorted = ksort($this->types);
        return $sorted;
    }

} 