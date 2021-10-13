<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'name'
    ];

    public function days() {
        return $this->belongsToMany(Day::class, 'todo_day');
    }
}
