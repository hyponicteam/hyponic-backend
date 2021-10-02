<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Video extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'video_url',
        'video_category_id',
        'user_id'
    ];

    public function getUrlAttribute($url) {
        return config('app.url' . Storage::url($url));
    }

    public function videoCategory() {
        return $this->belongsTo(VideoCategory::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
