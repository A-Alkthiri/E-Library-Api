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
class AdController extends Controller
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
     *      "link": "https://example.com",
     *      "active": true,
     *      "created_at": "2024-01-01T00:00:00.000000Z",
     *      "updated_at": "2024-01-01T00:00:00.000000Z"
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
     *    "link": "https://example.com",
     *    "active": true,
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
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
     * @bodyParam link string optional The URL to which the ad redirects. Example: "https://example.com"
     * @bodyParam active boolean required Whether the ad is active. Example: true
     *
     * @response 201 {
     *  "code": 201,
     *  "data": {
     *    "id": 1,
     *    "title": "Summer Sale",
     *    "image_url": "https://example.com/image.jpg",
     *    "link": "https://example.com",
     *    "active": true,
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
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
