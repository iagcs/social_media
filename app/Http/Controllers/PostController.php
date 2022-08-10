<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePost;
use App\Http\Resources\PostResource;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    function __construct(
        private PostRepository $postRepository,
        private UserRepository $userRepository
    ){}

    public function index()
    {
        $posts = $this->postRepository->findAll();

        if(empty($posts->toArray())){
            return response()->json(["mensagem" => "Nenhum post publicado."], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['posts' => PostResource::collection($posts)], Response::HTTP_ACCEPTED);
    }

    public function store(CreatePost $request)
    {
        $post = $this->postRepository->store($request->all());

        return response()->json(new PostResource($post), Response::HTTP_CREATED);
    }

    public function show(int $id) 
    {
        $post = $this->postRepository->find($id);

        if(!$post){
            return response()->json(["mensagem" => "Post nao encontrado."], Response::HTTP_NOT_FOUND);
        }

        return response()->json(new PostResource($post), Response::HTTP_OK);
    }

    public function update($id, CreatePost $request)
    {
        $post = $this->postRepository->find($id);

        if(!$post){
            return response()->json(["mensagem" => "Post nao encontrado."], Response::HTTP_NOT_FOUND);
        }

        $postForEdit = $this->userRepository->findPostFromUserAuthenticated($id);

        if(!$postForEdit){
            return response()
                    ->json(["mensagem" => "O usuario autenticado nao tem autorizacao de editar esse post."],
                            Response::HTTP_NON_AUTHORITATIVE_INFORMATION
                        );
        }

        $postForEdit = $this->postRepository->update($postForEdit, $request->all());

        return response()->json(new PostResource($postForEdit), Response::HTTP_OK);
    }

    public function destroy($id) 
    {
        $post = $this->postRepository->find($id);

        if(!$post){
            return response()->json(["mensagem" => "Post nao encontrado."], Response::HTTP_NOT_FOUND);
        }

        if(!$this->userRepository->findPostFromUserAuthenticated($id)){
            return response()
                    ->json(["mensagem" => "O usuario autenticado nao tem autorizacao de deletar esse post."],
                            Response::HTTP_NON_AUTHORITATIVE_INFORMATION
                        );
        }

        $this->postRepository->destroy($id);

        return response()->json(["mensagem" => "Deletado com sucesso"], Response::HTTP_OK);
    }
}
