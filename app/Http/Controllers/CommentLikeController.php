<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\LikeRequest;
use App\Jobs\PostComment;
use App\Jobs\PostLike;
use App\Models\Comment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CommentLikeController extends Controller
{
    public function storeComment(CommentRequest $request)
    {
        PostComment::dispatch($request->all(), auth()->user()->id);

        return response()->json(["mensagem" => "Comentario criado."], Response::HTTP_OK);
    }

    public function storeLike(LikeRequest $request)
    {
        PostLike::dispatch($request->all(), auth()->user()->id);

        return response()->json(["mensagem" => "Publicacao curtida."], Response::HTTP_OK);
    }

}
