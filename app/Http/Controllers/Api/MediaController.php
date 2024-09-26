<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use Illuminate\Http\Request;

/**
 * @group Media Management
 *
 * APIs for managing media resources in the e-library.
 */
class MediaController extends Controller
{
   /**
    * Get all media.
    *
    * Retrieve a list of all media resources.
    *
    * @response 200 {
    *  "code": 200,
    *  "data": [
    *    {
    *      "id": 1,
    *      "content_id": 1,
    *      "url": "https://example.com/media/image.jpg",
    *      "type": "image",
    *      "created_at": "2024-01-01T00:00:00.000000Z",
    *      "updated_at": "2024-01-01T00:00:00.000000Z"
    *    }
    *  ],
    *  "message": "Media retrieved successfully"
    * }
    */
   public function index()
   {
       $media = Media::all();
       return response()->json([
           'code' => 200,
           'data' => MediaResource::collection($media),
           'message' => 'Media retrieved successfully',
       ]);
   }

   /**
    * Get a single media resource.
    *
    * Retrieve a specific media resource by its ID.
    *
    * @urlParam id integer required The ID of the media resource. Example: 1
    *
    * @response 200 {
    *  "code": 200,
    *  "data": {
    *    "id": 1,
    *    "content_id": 1,
    *    "url": "https://example.com/media/image.jpg",
    *    "type": "image",
    *    "created_at": "2024-01-01T00:00:00.000000Z",
    *    "updated_at": "2024-01-01T00:00:00.000000Z"
    *  },
    *  "message": "Media retrieved successfully"
    * }
    * @response 404 {
    *  "code": 404,
    *  "message": "Media not found"
    * }
    */
   public function show($id)
   {
       $media = Media::findOrFail($id);
       return response()->json([
           'code' => 200,
           'data' => new MediaResource($media),
           'message' => 'Media retrieved successfully',
       ]);
   }

   /**
    * Create a new media resource.
    *
    * @bodyParam content_id integer required The ID of the associated content. Example: 1
    * @bodyParam url string required The URL of the media resource. Example: https://example.com/media/image.jpg
    * @bodyParam type string required The type of the media resource. Example: image
    *
    * @response 201 {
    *  "code": 201,
    *  "data": {
    *    "id": 1,
    *    "content_id": 1,
    *    "url": "https://example.com/media/image.jpg",
    *    "type": "image",
    *    "created_at": "2024-01-01T00:00:00.000000Z",
    *    "updated_at": "2024-01-01T00:00:00.000000Z"
    *  },
    *  "message": "Media created successfully"
    * }
    * @response 422 {
    *  "code": 422,
    *  "message": "The given data was invalid."
    * }
    */
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
