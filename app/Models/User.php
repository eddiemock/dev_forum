<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Discussion;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    
    protected $fillable = [
        'name', 'email', 'password', 'country', 'verification_token',
    ];
    

    public function discussions(){
        return $this->hasMany(Discussion::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($user) {
            // Delete all related comments
            $user->comments()->delete();
            
            // Delete all related discussions
            $user->discussions()->each(function ($discussion) {
                $discussion->delete();  // Ensure Discussion model handles its relationships
            });

            // Handle likes, reports, appointments, and support groups
            $user->likes()->detach();
            $user->reports()->delete();
            $user->appointments()->delete();
            $user->supportGroups()->detach();
        });
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

public function role()
    {
        return $this->belongsTo(Role::class);
    }
public function hasRole($roleName)
{
    return $this->role->name === $roleName;
}


public function isAdmin()
{
    Log::info('isAdmin called for user: ' . $this->id . ' with role: ' . $this->role->name);
    return $this->hasRole('administrator');
}

public function isModerator()
{
    Log::info('isModerator called for user: ' . $this->id . ' with role: ' . $this->role->name);
    return $this->hasRole('moderator');
}

public function supportGroups()
{
    return $this->belongsToMany(SupportGroup::class)->withTimestamps();
}

public function appointments()
    
{
        return $this->hasMany(Appointment::class);
    }
 public function reports()
{
    return $this->hasMany(Report::class);
}
}

