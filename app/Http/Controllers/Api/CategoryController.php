<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends BaseApiController
{
    // Get all categories
    public function index()
    {
        $categories = Category::all();
        return response()->json([
            'code' => 200,
            'data' => CategoryResource::collection($categories),
            'message' => 'Categories retrieved successfully',
        ]);
    }

    // Get single category
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new CategoryResource($category),
            'message' => 'Category retrieved successfully',
        ]);
    }

    // Create a new category (if needed)
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
    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->sendError('Category not found', 404);
        }

        $category->update($request->all());

        return $this->sendResponse($category, 'Category updated successfully');
    }

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
