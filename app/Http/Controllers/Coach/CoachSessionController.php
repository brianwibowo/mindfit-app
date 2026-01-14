<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CoachingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachSessionController extends Controller
{
    public function create(User $client)
    {
        // Ensure this client is assigned to the logged-in coach
        if (!Auth::user()->clients->contains($client->id)) {
            abort(403, 'Unauthorized action.');
        }

        return view('coach.sessions.create', compact('client'));
    }

    public function store(Request $request, User $client)
    {
        if (!Auth::user()->clients->contains($client->id)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'title' => 'required|string|max:255',
            'type' => 'required|in:online,offline',
            'notes' => 'nullable|string',
        ]);

        CoachingSession::create([
            'coach_id' => Auth::id(),
            'client_id' => $client->id,
            'date' => $request->date . ' ' . $request->time, // Combine date & time
            'title' => $request->title,
            'type' => $request->type,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        return redirect()->route('coach.dashboard')->with('success', 'Sesi berhasil dijadwalkan!');
    }
}
