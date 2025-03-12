<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            $user = $request->user();
    
            $token = $user->createToken('auth_token')->plainTextToken;
    
            return response()->json([
                'token' => $token,
                'token_type' => 'Bearer',
            ]);
        }
    
        return response()->json([
            'message' => 'Usuario invalido'
        ], 401);
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|string|unique:users',
            'name' => 'required|string',
            'password' => 'required|string|min:6',
        ]);
    
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
        ]);
    
        return response()->json([
            'message' => 'Usuario criado com sucesso',
            'user' => $user,
        ], 201);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    
        return response()->json([
            'message' => 'Token deletado com sucesso'
        ]);
    }
}
