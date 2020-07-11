<?php

namespace App;


use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
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

    protected $primaryKey = 'cpf';
   
    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'is_admin'
    ];

    public static function compareHash($passwordField, $userPassword)
    {
        if (Hash::check($passwordField, $userPassword)) {
            return true;
        }
    }
    
}
