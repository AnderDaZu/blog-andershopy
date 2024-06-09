<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    protected function name(): Attribute {
        return new Attribute(
            set: fn($value) => strtolower($value),
            get: fn($value) => ucfirst($value),
        );
    }

    public function posts() // relación muchos a muchos polimorfica
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }
}
