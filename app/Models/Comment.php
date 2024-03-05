<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['body', 'discussion_id','user_id','is_approved']; 
    public function post()
    {

        return $this->belongsTo(Discussion::class);

    }

public function user()
{
    return $this->belongsTo(User::class);
}
public function likers()
    {
        return $this->belongsToMany(User::class, 'likes_table', 'comment_id', 'user_id')->withTimestamps();
    }


}
