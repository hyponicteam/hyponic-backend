<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\UsesUUID;

class Plant extends Model
{
    use UsesUUID;

    protected $fillable = [
        'name',
        'user_id'
    ];

    public function growths() {
        return $this->hasMany(Growth::class);
    }
}