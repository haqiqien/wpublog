<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'author', 'body'];

    protected $with = ['author', 'category'];
    
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeFilter(Builder $query, array $filters): void
    {
        // if(isset($filters['search']) ? $filters['search'] : false){
        //     return $query->where('title', 'like', '%' . $filters['search'] . '%')
        //                  ->orWhere('body', 'like', '%' . $filters['search'] . '%');
        // }
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                ->orWhere('body', 'like', '%' . $search . '%');
            });
        });


        $query->when($filters['category'] ?? false, function($query, $category){
            return $query->whereHas('category', fn(Builder $query) =>
                $query->where('slug', $category)
            );
        });

        $query->when($filters['author'] ?? false, function($query, $author){
            return $query->whereHas('author', fn(Builder $query) =>
                $query->where('username', $author)
            );
        });
    }   
}
