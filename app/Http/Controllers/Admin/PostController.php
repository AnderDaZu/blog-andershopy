<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ResizeImage;
use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as ImageIntervention;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())
            ->latest('id')
            ->paginate(4);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|unique:posts,slug',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = Post::create( $request->all() );

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Artículo ha sido creado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function edit(Post $post)
    {
        // Esta validación se puede realizar desde query scopes globales en el módelo
        // $post = Post::where('slug', $post)
        //     ->where('user_id', auth()->id())
        //     ->firstOrFail();
     
            // Método allows() de Gate que verifica si el usuario actual tiene el permiso author para el objeto $post
        // if( !Gate::allows('author', $post) ) abort(403, 'No tienes permisos para acceder a este recurso');
        // lo de 👆 es igual a lo de 👇 -> solo que si se requiere más personalización es mejor el de 👆
        // $this->authorize('author', $post);

        $categories = Category::all();
        // $tags = Tag::all();
        // return $post->tags->pluck('id');
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        // dd( $request->image);
        $request->validate([
            'title' => 'required|string|max:255',
            // 'slug' => 'required|unique:posts,slug,' . $post->id,
            'category_id' => 'required|exists:categories,id',
            'excerpt' => $request['is_published'] ? 'required' : 'nullable',
            'body' => $request['is_published'] ? 'required' : 'nullable',
            'is_published' => 'required|boolean',
            'tags' => 'nullable|array',
            'image' => $request->image ? 'required|image|max:2048' : 'nullable',
        ]);

        $old_images = $post->images->pluck('path')->toArray();

        $re_extractImages = '/src=["\']([^ ^"^\']*)["\']/ims'; // expresión regualar para encontrar url de imagenes
        preg_match_all($re_extractImages, $request->body, $matches); // buscar y seleccionar imagenes en el campo body
        $images = $matches[1]; // definir el array de imaganes en contradas en body

        foreach ($images as $key => $image) {
            $images[$key] = 'images/' . pathinfo($image, PATHINFO_BASENAME); // capturar nombre de las imagenes y aducuarlas
        }

        $delete_images = array_diff($old_images, $images);

        foreach ($delete_images as $image) {
            Storage::delete($image);

            // $post->images()->where('path', $image)->delete();
            Image::where('path', $image)->delete();
        }

        $new_images = array_diff($images, $old_images);
        
        foreach ($new_images as $image) {
            // guardar imagenes
            $post->images()->create([
                'path' => $image
            ]);
        }

        $data = $request->all();

        $tags = [];

        foreach ($request->tags ?? [] as $name) {
            // firstOrCreate -> busca si hay algún registro en la db que coincida, de no existir lo crea
            $tag = Tag::firstOrCreate(['name' => $name]);
            $tags[] = $tag->id;
        }

        $post->tags()->sync($tags);

        if( $request->file('image') ) 
        {
            $dir = 'posts'; // folder to save images
            $ext = '.' . $request->file('image')->getClientOriginalExtension(); // get image extension
            $id = $post->id;

            if ( $post->image_path ) Storage::delete($post->image_path);

            $file_name = $post->slug . $ext;

            // Si se maneja disco s3 en la nube, 👇 esta validación debe cambiar o comentarse
            // if (Storage::exists($dir . '/' . $file_name)) $file_name = str_replace($ext, '-(' . $id . ')' . $ext, $file_name);

            // opción 1 para subir imagenes
            // put -> permite subir imagenes | puFileAs -> permite subir y definir el nombre de la imagen
            // punlic -> permite que los archivos subidos en s3 queden con permisos para ser publicos
            // disk -> permite definir de manera concreta con que disco debe trabajar
            $data['image_path'] = Storage::putFileAs($dir, $request->image, $file_name, 'public');

            // Redimencionar imagen con job
            ResizeImage::dispatch($data['image_path']);

            // opción 2 para subir imagenes
            // [ 'visibility' => 'public' ] -> permite que los archivos subidos en s3 queden con permisos para ser publicos
            // $data['image_path'] = $request->file('image')->storeAs($dir, $file_name, [
            //     'disk' => 's3', // se indica que se capta desde disco s3, porque en .env se establece public por defecto
            //     'visibility' => 'public'
            // ]);
        }

        $post->update( $data );

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Artículo ha sido actualizado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 1500
        ]);

        return redirect()->route('admin.posts.edit', $post);
    }

    public function destroy(Post $post)
    {
        $title = $post->title;

        $post->delete();

        session()->flash('swal', [
            'position' => "top-end",
            'icon' => "success",
            'title' => "¡Artículo \"$title\" ha sido eliminado!",
            'showConfirmButton' => false,
            'padding' => '1em',
            'timer' => 3000
        ]);

        return redirect()->route('admin.posts.index');
    }
}
