<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventPatchRequest;
use App\Http\Requests\EventPostRequest;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function show($id)
    {
        $event = Event::find($id);
        $current_user = Auth::user();

        if ($event && $event->user_id !== $current_user->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        return $event;
    }

    public function store(EventPostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        return Event::create($data);
    }

    public function update(EventPatchRequest $request, $id)
    {
        $data = $request->validated();
        $current_user = Auth::user();
        $event = Event::find($id);

        if ($current_user->id !== $event->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->update($data);
        return $event;
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        $current_user = Auth::user();

        if ($current_user->id !== $event->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }

        $event->delete();
        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
}
