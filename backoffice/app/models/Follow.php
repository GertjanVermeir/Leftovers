<?php

class Follow extends Eloquent
{
    protected $table = 'follow_user';

    protected $fillable = [
        'user_id',
        'follow_id',
    ];

    public function user()
    {
        return $this->belongsTo('User');
    }
} 