<?php

namespace App\Observers;

use App\Models\Post;
use App\Models\PostUser;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        PostUser::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id
        ]);
    }

}
