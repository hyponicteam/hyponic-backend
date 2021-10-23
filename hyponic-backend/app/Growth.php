<?php

namespace App;

use App\Http\Traits\TimeFormat;
use App\Http\Traits\UsesUUID;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Growth extends Model
{
    use UsesUUID, TimeFormat;

    protected $fillable = [
        'plant_height',
        'leaf_width',
        'temperature',
        'acidity',
        'plant_id'
    ];

    protected $touches = [
        'plant'
    ];

    public function plant() {
        return $this->belongsTo(Plant::class);
    }
}
