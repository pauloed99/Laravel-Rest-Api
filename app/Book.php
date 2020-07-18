<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['name', 'description', 'year', 'language',
    'author', 'pages', 'price'];
    
    public function users(){
        return $this->belongsToMany('App\User', 'book_user', 'book_id', 'email')
        ->withTimestamps()->withPivot('id');
    }
}
