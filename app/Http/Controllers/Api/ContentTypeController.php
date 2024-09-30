<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentTypeResource;
use App\Models\ContentType;
use Illuminate\Http\Request;

/**
 * @group Content Type Management
 *
 * APIs for managing content types in the e-library.
 */
class ContentTypeController extends BaseApiController
{
    /**
     * Get all content types.
     *
     * Retrieve a list of all content types.
     *
     * @response 200 {
     *  "code": 200,
     *  "data": [
     *    {
     *      "id": 1,
     *      "name": "Article",
     *      "created_at": "2024-01-01T00:00:00.000000Z",
     *      "updated_at": "2024-01-01T00:00:00.000000Z"
     *    }
     *  ],
     *  "message": "Content types retrieved successfully"
     * }
     */
    public function index()
    {
        $contentTypes = ContentType::all();
        return response()->json([
            'code' => 200,
            'data' => ContentTypeResource::collection($contentTypes),
            'message' => 'Content types retrieved successfully',
        ]);
    }

    /**
     * Get a single content type.
     *
     * Retrieve a specific content type by its ID.
     *
     * @urlParam id integer required The ID of the content type. Example: 1
     *
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "id": 1,
     *    "name": "Article",
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Content type retrieved successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Content type not found"
     * }
     */
    public function show($id)
    {
        $contentType = ContentType::findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new ContentTypeResource($contentType),
            'message' => 'Content type retrieved successfully',
        ]);
    }

    /**
     * Create a new content type.
     *
     * @bodyParam name string required The name of the content type. Example: Article
     *
     * @response 201 {
     *  "code": 201,
     *  "data": {
     *    "id": 1,
     *    "name": "Article",
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Content type created successfully"
     * }
     * @response 422 {
     *  "code": 422,
     *  "message": "The given data was invalid."
     * }
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:content_types|max:255',
        ]);

        $contentType = ContentType::create($validatedData);

        return response()->json([
            'code' => 201,
            'data' => new ContentTypeResource($contentType),
            'message' => 'Content type created successfully',
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
    public function destroy(string $id)
    {
        $contentType = ContentType::find($id);
        if (!$contentType) {
            return $this->sendError('ContentType not found', 404);
        }

        $contentType->delete();

        return $this->sendResponse(null, 'ContentType deleted successfully');
    }
}
