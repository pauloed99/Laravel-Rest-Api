<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'cpf', 'email', 'password'
    ];

    protected $primaryKey = 'email';
   
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public static function compareHash($passwordField, $userPassword)
    {
        if (Hash::check($passwordField, $userPassword)) {
            return true;
        }
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function books()
    {
        return $this->belongsToMany('App\Book', 'book_user', 'email', 'book_id')
        ->withTimestamps()->withPivot('id');
    }
    
}
