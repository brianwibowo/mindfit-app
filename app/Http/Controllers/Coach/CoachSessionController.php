<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CoachingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachSessionController extends Controller
{
    public function show(CoachingSession $session)
    {
        if ($session->coach_id !== Auth::id()) {
            abort(403);
        }
        return view('coach.sessions.show', compact('session'));
    }

    public function index()
    {
        $sessions = CoachingSession::where('coach_id', Auth::id())
            ->with('client')
            ->orderBy('date', 'desc')
            ->get();
        return view('coach.sessions.index', compact('sessions'));
    }

    public function create(User $client = null)
    {
        // If client is not passed, show logical error or allow selection in view if we want generic create (but required says "Buat Jadwal untuk: (user)")
        // User asked for "Tombol jadwalkan sesi -> form".
        // Let's modify create to just return view, passing assigned clients if no client strictly required yet, or keep strict.
        // For simplicity let's allow generic create where they pick a client.

        $clients = Auth::user()->clients;
        return view('coach.sessions.create', compact('client', 'clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'title' => 'required|string|max:255',
            'type' => 'required|in:online,offline',
            'notes' => 'nullable|string',
        ]);

        if (!Auth::user()->clients->contains($request->client_id)) {
            abort(403, 'Unauthorized action. Client validation failed.');
        }

        CoachingSession::create([
            'coach_id' => Auth::id(),
            'client_id' => $request->client_id,
            'date' => $request->date . ' ' . $request->time, // Combine date & time
            'title' => $request->title,
            'type' => $request->type,
            'notes' => $request->notes,
            'status' => 'scheduled',
        ]);

        return redirect()->route('coach.sessions.index')->with('success', 'Sesi berhasil dijadwalkan!');
    }

    public function edit(CoachingSession $session)
    {
        if ($session->coach_id !== Auth::id()) {
            abort(403);
        }
        $clients = Auth::user()->clients;
        return view('coach.sessions.edit', compact('session', 'clients'));
    }

    public function update(Request $request, CoachingSession $session)
    {
        if ($session->coach_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'title' => 'required|string|max:255',
            'type' => 'required|in:online,offline',
            'notes' => 'nullable|string',
        ]);

        $session->update([
            'date' => $request->date . ' ' . $request->time,
            'title' => $request->title,
            'type' => $request->type,
            'notes' => $request->notes,
        ]);

        return redirect()->route('coach.sessions.index')->with('success', 'Sesi berhasil diperbarui!');
    }

    public function destroy(CoachingSession $session)
    {
        if ($session->coach_id !== Auth::id()) {
            abort(403);
        }
        $session->delete();
        return redirect()->route('coach.sessions.index')->with('success', 'Sesi berhasil dihapus.');
    }
}
