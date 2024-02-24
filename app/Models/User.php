<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Discussion;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    

    public function discussions(){
        return $this->hasMany(Discussion::class);
    }


    
public function likes()
{
    return $this->belongsToMany(Discussion::class, 'likes_table')->withTimestamps();
}


public function comments()
{
    return $this->hasMany(Comment::class);
}

}

