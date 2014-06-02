<?php

class Book extends Eloquent
{
    protected $table = 'book';

    protected $fillable = [
        'name',
        'description',
        'layout',
    ];

    public function recipes(){
        return $this->belongsToMany('Recipe')->withPivot('notes','order');
    }

} 