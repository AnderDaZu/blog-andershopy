<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function image( Post $post ) {
        $image = Storage::disk('s3')->get($post->image_path);
        return response($image)
            ->header('Content-Type', 'image/jpeg');
    }
}
