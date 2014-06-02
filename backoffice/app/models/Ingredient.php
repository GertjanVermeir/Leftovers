<?php

class Ingredient extends Eloquent
{
    protected $table = 'ingredients';

    protected $fillable = [
        'name',
        'description',
        'calories',
        'type',
        'unit',
    ];

    public function recipes(){
        return $this->belongsToMany('Recipe')->withPivot('amount');
    }

} 