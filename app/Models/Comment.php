<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = ['body', 'discussion_id']; 
    public function post()
    {

        return $this->belongsTo(Discussion::class);

    }
}
