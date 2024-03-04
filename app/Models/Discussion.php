<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{
    use HasFactory;

    protected $table = "discussions";

    protected $fillable = ['post_title', 'description', 'brief', 'user_id', 'category_id'];

    

    public function user(){
        return $this->belongsTo(User::class);
    }


    public function comments()
    {

         return $this->hasMany(Comment::class)->where('is_approved', true);       

    }

    public function likes(){

        return $this->belongsToMany(User::class, 'likes_table')->withTimestamps();

    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category()
{
    return $this->belongsTo(\App\Models\Category::class);
}

}

