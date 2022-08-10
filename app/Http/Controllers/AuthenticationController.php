<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{
    public function login(LoginRequest $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken("JWT");
            
            return response()->json($token, Response::HTTP_OK);
        }

        return response()->json(["mensagem" => "Email ou senha incorretos."], Response::HTTP_NOT_FOUND);
    }

    public function register(RegisterRequest $request)
    {
        User::create([
            'name'      => $request->name,
            'email'     =>$request->email,
            'password'  => Hash::make($request->password),
        ]);

        return response()->json(["mensagem" => "Registrado com sucesso."], Response::HTTP_CREATED);
    }

}
