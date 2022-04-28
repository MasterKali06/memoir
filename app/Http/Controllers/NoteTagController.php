<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\NoteTag;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NoteTagController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
           'note_id' => 'Integer|required',
            'tag_id' => 'Integer|required'
        ]);

        $note = Note::find($request['note_id']);
        $tag = Tag::find($request['tag_id']);

        if (is_null($note)) {
            return response()->json([
               'success' => false,
               'message' => 'note id ' . $request['note_id'] . ' not exist!'
            ]);
        }
        if (is_null($tag)) {
            return response()->json([
                'success' => false,
                'message' => 'tag id ' . $request['tag_id'] . ' not exist!'
            ]);
        }

        $note_tag = NoteTag::create([
           'note_id' => $request['note_id'],
            'tag_id' => $request['tag_id']
        ]);

        return response()->json([
           'success' => true,
           'message' => 'note tag created successfully',
           'data' => $note_tag
        ]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request) {

        $request->validate([
            'note_id' => 'Integer|required',
            'tag_id' => 'Integer|required'
        ]);

        $note_tag = NoteTag::where('note_id', $request['note_id'])->where('tag_id', $request['tag_id'])->first();
        if (is_null($note_tag)) {
            return response()->json([
               'success' => false,
               'message' => 'data not found'
            ]);
        }

        $note_tag->delete();

        return response()->json([
           'success' => true,
           'message' => 'deleted successfully'
        ]);

    }
}
