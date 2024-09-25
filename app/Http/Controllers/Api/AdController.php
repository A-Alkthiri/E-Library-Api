<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
     // Get all ads
     public function index()
     {
         $ads = Ad::all();
         return response()->json([
             'code' => 200,
             'data' => AdResource::collection($ads),
             'message' => 'Ads retrieved successfully',
         ]);
     }
 
     // Get single ad
     public function show($id)
     {
         $ad = Ad::findOrFail($id);
         return response()->json([
             'code' => 200,
             'data' => new AdResource($ad),
             'message' => 'Ad retrieved successfully',
         ]);
     }
 
     // Create new ad (if needed)
     public function store(Request $request)
     {
         $validatedData = $request->validate([
             'title' => 'required|max:255',
             'image_url' => 'required|url',
             'link' => 'nullable|url',
             'active' => 'required|boolean',
         ]);
 
         $ad = Ad::create($validatedData);
 
         return response()->json([
             'code' => 201,
             'data' => new AdResource($ad),
             'message' => 'Ad created successfully',
         ]);
     }

    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
