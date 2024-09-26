<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

/**
 * @group Category Management
 *
 * APIs for managing categories in the e-library.
 */
class CategoryController extends BaseApiController
{
    /**
     * Get all categories.
     *
     * Retrieve a list of all categories.
     *
     * @response 200 {
     *  "code": 200,
     *  "data": [
     *    {
     *      "id": 1,
     *      "name": "Technology",
     *      "created_at": "2024-01-01T00:00:00.000000Z",
     *      "updated_at": "2024-01-01T00:00:00.000000Z"
     *    }
     *  ],
     *  "message": "Categories retrieved successfully"
     * }
     */
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'code' => 200,
            'data' => CategoryResource::collection($categories),
            'message' => 'Categories retrieved successfully',
        ]);
    }

    /**
     * Get a single category.
     *
     * Retrieve a specific category by its ID.
     *
     * @urlParam id integer required The ID of the category. Example: 1
     *
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "id": 1,
     *    "name": "Technology",
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Category retrieved successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Category not found"
     * }
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new CategoryResource($category),
            'message' => 'Category retrieved successfully',
        ]);
    }

    /**
     * Create a new category.
     *
     * @bodyParam name string required The name of the category. Example: Technology
     *
     * @response 201 {
     *  "code": 201,
     *  "data": {
     *    "id": 1,
     *    "name": "Technology",
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Category created successfully"
     * }
     * @response 422 {
     *  "code": 422,
     *  "message": "The given data was invalid."
     * }
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        $category = Category::create($validatedData);

        return response()->json([
            'code' => 201,
            'data' => new CategoryResource($category),
            'message' => 'Category created successfully',
        ]);
    }

    /**
     * Update an existing category.
     *
     * @urlParam id integer required The ID of the category. Example: 1
     * @bodyParam name string The name of the category. Example: Technology
     *
     * @response 200 {
     *  "code": 200,
     *  "data": {
     *    "id": 1,
     *    "name": "Updated Technology",
     *    "created_at": "2024-01-01T00:00:00.000000Z",
     *    "updated_at": "2024-01-01T00:00:00.000000Z"
     *  },
     *  "message": "Category updated successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Category not found"
     * }
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->sendError('Category not found', 404);
        }

        $category->update($request->all());

        return $this->sendResponse($category, 'Category updated successfully');
    }

    /**
     * Delete a category.
     *
     * @urlParam id integer required The ID of the category. Example: 1
     *
     * @response 200 {
     *  "code": 200,
     *  "message": "Category deleted successfully"
     * }
     * @response 404 {
     *  "code": 404,
     *  "message": "Category not found"
     * }
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->sendError('Category not found', 404);
        }

        $category->delete();

        return $this->sendResponse(null, 'Category deleted successfully');
    }
}
