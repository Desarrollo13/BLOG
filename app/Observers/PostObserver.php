<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function creating(Post $post)
    {
       if(! \App::runningInConsole()){
        $post->user_id= auth()->user()->id;
       }
    }

   

    /**
     * se va activar antes de que se elemine el post
     */
    public function deleting(Post $post)
    {
        if($post->image){
            Storage::delete($post->image->url);

        }
    }

    
}
