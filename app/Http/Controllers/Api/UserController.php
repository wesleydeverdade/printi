<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage
     *
     * @param  UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $data = $request->all();
        $data["password"] = Hash::make($data["password"]);

        try {
            $user = User::create($data);
        }catch(\Exception $e){
            return response()->json(['message' => 'Service Unavailable.'], 503);
        }

        return response()->json($user,201);
    }
}
