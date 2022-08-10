<?php

namespace Tests\Feature;

use App\Http\Resources\PostResource;
use App\Models\Comment;
use App\Models\Likes;
use App\Models\Post;
use App\Models\PostUser;
use App\Models\User;
use App\Observers\PostObserver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class PostControllerFTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();


        $this->user = User::factory()->create();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_all_posts_success()
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

        $response = $this->actingAs($this->user)->get('/api/post');

        $response->assertJson(fn (AssertableJson $json) =>
            $json->has('posts')
                ->has('posts.0', fn($json) =>
                    $json->hasAll(['id', 'description'])
                        ->has('user.0', fn ($json) =>
                            $json->hasAll('id', 'name', 'email')
                        )
                )
        );

        $response->assertStatus(Response::HTTP_ACCEPTED);
    }

    public function test_get_all_posts_dont_found()
    {   
        $response = $this->actingAs($this->user)->get('/api/post');

        $response->assertJson([
            'mensagem' => 'Nenhum post publicado.'
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_create_post_success()
    {
        $this->withoutExceptionHandling();

        $request = [
            'description' => "Isso e um teste"
        ];

        $response = $this->actingAs($this->user)->post('/api/post', $request);

        $post = Post::latest()->first();

        $post_user = [
            'user_id' => $this->user->id,
            'post_id' => $post->id
        ];

        $this->assertDatabaseHas('posts', $request);
        $this->assertDatabaseHas('post_user', $post_user);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_show_post_success()
    {
        $post = Post::withoutEvents(function() {
            return Post::factory()->create();
        });

        $response = $this->actingAs($this->user)->get('/api/post/' . $post->id);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->hasAll(['id', 'description'])
                ->has('user')
        );

    }

    public function test_show_post_not_found()
    {

        $response = $this->actingAs($this->user)->get('/api/post/' . rand(1,30));

        $response->assertJson([
            'mensagem' => 'Post nao encontrado.'
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_update_erro_post_not_found()
    {
        $request = [
            'description' => 'Isso e um teste'
        ];

        $response = $this->actingAs($this->user)->put('/api/post/' . rand(1,30), $request);

        $response->assertJson([
            'mensagem' => 'Post nao encontrado.'
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_update_erro_user_cant_edit()
    {
        $post = Post::withoutEvents(function() {
            return Post::factory()->create([
                'id' => 1
            ]);
        });

        $post2 = Post::withoutEvents(function() {
            return Post::factory()->create([
                'id' => 2
            ]);
        });

        PostUser::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $post->id
        ]);

        $request = [
            'description' => 'Isso e um teste'
        ];

        $response = $this->actingAs($this->user)->put('/api/post/' . $post2->id, $request);

        $response->assertJson([
            'mensagem' => 'O usuario autenticado nao tem autorizacao de editar esse post.'
        ]);

        $response->assertStatus(Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
    }

    public function test_update_post_success()
    {
        $post = Post::withoutEvents(function() {
            return Post::factory()->create([
                'id' => 1
            ]);
        });

        PostUser::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $post->id
        ]);

        $newPost = [
            'description' => 'nova descricao'
        ];

        $response = $this->actingAs($this->user)->put('/api/post/' . $post->id, $newPost);

        $response->assertJson([
            'id' => $post->id,
            'description' => $newPost['description'],
            'user' => [
                [
                    'id'    => $this->user->id,
                    'name'  => $this->user->name,
                    'email' => $this->user->email
                ]
            ]
        ]);

        $this->assertDatabaseHas('posts', $newPost);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_delete_post_not_found()
    {

        $response = $this->actingAs($this->user)->delete('/api/post/' . rand(1,30));

        $response->assertJson([
            'mensagem' => 'Post nao encontrado.'
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function test_delete_erro_user_cant_delete()
    {
        $post = Post::withoutEvents(function() {
            return Post::factory()->create([
                'id' => 1
            ]);
        });

        $post2 = Post::withoutEvents(function() {
            return Post::factory()->create([
                'id' => 2
            ]);
        });

        PostUser::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $post->id
        ]);


        $response = $this->actingAs($this->user)->delete('/api/post/' . $post2->id);

        $response->assertJson([
            'mensagem' => 'O usuario autenticado nao tem autorizacao de deletar esse post.'
        ]);

        $response->assertStatus(Response::HTTP_NON_AUTHORITATIVE_INFORMATION);
    }

    public function test_delete_post_success()
    {
        $post = Post::withoutEvents(function() {
            return Post::factory()->create([
                'id' => 1
            ]);
        });

        $postUser = PostUser::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $post->id
        ]);

        $response = $this->actingAs($this->user)->delete('/api/post/' . $post->id);

        $response->assertJson([
            'mensagem' => 'Deletado com sucesso'
        ]);

        $this->assertDatabaseMissing('posts', $post->toArray());
        $this->assertDatabaseMissing('post_user', $postUser->toArray());

        $response->assertStatus(Response::HTTP_OK);
    }
}
