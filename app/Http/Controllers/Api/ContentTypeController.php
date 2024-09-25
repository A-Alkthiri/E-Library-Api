<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentTypeResource;
use App\Models\ContentType;
use Illuminate\Http\Request;

class ContentTypeController extends Controller
{
    // Get all content types
    public function index()
    {
        $contentTypes = ContentType::all();
        return response()->json([
            'code' => 200,
            'data' => ContentTypeResource::collection($contentTypes),
            'message' => 'Content types retrieved successfully',
        ]);
    }

    // Get single content type
    public function show($id)
    {
        $contentType = ContentType::findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new ContentTypeResource($contentType),
            'message' => 'Content type retrieved successfully',
        ]);
    }

    // Create a new content type (if needed)
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
    // public function destroy(string $id)
    // {
    //     //
    // }
}
