<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Authentication to be allowed to consume resources
     *
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials) === false) {
            return response()->json(['message' => 'Unauthorized.'], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();
        $token = $user->createToken('token');

        return response()->json($token->plainTextToken);
    }
}
