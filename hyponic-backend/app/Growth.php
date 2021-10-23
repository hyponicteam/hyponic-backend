<?php

namespace App;

use App\Http\Traits\UsesUUID;
use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    use UsesUUID;

    protected $fillable = [
        'plant_height',
        'leaf_width',
        'temperature',
        'acidity',
        'plant_id'
    ];
}
