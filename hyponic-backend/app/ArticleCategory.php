<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class ArticleCategory extends Model
{
    protected $fillable = [
        'image_url',
        'name'
    ];

    public function getUrlAttribute($url) {
        return config('app.url') . Storage::url($url);
    }

    public function articles() {
        return $this->hasMany(Article::class);
    }
}
