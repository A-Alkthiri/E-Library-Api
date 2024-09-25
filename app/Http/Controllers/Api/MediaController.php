<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller
{
   // Get all media
   public function index()
   {
       $media = Media::all();
       return response()->json([
           'code' => 200,
           'data' => MediaResource::collection($media),
           'message' => 'Media retrieved successfully',
       ]);
   }

   // Get single media
   public function show($id)
   {
       $media = Media::findOrFail($id);
       return response()->json([
           'code' => 200,
           'data' => new MediaResource($media),
           'message' => 'Media retrieved successfully',
       ]);
   }

   // Create new media (if needed)
   public function store(Request $request)
   {
       $validatedData = $request->validate([
           'content_id' => 'required|exists:contents,id',
           'url' => 'required|url',
           'type' => 'required|string',
       ]);

       $media = Media::create($validatedData);

       return response()->json([
           'code' => 201,
           'data' => new MediaResource($media),
           'message' => 'Media created successfully',
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
