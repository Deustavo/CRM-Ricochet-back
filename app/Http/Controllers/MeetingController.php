<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use \Illuminate\Support\Facades\Auth;
use App\Events\MeetingCreated;

class MeetingController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        return Meeting::with([
            'user:id,name,email',
            'attendees:id,name,email',
        ])->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'meeting_link' => 'nullable|url',
            'attendees' => 'array',
            'attendees.*' => 'exists:users,id',
        ]);

        $meeting = Meeting::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'meeting_link' => $request->meeting_link,
        ]);

        if ($request->has('attendees')) {
            $meeting->attendees()->attach($request->attendees);
        }

        // dd($meeting);
        broadcast(new MeetingCreated($meeting));
        return response()->json($meeting->load('attendees'), 201);
    }

    public function show(Meeting $meeting)
    {
        return $meeting->load([
            'user:id,name,email',
            'attendees:id,name,email'
        ]);
    }

    public function update(Request $request, Meeting $meeting)
    {
        $this->authorize('update', $meeting);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'start_time' => 'sometimes|required|date',
            'end_time' => 'nullable|date|after:start_time',
            'meeting_link' => 'nullable|url',
            'attendees' => 'array',
            'attendees.*' => 'exists:users,id',
        ]);

        $meeting->update($request->only(['title', 'description', 'start_time', 'end_time', 'meeting_link']));

        if ($request->has('attendees')) {
            $meeting->attendees()->sync($request->attendees);
        }

        return $meeting->load('attendees');
    }

    public function destroy(Meeting $meeting)
    {
        $this->authorize('delete', $meeting);

        if (!$meeting) {
            return response()->json([
                'message' => 'Reunião não encontrada',
                'status' => 404
            ], 404);
        }

        $meeting->delete();

        return response()->json([
            'message' => 'Meeting deleted successfully',
            'status' => 200
        ], 200);
    }
}
