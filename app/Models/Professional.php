<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professional extends Model
{
    use HasFactory;

    // Define fillable attributes for mass assignment
    protected $fillable = ['name', 'email', 'specialization', 'bio'];
    
    // Define any relationships, accessors, or additional methods below
}