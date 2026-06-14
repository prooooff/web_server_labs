<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Observers\BlogPostObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Traits\Filterable; // 1. Трейт імпортовано

#[ObservedBy([BlogPostObserver::class])]
class BlogPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Filterable; // 2. Трейт підключено всередині класу

    const UNKNOWN_USER = 1;

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'excerpt',
        'content_raw',
        'is_published',
        'published_at',
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
