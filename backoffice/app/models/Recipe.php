<?php

class Recipe extends Eloquent
{
    protected $table = 'recipes';

    protected $fillable = [
        'name',
        'time',
        'level',
        'description',
        'course',
        'persons',
        'image',
        'type',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function ingredients(){
        return $this->belongsToMany('Ingredient')->withPivot('amount');
    }

    public function books(){
        return $this->belongsToMany('Book')->withPivot('notes','order');
    }

    public function comments(){
        return $this->belongsToMany('User')->withPivot('description');
    }

    public function likes(){
        return $this->belongsToMany('User');
    }

    public function ratings(){
        return $this->belongsToMany('User')->withPivot('rating');
    }
} 