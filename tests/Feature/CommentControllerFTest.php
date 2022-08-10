<?php

namespace Tests\Feature;

use App\Jobs\PostComment;
use App\Jobs\PostLike;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class CommentControllerFTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_comment_created_success()
    {
        $user = User::factory()->create();

        $post = Post::withoutEvents(function (){
            return Post::factory()->create();
        });

        PostUser::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $comment = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'description' => 'Esse comentario e um teste'
        ];

        $response = $this->actingAs($user)->post('/api/comment', $comment);

        $response->assertJson([
            "mensagem" => "Comentario criado."
        ]);

        $this->assertDatabaseHas('comments', $comment);

        $response->assertStatus(200);
    }


    public function test_create_comment_job_dispatched()
    {
        $user = User::factory()->create();

        $post = Post::withoutEvents(function (){
            return Post::factory()->create();
        });

        PostUser::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $comment = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'description' => 'Esse comentario e um teste'
        ];

        Bus::fake();

        $response = $this->actingAs($user)->post('/api/comment', $comment);

        Bus::assertDispatched(PostComment::class);

        $response->assertStatus(200);
    }

    public function test_like_created_success()
    {
        $user = User::factory()->create();

        $post = Post::withoutEvents(function (){
            return Post::factory()->create();
        });

        PostUser::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $like = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'like_reaction' => 'Amei'
        ];

        $response = $this->actingAs($user)->post('/api/like', $like);

        $response->assertJson([
            "mensagem" => "Publicacao curtida."
        ]);

        $this->assertDatabaseHas('likes', $like);

        $response->assertStatus(200);
    }


    public function test_create_like_job_dispatched()
    {
        $user = User::factory()->create();

        $post = Post::withoutEvents(function (){
            return Post::factory()->create();
        });

        PostUser::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $like = [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'like_reaction' => 'Amei'
        ];

        Bus::fake();

        $response = $this->actingAs($user)->post('/api/like', $like);

        Bus::assertDispatched(PostLike::class);

        $response->assertStatus(200);
    }
}
