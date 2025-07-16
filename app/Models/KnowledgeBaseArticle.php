<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\KnowledgeBaseCategory;
use App\Models\KnowledgeBaseSearch;

class KnowledgeBaseArticle extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'views',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });

        static::updating(function ($article) {
            if ($article->isDirty('title') && empty($article->slug)) {
                $article->slug = Str::slug($article->title);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(KnowledgeBaseCategory::class, 'category_id');
    }

    public function incrementViewCount()
    {
        $this->increment('views');
    }

    public function getExcerptAttribute($length = 200)
    {
        $content = strip_tags($this->content);
        return Str::limit($content, $length);
    }

    public function getUrlAttribute()
    {
        return route('knowledge-base.article', [
            'category' => $this->category->slug,
            'article' => $this->slug
        ]);
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopePopular($query, $limit = 5)
    {
        return $query->orderBy('views', 'desc')->take($limit);
    }

    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%");
    }
}
