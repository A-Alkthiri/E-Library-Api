<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AdResource;
use App\Models\Ad;
use Illuminate\Http\Request;

/**
 * @group Ad Management
 *
 * APIs for managing ads in the e-library.
 */
class AdController extends BaseApiController
{
    /**
     * Get all ads.
     *
     * Retrieve a list of all ads.
     *
     * @response 200 {
     *  "code": 200,
     *  "data": [
     *    {
     *      "id": 1,
     *      "title": "Ad Title",
     *      "image_url": "https://example.com/image.jpg",
     *      "content": " "
     *    }
     *  ],
     *  "message": "Ads retrieved successfully"
     * }
     */
    public function index()
    {
        $ads = Ad::all();
        return response()->json([
            'code' => 200,
            'data' => AdResource::collection($ads),
            'message' => 'Ads retrieved successfully',
        ]);
    }

    /**
     * Get a single ad.
     *
     * Retrieve a specific ad by its ID.
     *
     * @urlParam id integer required The ID of the ad. Example: 1
     *
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "id": 1,
     *    "title": "Ad Title",
     *    "image_url": "https://example.com/image.jpg",
     *    "content": " "
     *  },
     *  "message": "Ad retrieved successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Ad not found"
     * }
     */
    public function show($id)
    {
        $ad = Ad::findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new AdResource($ad),
            'message' => 'Ad retrieved successfully',
        ]);
    }

    /**
     * Create a new ad.
     *
     * @bodyParam title string required The title of the ad. Example: "Summer Sale"
     * @bodyParam image_url string required The URL of the ad image. Example: "https://example.com/image.jpg"
     * @bodyParam content string optinal required The URL of the ad image. Example: "https://example.com/image.jpg"
     *
     *
     * @response 201 {
     *  "code": 201,
     *  "data": {
     *    "id": 1,
     *    "title": "Summer Sale",
     *    "image_url": "https://example.com/image.jpg",
     *    "content": " "
     *  },
     *  "message": "Ad created successfully"
     * }
     * @response 422 {
     *  "code": 422,
     *  "message": "The given data was invalid."
     * }
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'image_url' => 'required',
            'content' => 'nullable',
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ad = Ad::find($id);
        if (!$ad) {
            return $this->sendError('Ad not found', 404);
        }

        $ad->delete();

        return $this->sendResponse(null, 'Ad deleted successfully');
    }
}
