<?php

namespace App\Http\Controllers;

use App\Http\Requests\HighlightedLessonPostRequest;
use App\Models\HighlightedLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HighlightedLessonController extends Controller
{
    public function show($id)
    {
        $hl = HighlightedLesson::find($id);
        if (!$hl) {
            return response()->json(['message' => 'Highlighted lesson not found'], 404);
        }

        return $hl;
    }

    public function store(HighlightedLessonPostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        return HighlightedLesson::create($data);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $hl = HighlightedLesson::find($id);

        if (!$hl) {
            return response()->json(['message' => 'Highlighted lesson not found'], 404);
        }

        $hl->update($data);
        return response()->json($hl, 200);
    }

    public function destroy($id)
    {
        $hl = HighlightedLesson::find($id);

        if (!$hl) {
            return response()->json(['message' => 'Highlighted lesson not found'], 404);
        }

        $hl->delete();
        return response()->json(['message' => 'Highlighted lesson deleted successfully'], 200);
    }
}
