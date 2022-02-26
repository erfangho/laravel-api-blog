<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signUp']]);
    }

    public function signUp(SignUpRequest $request)
    {
        return User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        if (!$token = $this->guard()->attempt($validated)) {
            return response()->json(['error' => __("auth.failed")], HttpFoundationResponse::HTTP_UNAUTHORIZED);
        }
        $auth = $this->guard();
        $auth->token = $token;
        return response()->json(new AuthResource($auth), HttpFoundationResponse::HTTP_OK);
    }

    public function logout()
    {
        $this->guard()->logout();
        return response()->json(['message' => __("messages.done")], HttpFoundationResponse::HTTP_OK);
    }

    public function me()
    {
        return response()->json($this->guard()->user());
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }
}
