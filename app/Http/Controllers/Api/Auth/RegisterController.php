<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create($request->only(['name', 'email', 'password']));
        $token = $user->createToken('laravel_api_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ], Response::HTTP_OK);
    }
}
