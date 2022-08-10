<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\PostUser;

class PostRepository 
{

	public function __construct(private Post $model){}

	public function findAll()
	{
		return $this->model->all();
	}    

    public function store(array $request)
    {
        return Post::create([
            'description' => $request['description'],
            'foto'        => isset($request['foto']) ?? null
        ]);
    }

    public function update(Post $post, array $request)
    {
        $post->update([
            'description' => $request['description'],
            'foto'        => isset($request['foto']) ?? null
        ]);

        return $post;
    }

    public function find(int $id)
    {
        return Post::find($id);
    }

    public function destroy($id) 
    {
        return Post::destroy($id);
    }
}