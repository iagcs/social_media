<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository 
{

	public function __construct(private User $model){}

	public function findAll()
	{
		return $this->model->all();
	}
    
    public function findPostFromUserAuthenticated(int $id)
    {
        $user = auth()->user();

        return User::find($user->id)->posts()->wherePivot('post_id', $id)->first();
    }
}