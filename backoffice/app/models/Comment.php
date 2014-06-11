<?php

class Comment extends Eloquent
{
    protected $table = 'comments';

    protected $fillable = [
        'user_id',
        'recipe_id',
        'description',
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