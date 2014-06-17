<?php

class Rating extends Eloquent
{
    protected $table = 'rating_recipe';

    protected $fillable = [
        'user_id',
        'recipe_id',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function recipe()
    {
        return $this->belongsTo('Recipe');
    }
} 