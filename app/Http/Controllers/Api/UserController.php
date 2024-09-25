<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
   // Get all users
   public function index()
   {
       $users = User::all();
       return response()->json([
           'code' => 200,
           'data' => UserResource::collection($users),
           'message' => 'Users retrieved successfully',
       ]);
   }

   // Get single user
   public function show($id)
   {
       $user = User::findOrFail($id);
       return response()->json([
           'code' => 200,
           'data' => new UserResource($user),
           'message' => 'User retrieved successfully',
       ]);
   }

   // Create a new user (if needed)
   public function store(Request $request)
   {
       $validatedData = $request->validate([
           'name' => 'required',
           'email' => 'required|email|unique:users',
           'password' => 'required|min:6',
       ]);

       $user = User::create($validatedData);

       return response()->json([
           'code' => 201,
           'data' => new UserResource($user),
           'message' => 'User created successfully',
       ]);
   }

    

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
