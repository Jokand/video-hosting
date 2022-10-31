<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Route;

class AuthController extends Controller
{
    /**
     * User registration
     * @param RegistrationRequest $request
     * @return JsonResponse
     */
    public function registration(RegistrationRequest $request): JsonResponse
    {
        $password = Hash::make($request->password);
        User::query()->create(['password' => $password] + $request->validated());
        return response()->json(['success' => true,], 201);
    }

    /**
     * User login
     * @param RegistrationRequest $request
     * @return array|JsonResponse
     */
    public function auth(AuthRequest $request)
    {
        if(Auth::attempt($request->validated())){
            return [
                'success' => true,
                'token' => $request->user()->createToken('api')->plainTextToken,
            ];
        }
        return response()->json([
            'errors' => [
                'email' => ['Incorrect login'],
            ],
        ], 422);
    }

    /**
     * User logout
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
     $request->user()->currentAccessToken()->delete();
     return response()->noContent();
    }
}
