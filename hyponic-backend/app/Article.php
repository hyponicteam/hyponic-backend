<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image_url',
        'article_category_id',
        'user_id'
    ];

    public function getUrlAttribute($url) {
        return config('app.url') . Storage::url($url);
    }

    public function articleCategory() {
        return $this->belongsTo(ArticleCategory::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
