<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportGroup extends Model
{
    use HasFactory;

    protected $table = 'support_groups'; // Explicitly define the table if not following Laravel's naming conventions

    protected $fillable = [
        'name',
        'topic',
        'scheduled_at',
        'description',
        'location', // Add this line
    ];
    

    protected $casts = [
        'scheduled_at' => 'datetime', // Ensure Laravel casts this field to a Carbon instance
    ];


    public function users()
{
    return $this->belongsToMany(User::class)->withTimestamps();
}
}
