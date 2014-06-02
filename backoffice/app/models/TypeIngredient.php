<?php

class TypeIngredient
{
    public $types = [
    'potato' => 'Aardappelproducten',
    'butter' => 'Boter, margarine en room',
    'bread' => 'Brood en beschuiten',
    'chocolate' => 'Chocolade en snoepgoed',
    'honey' => 'Confituur en honing',
    'pasta' => 'Deegwaren, graanproducten en rijst',
    'liquids' => 'Dranken, alle soorten',
    'milk' => 'Eieren, melkproducten en yoghurt',
    'fruit' => 'Fruit',
    'chicken' => 'Gevogelte',
    'vegetables' => 'Groenten',
    'ice' => 'Ijs',
    'cheese' => 'Kaas',
    'spices' => 'Kruiden en smaakmakers',
    'oil' => 'Olie, noten en zaden',
    'sauce' => 'Sauzen en dressings',
    'sugar' => 'Suiker en zoetstoffen',
    'fish' => 'Vis en zeevruchten',
    'meat' => 'Vlees',
    'other' => 'Andere'
    ];

    public function typeslist(){
        $sorted = ksort($this->types);
        return $sorted;
    }

} 