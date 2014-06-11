<?php

class Like extends Eloquent
{
    protected $table = 'like_user';

    protected $fillable = [
        'user_id',
        'recipe_id',
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