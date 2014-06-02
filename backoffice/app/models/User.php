<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [
        'password',
        'created',
        'updated',
        'deleted',

    ];

    protected $fillable = [
        'email',
        'givenname',
        'surname',
        'birthday',
        'street',
        'chef',
        'picture'
    ];

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	}

    public static function boot() {
        parent::boot();

        self::creating(function($user){
            $user->password = Hash::make($user->password);
        });
    }

    public function recipes(){
        return $this->hasMany('Recipe');
    }

    public function comments(){
        return $this->belongsToMany('Recipe')->withPivot('description');
    }

    public function likes(){
        return $this->belongsToMany('Recipe');
    }

    public function ratings(){
        return $this->belongsToMany('Recipe')->withPivot('rating');
    }

    public function followers(){
        return $this->belongsToMany('User');
    }
}