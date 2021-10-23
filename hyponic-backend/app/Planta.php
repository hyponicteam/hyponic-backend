<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    protected $fillable = [
        'name'
    ];

    public function days() {
        return $this->hasMany(Day::class);
    }
}
