<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseApiController
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return $this->sendResponse($user, 'User registered successfully', 201);
    }

    // User Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->sendError('Invalid credentials', 401);
        }

        $user = User::where('id',Auth::id())->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse(['token' => $token, 'user' => $user], 'Login successful');
    }

    // User Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse(null, 'Logout successful');
    }

    // Get Authenticated User Details
    public function profile(Request $request)
    {
        return $this->sendResponse($request->user(), 'Authenticated user data');
    }
}
