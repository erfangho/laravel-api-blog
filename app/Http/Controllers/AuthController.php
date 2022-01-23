<?php

namespace App\Http\Controllers;

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
    public function signUp(Request $request)
    {
        return User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);
    }



    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'    => 'required|email',
                'password' => 'required|string|min:6',
            ]
        );
        if ($validator->fails()) {
            return response()->json($validator->errors(), HttpFoundationResponse::HTTP_BAD_REQUEST);
        }

        if (!$token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], HttpFoundationResponse::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }



    public function logout()
    {
        $this->guard()->logout();

        return response()->json(['message' => 'User logged out successfully'], HttpFoundationResponse::HTTP_OK);

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
            ]
        );
    }

}
