<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class VideoCategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image_url'
    ];

    public function getUrlAttribute($url) {
        return config('app.url') . Storage::url($url);
    }

    public function videos() {
        return $this->hasMany(Video::class);
    }
}
