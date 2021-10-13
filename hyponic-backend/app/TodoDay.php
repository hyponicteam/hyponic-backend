<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TodoDay extends Pivot
{
    protected $fillable = [
        'todo_id',
        'day_id'
    ];
}
