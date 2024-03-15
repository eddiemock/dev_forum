<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model

{
    protected $fillable = ['user_id', 'reason', 'reportable_id', 'reportable_type'];

    public function reportable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
