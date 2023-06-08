<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    // ...
    
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'password' => 'required',
            'confirmation_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        $payload = [
            'name' => $user->name,
            'role' => 'user',
            'iat' => now()->timestamp,
            'exp' => now()->timestamp + 7200,
        ];

        $token = JWT::encode($payload, env('JWT_SECRET_KEY'), 'HS256');

        return response()->json([
            'data' => [
                'msg' => 'User dengan Data berikut sudah terdaftar',
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'address' => $user->address,
                'role' => $user->role,
            ],
            'token' => 'Bearer ' . $token,
        ], 200);
    }

    public function loginUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        if (Auth::attempt($validator->validated())) {
            $payload = [
                'name' => Auth::user()->name,
                'role' => 'user',
                'iat' => now()->timestamp,
                'exp' => now()->timestamp + 7200,
            ];

            $token = JWT::encode($payload, env('JWT_SECRET_KEY'), 'HS256');

            return response()->json([
                'data' => [
                    'msg' => 'Berhasil login',
                    'role' => 'user',
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'token' => 'Bearer ' . $token,
            ], 200);
        }

        return response()->json('Email atau password salah', 422);
    }
}
