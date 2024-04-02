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
    ];

    protected $casts = [
        'scheduled_at' => 'datetime', // Ensure Laravel casts this field to a Carbon instance
    ];
}
