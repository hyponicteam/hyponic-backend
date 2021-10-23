<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UsesUUID;
use Carbon\Carbon;

class Plant extends Model
{
    use UsesUUID;

    protected $fillable = [
        'name',
        'user_id'
    ];

    protected $appends = [
        'time_difference'
    ];

    public function getTimeDifferenceAttribute() {
        return Carbon::now()->diffForHumans($this->updated_at);
    }

    public function growths() {
        return $this->hasMany(Growth::class)->orderBy('updated_at', 'desc');
    }
}