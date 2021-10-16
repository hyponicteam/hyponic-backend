<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DailyActivity extends Model
{
    protected $fillable = [
        'user_id',
        'plant_id',
        'name'
    ];

    public function plant() {
        return $this->belongsTo(Plant::class);
    }

    public function todo_days() {
        return $this->belongsToMany(TodoDay::class, 'todo_checks', 'daily_activity_id', 'todo_day_id')->withPivot('checked')->withTimestamps();
    }
}
