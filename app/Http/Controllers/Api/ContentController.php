<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Http\Request;

/**
 * @group Content Management
 *
 * APIs for managing content in the e-library.
 */
class ContentController extends BaseApiController
{
    /**
     * Get all content.
     *
     * Retrieve a list of all content items with their related data.
     *
     * @response 200 {
     *  "code": 200,
     *  "data": [
     *    {
     *      "id": 1,
     *      "title": "Introduction to Programming",
     *      "description": "A basic introduction to programming concepts.",
     *      "category": {
     *        "id": 1,
     *        "name": "Technology"
     *      },
     *      "content_type": {
     *        "id": 1,
     *        "name": "Article"
     *      },
     *      "user": {
     *        "id": 1,
     *        "name": "John Doe"
     *      },
     *      "media": [
     *        {
     *          "id": 1,
     *          "url": "https://example.com/media/image.jpg"
     *        }
     *      ],
     *      "created_at": "2024-01-01T00:00:00.000000Z",
     *      "updated_at": "2024-01-01T00:00:00.000000Z"
     *    }
     *  ],
     *  "message": "Content retrieved successfully"
     * }
     */
    public function index()
    {
        $contents = Content::with(['category', 'contentType', 'user', 'media'])->get();
        return response()->json([
            'code' => 200,
            'data' => ContentResource::collection($contents),
            'message' => 'Content retrieved successfully',
        ]);
    }

    /**
     * Get single content.
     *
     * Retrieve a specific content item by its ID.
     *
     * @urlParam id integer required The ID of the content. Example: 1
     *
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "id": 1,
     *    "title": "Introduction to Programming",
     *    "description": "A basic introduction to programming concepts.",
     *    "category": {
     *      "id": 1,
     *      "name": "Technology"
     *    },
     *    "content_type": {
     *      "id": 1,
     *      "name": "Article"
     *    },
     *    "user": {
     *      "id": 1,
     *      "name": "John Doe"
     *    },
     *    "media": [
     *      {
     *        "id": 1,
     *        "url": "https://example.com/media/image.jpg"
     *      }
     *    ],
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Content retrieved successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Content not found"
     * }
     */
    public function show($id)
    {
        $content = Content::with(['category', 'contentType', 'user', 'media'])->findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new ContentResource($content),
            'message' => 'Content retrieved successfully',
        ]);
    }

    /**
     * Create a new content.
     *
     * @bodyParam title string required The title of the content. Example: Introduction to Programming
     * @bodyParam description string required A detailed description of the content. Example: A basic introduction to programming concepts.
     * @bodyParam category_id integer required The ID of the category. Example: 1
     * @bodyParam image_path string required The path to the content's image. Example: /images/programming.jpg
     * @bodyParam type_id integer required The ID of the content type. Example: 1
     * @bodyParam user_id integer required The ID of the user who created the content. Example: 1
     *
     * @response 201 {
     *  "code": 201,
     *  "data": {
     *    "id": 1,
     *    "title": "Introduction to Programming",
     *    "description": "A basic introduction to programming concepts.",
     *    "category": {
     *      "id": 1,
     *      "name": "Technology"
     *    },
     *    "content_type": {
     *      "id": 1,
     *      "name": "Article"
     *    },
     *    "user": {
     *      "id": 1,
     *      "name": "John Doe"
     *    },
     *    "media": [
     *      {
     *        "id": 1,
     *        "url": "https://example.com/media/image.jpg"
     *      }
     *    ],
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Content created successfully"
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
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image_path' => 'required|string',
            'type_id' => 'required|exists:content_types,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $content = Content::create($validatedData);

        return response()->json([
            'code' => 201,
            'data' => new ContentResource($content),
            'message' => 'Content created successfully',
        ]);
    }

    /**
     * Update an existing content.
     *
     * @urlParam id integer required The ID of the content. Example: 1
     * @bodyParam title string The title of the content. Example: Introduction to Programming
     * @bodyParam description string A detailed description of the content. Example: A basic introduction to programming concepts.
     * @bodyParam category_id integer The ID of the category. Example: 1
     * @bodyParam image_path string The path to the content's image. Example: /images/programming.jpg
     * @bodyParam type_id integer The ID of the content type. Example: 1
     * @bodyParam user_id integer The ID of the user who created the content. Example: 1
     *
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "id": 1,
     *    "title": "Introduction to Programming",
     *    "description": "A basic introduction to programming concepts.",
     *    "category": {
     *      "id": 1,
     *      "name": "Technology"
     *    },
     *    "content_type": {
     *      "id": 1,
     *      "name": "Article"
     *    },
     *    "user": {
     *      "id": 1,
     *      "name": "John Doe"
     *    },
     *    "media": [
     *      {
     *        "id": 1,
     *        "url": "https://example.com/media/image.jpg"
     *      }
     *    ],
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Content updated successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Content not found"
     * }
     */
    public function update(Request $request, $id)
    {
        $content = Content::find($id);

        if (!$content) {
            return $this->sendError('Content not found', 404);
        }

        $content->update($request->all());

        return $this->sendResponse($content, 'Content updated successfully');
    }

    /**
     * Delete a content.
     *
     * @urlParam id integer required The ID of the content. Example: 1
     *
     * @response 200 {
     *  "code": 200,
     *  "message": "Content deleted successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Content not found"
     * }
     */
    public function destroy($id)
    {
        $content = Content::find($id);

        if (!$content) {
            return $this->sendError('Content not found', 404);
        }

        $content->delete();

        return $this->sendResponse(null, 'Content deleted successfully');
    }
}
