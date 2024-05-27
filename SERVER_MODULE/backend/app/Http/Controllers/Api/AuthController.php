<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required|min:5"
        ]);

        if ($validator->fails()) {
            return response()->json([
                "message" => "Invalid field",
                "status" => 422,
                "errors" => $validator->messages()
            ]);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "Email or password incorrect",
                "status" => 401
            ]);
        }

        $user = User::where(['email' => $request->email])->first();

        $token = $user->createToken('auth:sanctum')->plainTextToken;

        if (!$user) {

            return response()->json([
                "message" => "Email or password incorrect",
                "status" => 401
            ]);
        }

        return response()->json([
            "message" => "Login success",
            "user" => $user,
            "accessToken" => $token,
            "status" => 200
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            "message" => "Logout success",
            "status" => 401
        ]);
    }
}
