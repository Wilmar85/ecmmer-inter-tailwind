<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeBaseSearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'query',
        'results_count',
        'clicks_count'
    ];

    protected $casts = [
        'results_count' => 'integer',
        'clicks_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function logSearch($query, $resultsCount)
    {
        $search = static::firstOrNew(['query' => $query]);
        
        if ($search->exists) {
            $search->increment('results_count');
        } else {
            $search->results_count = 1;
            $search->clicks_count = 0;
        }

        $search->save();

        return $search;
    }

    public function recordClick()
    {
        $this->increment('clicks_count');
        return $this;
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->where('results_count', '>', 0)
                    ->orderBy('clicks_count', 'desc')
                    ->take($limit);
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
}
