<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function title(): Attribute {

        return new Attribute(
            // mutador -> permite definir como se guarda el valor de title en la db | fn()=>{} -> corresponde a una función flecha
            set: fn($value) => strtolower($value),
            // accesor -> permite definir con que formato se debe mostrar el titulo cuando se invocado/llamado
            get: fn($value) => ucfirst($value),
        );
    }

    protected function image(): Attribute {

        return new Attribute(
            // operador ?? -> permite definir por defecto $this->image_path en caso verdadero
            get: fn() => $this->image_path ?? 'https://camarasal.com/wp-content/uploads/2020/08/default-image-5-1.jpg',
        );
    }

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
