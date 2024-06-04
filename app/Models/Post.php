<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image_path',
        'is_published',
        'user_id',
        'category_id',
        'published_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags() // relación muchos a muchos polimorfica
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function comments() // relación uno a muchos polimorfica
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
