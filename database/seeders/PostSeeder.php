<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Likes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::withoutEvents(function (){
            User::factory()->has(
                Post::factory()->has(
                    Comment::factory()->count(2)
                )->has(
                    Likes::factory()->count(1)
                )->count(3)
            )->count(10)->create();
        });
    }
}
