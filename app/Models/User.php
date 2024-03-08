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
    
    protected $fillable = [
        'name', 'email', 'password', 'country',
    ];
    

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

public function likedBy()
{
    // This mirrors the relationship in the User model
    return $this->belongsToMany(User::class, 'likes', 'discussion_id', 'user_id')->withTimestamps();
}



}

