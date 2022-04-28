<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Notebook;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $notes = Note::with('tags')->get();
        return response()->json([
            "data" => $notes
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
        $request->validate([
            'title' => 'required|string|max:125',
            'notebook_id' => 'integer|required'
        ]);

        $notebook = Notebook::find($request['notebook_id']);
        if (is_null($notebook)){
            return response()->json([
               'success' => false,
               'message' => 'notebook id '. $request['notebook_id'] . ' not exist.'
            ]);
        }

        $note = Note::create([
           'title' => $request['title'],
           'body' => $request['body'],
           'notebook_id' => $request['notebook_id']
        ]);

        return response()->json([
           'message' => 'note created successfully',
           'data' => $note,
           'success' => true
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
        $note = Note::find($id);

        if (is_null($note)) {
            return response()->json([
               'message' => 'id '. $id . ' not found!',
               'success' => false
            ]);
        }

        return response()->json([
            'message' => '',
            'success' => true,
            'data' => $note
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
        $note = Note::find($id);

        if (is_null($note)) {
            return response()->json([
                'message' => 'id ' . $id . ' not found!',
                'success' => false
            ]);
        }

        if ($request->has('title')) $note['title'] = $request['title'];
        if ($request->has('body')) $note['body'] = $request['body'];
        $note->save();

        return response()->json([
            'message' => 'id ' . $id . ' updated successfully',
            'success' => true,
            'data' => $note
        ]);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $note = Note::find($id);
        if (is_null($note)) {
            return response()->json([
                'message' => 'id ' . $id . ' not found!',
                'success' => false
            ]);
        }

        $note->delete();
        return response()->json([
            'success' => true,
            'message' => 'notebook deleted successfully'
        ]);
    }
}
