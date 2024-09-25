<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ContentResource;
use App\Models\Content;
use Illuminate\Http\Request;

class ContentController extends BaseApiController
{
    // Get all content
    public function index()
    {
        $contents = Content::with(['category', 'contentType', 'user', 'media'])->get();
        return response()->json([
            'code' => 200,
            'data' => ContentResource::collection($contents),
            'message' => 'Content retrieved successfully',
        ]);
    }

    // Get single content
    public function show($id)
    {
        $content = Content::with(['category', 'contentType', 'user', 'media'])->findOrFail($id);
        return response()->json([
            'code' => 200,
            'data' => new ContentResource($content),
            'message' => 'Content retrieved successfully',
        ]);
    }

    // Create a new content
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
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
    // Update an existing content
    public function update(Request $request, $id)
    {
        $content = Content::find($id);

        if (!$content) {
            return $this->sendError('Content not found', 404);
        }

        $content->update($request->all());

        return $this->sendResponse($content, 'Content updated successfully');
    }

    // Delete a content
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
