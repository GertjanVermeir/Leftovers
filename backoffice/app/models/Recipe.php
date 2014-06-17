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

    public function books(){
        return $this->belongsToMany('Book')->withPivot('notes','order');
    }

    public function ingredients(){
        return $this->belongsToMany('Ingredient')->withPivot('amount');
    }

    public function comments(){
        return $this->belongsToMany('Comment');
    }

    public function likes(){
        return $this->hasMany('Like');
    }

    public function ratings(){
        return $this->hasMany('Rating');
    }
} 