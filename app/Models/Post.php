<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    // Permite definir el tipo de dato de los campos cuando estos son llamados desde cualquier proceso
    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
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
            // get: fn() => $this->image_path ?? 'https://camarasal.com/wp-content/uploads/2020/08/default-image-5-1.jpg',
            get: function(){
                if( $this->image_path ){
                    if( substr( $this->image_path, 0, 8 ) == 'https://' )
                    {
                        return $this->image_path;
                    }
                    // return asset('storage/' . $this->image_path);
                    // lo de 👇 es igual a lo de ☝️
                    return Storage::url($this->image_path);

                    // se usa este porque se establecio el disco con s3, por ello se esta consumiendo un elemento privado de digital ocean
                    // return route('posts.image', $this);
                }else{
                    return 'https://camarasal.com/wp-content/uploads/2020/08/default-image-5-1.jpg';
                }
            }
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

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    // Route model binding
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeFilter($query, $filters)
    {
        return $query->when($filters['categories'] ?? null, function ($query, $categories) {
            $query->whereIn('category_id', $categories);
        })
        ->when($filters['order'] ?? 'new', function ($query, $order) {
            $sort = $order === 'new' ? 'desc' : 'asc';
            $query->orderBy('published_at', $sort);
        })
        ->when($filters['tag'] ?? null, function ($query, $tag) {
            // se usa whereHas para agregar condición con x módelo relacionado, se emplea use ($variable) 
            // para agregar al ambito de una sub función una variable que esta definida afuera
            $query->whereHas('tags', function ($query) use ($tag) { 
                $query->where('tags.name', $tag);
            });
        });
    }

    protected static function booted()
    {
        static::addGlobalScope('written', function ($query) { // uso de query scopes globales
            if( request()->routeIs('admin.*') ) // validar si se realiza la petición desde área administrativa
            {
                $query->where('user_id', auth()->id());
            }
        });
        
        static::addGlobalScope('published', function ($query) { // uso de query scopes globales
            if( !request()->routeIs('admin.*') ) // validar si se realiza la petición desde fuera del área administrativa
            {
                $query->where('is_published', true);
            }
        });
    }   
}
