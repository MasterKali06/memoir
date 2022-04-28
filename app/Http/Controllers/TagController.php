<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $tags = Tag::with('notes')->get();

        return response()->json([
            'data' => $tags
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validation = $request->validate([
            'name' => 'required|string|max:125|unique:tags'
        ]);

        $tag = Tag::create([
            'name' => $validation['name']
        ]);

        return response()->json([
            'success' => true,
            'tag' => $tag
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $tag = Tag::find($id);
        if(is_null($tag)) {
            return response()->json([
                'success' => false,
                'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $tag
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' =>  'required|string|max:125|unique:tags'
        ]);

        $tag = Tag::find($id);
        if (is_null($tag)) {
            return response()->json([
                'success' => false,
                'message' => "id ". $id . " not found"
            ]);
        }
        $tag->name = $request['name'];
        $tag->save();

        return response()->json([
            'message' => 'updated successfully',
            'data' => $tag
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $tag = Tag::find($id);
        if (is_null($tag)) {
            return response()->json([
                'success' => false,
                'message' => "id ". $id . " not found"
            ]);
        }
        $tag->delete();
        return response()->json([
            'success' => true,
            'message' => 'tag deleted successfully'
        ]);
    }
}
