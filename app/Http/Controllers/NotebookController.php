<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotebookResource;
use App\Models\Note;
use App\Models\Notebook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Mockery\Matcher\Not;


class NotebookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $notebooks = Notebook::all();

        return response()->json([
           'data' => $notebooks
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
            'title' => 'required|string|max:125|unique:notebooks'
        ]);

        $notebook = Notebook::create([
            'title' => $validation['title']
        ]);

        return response()->json([
            'success' => true,
            'notebook' => $notebook
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Notebook $notebook
     * @return JsonResponse
     */
    public function show($id)
    {
        $notebook = Notebook::find($id);
        if(is_null($notebook)) {
            return response()->json([
                'success' => false,
               'message' => 'data not found'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $notebook
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {

        $request->validate([
           'title' =>  'required|string|max:125|unique:notebooks'
        ]);

        $notebook = Notebook::find($id);
        if (is_null($notebook)) {
            return response()->json([
                'success' => false,
                'message' => "id ". $id . " not found"
            ]);
        }
        $notebook->title = $request['title'];
        $notebook->save();

        return response()->json([
            'message' => 'updated successfully',
            'data' => $notebook
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $notebook = Notebook::find($id);
        if (is_null($notebook)) {
            return response()->json([
               'success' => false,
                'message' => "id ". $id . " not found"
            ]);
        }
        $notebook->delete();
        return response()->json([
           'success' => true,
           'message' => 'notebook deleted successfully'
        ]);
    }
}
