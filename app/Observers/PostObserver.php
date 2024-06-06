<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    // para cuando ya se haya creado un post
    public function created( $post ) 
    {

    }


    // para cuando se esta creando un post
    public function creating( Post $post )
    {
        $post->user_id = auth()->id();
    }


    // para cuando ya se haya actualizado un post
    public function updated( $post ) 
    {
        //
    }

    // para cuando se esta actualizando un post
    public function updating( Post $post )
    {
        //
    }
}
