<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TodoDay extends Model
{
    protected $fillable = [
        'todo_id',
        'day_id'
    ];

    public $timestamps = false;

    public function daily_activities() {
        return $this->belongsToMany(DailyActivity::class, 'todo_checks', 'todo_day_id', 'daily_activity_id')->withPivot('checked')->withTimestamps();
    }

    public function todo() {
        return $this->belongsTo(Todo::class, 'todo_id', 'id');
    }

    public function day() {
        return $this->belongsTo(Day::class, 'day_id', 'id');
    }
}
