<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'news_text',
        'news_preview',
        'publication_date',
        'views',
    ];

    public function news_categories()
    {
        return $this->belongsTo(NewsCategory::class);
    }
}
