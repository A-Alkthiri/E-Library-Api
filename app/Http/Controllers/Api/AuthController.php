<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @group Authentication
 *
 * APIs for user authentication and profile management.
 */
class AuthController extends BaseApiController
{
    /**
     * Register a new user.
     *
     * @bodyParam name string required The name of the user. Example: John Doe
     * @bodyParam email string required The email of the user. Example: johndoe@example.com
     * @bodyParam password string required The password of the user. Must be at least 8 characters. Example: secretpassword
     *
     * @response 201 {
     *  "code": 201,
     *  "data": {
     *    "id": 1,
     *    "name": "John Doe",
     *    "email": "johndoe@example.com",
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "User registered successfully"
     * }
     * @response 422 {
     *  "code": 422,
     *  "message": "The given data was invalid."
     * }
     */
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

    /**
     * User login.
     *
     * @bodyParam email string required The email of the user. Example: johndoe@example.com
     * @bodyParam password string required The password of the user. Example: secretpassword
     *
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "token": "1|abcd1234token",
     *    "user": {
     *      "id": 1,
     *      "name": "John Doe",
     *      "email": "johndoe@example.com",
     *      "created_at": "2024-01-01T00:00:00.000000Z",
     *      "updated_at": "2024-01-01T00:00:00.000000Z"
     *    }
     *  },
     *  "message": "Login successful"
     * }
     * @response 401 {
     *  "code": 401,
     *  "message": "Invalid credentials"
     * }
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->sendError('Invalid credentials', 401);
        }

        $user = User::where('id', Auth::id())->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->sendResponse(['token' => $token, 'user' => $user], 'Login successful');
    }

    /**
     * User logout.
     *
     * @authenticated
     * 
     * @response 200 {
     *  "code": 200,
     *  "message": "Logout successful"
     * }
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return $this->sendResponse(null, 'Logout successful');
    }

    /**
     * Get authenticated user details.
     *
     * @authenticated
     * 
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "id": 1,
     *    "name": "John Doe",
     *    "email": "johndoe@example.com",
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Authenticated user data"
     * }
     */
    public function profile(Request $request)
    {
        return $this->sendResponse($request->user(), 'Authenticated user data');
    }
}
