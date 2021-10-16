<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TodoCheck extends Pivot
{
    protected $fillable = [
        'daily_activity_id',
        'todo_day_id',
        'checked'
    ];

    public $timestamps = false;
}
