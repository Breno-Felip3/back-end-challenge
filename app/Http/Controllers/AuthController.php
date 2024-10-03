<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function signup(SignupRequest $request) {

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);

        $user->save();

        // Gera o token JWT
        $token = JWTAuth::fromUser($user);

        return response()->json([
            "id" => $user->id,
            "name" => $user->email,
            "token" => $token
        ], 200);
    }

    public function signin(SigninRequest $request)
    {
        $credentials = $request->validated();

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 400);
        }

        $user = auth('api')->user();
        
        return response()->json([
            "id" => $user->id,
            "name" => $user->name,
            "token" => $token
        ], 200);
    }

    public function me()
    {
        return response()->json(auth('api')->user());
    }

    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}