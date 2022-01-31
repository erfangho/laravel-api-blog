<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SignUpRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'signUp']]);
    }
    //
    public function signUp(SignUpRequest $request)
    {
        $validated = $request->validated();
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

        return $this->respondWithToken($token);
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


    protected function respondWithToken($token)
    {
        return response()->json(
            [
                'token'          => $token,
                'token_type'     => 'bearer',
                'token_validity' => ($this->guard()->factory()->getTTL() * 60),
            ],
        HttpFoundationResponse::HTTP_OK);
    }

}
