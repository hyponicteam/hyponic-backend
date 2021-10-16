<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $fillable = [
        'plant_id',
        'name'
    ];

    public function todos() {
        return $this->belongsToMany(Todo::class, 'todo_days', 'day_id', 'todo_id')->withPivot('id');
    }
}
