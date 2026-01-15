<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSessionController extends Controller
{
    public function index()
    {
        $sessions = \App\Models\CoachingSession::with(['coach', 'client'])->orderBy('date', 'desc')->get();
        return view('admin.sessions.index', compact('sessions'));
    }

    public function create()
    {
        $coaches = \App\Models\User::whereIn('role', ['coach', 'nutritionist'])->get();
        $clients = \App\Models\User::where('role', 'client')->get();
        return view('admin.sessions.create', compact('coaches', 'clients'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'coach_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required|in:online,offline',
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        // Combine date and time
        $validated['date'] = $validated['date'] . ' ' . $validated['time'];
        unset($validated['time']);

        \App\Models\CoachingSession::create($validated);

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil dijadwalkan');
    }

    public function show($id)
    {
        $session = \App\Models\CoachingSession::with(['coach', 'client'])->findOrFail($id);
        return view('admin.sessions.show', compact('session'));
    }

    public function edit($id)
    {
        $session = \App\Models\CoachingSession::findOrFail($id);
        $coaches = \App\Models\User::whereIn('role', ['coach', 'nutritionist'])->get();
        $clients = \App\Models\User::where('role', 'client')->get();
        return view('admin.sessions.edit', compact('session', 'coaches', 'clients'));
    }

    public function update(\Illuminate\Http\Request $request, $id)
    {
        $session = \App\Models\CoachingSession::findOrFail($id);

        $validated = $request->validate([
            'coach_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time' => 'required',
            'type' => 'required|in:online,offline',
            'title' => 'required|string|max:255',
            'status' => 'required|in:scheduled,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Combine date and time
        $validated['date'] = $validated['date'] . ' ' . $validated['time'];
        unset($validated['time']);

        $session->update($validated);

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $session = \App\Models\CoachingSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil dihapus');
    }
}
