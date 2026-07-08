<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoachingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminSessionController extends Controller
{
    /**
     * Display a listing of coaching sessions.
     */
    public function index(Request $request)
    {
        $timeFilter = $request->query('time_filter', 'today');

        $query = CoachingSession::with(['coach', 'client']);

        $todayStart = Carbon::today();
        $todayEnd = Carbon::today()->endOfDay();

        // Apply time range filters
        if ($timeFilter === 'today') {
            $query->whereBetween('date', [$todayStart, $todayEnd])
                  ->orderBy('date', 'asc');
        } elseif ($timeFilter === 'upcoming') {
            $query->where('date', '>', $todayEnd)
                  ->where('status', 'scheduled')
                  ->orderBy('date', 'asc');
        } else { // history
            $query->where(function($q) use ($todayStart) {
                $q->where('date', '<', $todayStart)
                  ->orWhereIn('status', ['completed', 'cancelled']);
            })->orderBy('date', 'desc');
        }

        $sessions = $query->paginate(10)->withQueryString();

        // Fetch coaches and clients to populate dropdown options in Modals
        $coaches = User::whereIn('role', ['coach', 'nutritionist'])
                       ->where('is_active', true)
                       ->orderBy('name', 'asc')
                       ->get();

        $clients = User::where('role', 'client')
                       ->where('is_active', true)
                       ->orderBy('name', 'asc')
                       ->get();

        // AJAX dynamic partial table rendering
        if ($request->ajax()) {
            return view('admin.sessions.partials.table_body', compact('sessions', 'timeFilter'))->render();
        }

        return view('admin.sessions.index', compact('sessions', 'timeFilter', 'coaches', 'clients'));
    }

    /**
     * Store a newly created coaching session.
     */
    public function store(Request $request)
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
        $sessionDateTime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $validated['date'] = $sessionDateTime;
        unset($validated['time']);

        // Check for session scheduling conflicts (1 hour buffer window)
        $bufferStart = (clone $sessionDateTime)->subMinutes(59);
        $bufferEnd = (clone $sessionDateTime)->addMinutes(59);

        // Check coach availability
        $coachConflict = CoachingSession::where('coach_id', $validated['coach_id'])
            ->whereIn('status', ['scheduled'])
            ->whereBetween('date', [$bufferStart, $bufferEnd])
            ->first();

        if ($coachConflict) {
            return back()->withInput()->with('error', '⚠️ Jadwal Bentrok! Pelatih (Coach) sudah memiliki jadwal lain pada jam tersebut (' . $coachConflict->date->format('H:i') . ' WIB).');
        }

        // Check client availability
        $clientConflict = CoachingSession::where('client_id', $validated['client_id'])
            ->whereIn('status', ['scheduled'])
            ->whereBetween('date', [$bufferStart, $bufferEnd])
            ->first();

        if ($clientConflict) {
            return back()->withInput()->with('error', '⚠️ Jadwal Bentrok! Klien sudah memiliki sesi latihan lain pada jam tersebut (' . $clientConflict->date->format('H:i') . ' WIB).');
        }

        CoachingSession::create($validated);

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil dijadwalkan!');
    }

    /**
     * Display the specified coaching session.
     */
    public function show($id)
    {
        $session = CoachingSession::with(['coach', 'client'])->findOrFail($id);

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $session->id,
                    'title' => $session->title,
                    'type' => ucfirst($session->type),
                    'type_raw' => $session->type,
                    'coach_id' => $session->coach_id,
                    'coach_name' => $session->coach->name ?? '-',
                    'coach_role' => ucfirst($session->coach->role ?? '-'),
                    'coach_spec' => ucfirst($session->coach->specialization ?? '-'),
                    'client_id' => $session->client_id,
                    'client_name' => $session->client->name ?? '-',
                    'date_formatted' => $session->date->translatedFormat('l, d F Y'),
                    'date_raw' => $session->date->format('Y-m-d'),
                    'time_formatted' => $session->date->format('H:i') . ' WIB',
                    'time_raw' => $session->date->format('H:i'),
                    'status' => ucfirst($session->status),
                    'status_raw' => $session->status,
                    'notes' => $session->notes ?: 'Tidak ada catatan.'
                ]
            ]);
        }

        return redirect()->route('admin.sessions.index');
    }

    /**
     * Update the specified coaching session.
     */
    public function update(Request $request, $id)
    {
        $session = CoachingSession::findOrFail($id);

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
        $sessionDateTime = Carbon::parse($validated['date'] . ' ' . $validated['time']);
        $validated['date'] = $sessionDateTime;
        unset($validated['time']);

        // Check conflicts excluding current session id
        $bufferStart = (clone $sessionDateTime)->subMinutes(59);
        $bufferEnd = (clone $sessionDateTime)->addMinutes(59);

        // Check coach conflict
        $coachConflict = CoachingSession::where('coach_id', $validated['coach_id'])
            ->where('id', '!=', $id)
            ->whereIn('status', ['scheduled'])
            ->whereBetween('date', [$bufferStart, $bufferEnd])
            ->first();

        if ($coachConflict) {
            return back()->withInput()->with('error', '⚠️ Jadwal Bentrok! Pelatih sudah memiliki jadwal lain pada jam tersebut (' . $coachConflict->date->format('H:i') . ' WIB).');
        }

        // Check client conflict
        $clientConflict = CoachingSession::where('client_id', $validated['client_id'])
            ->where('id', '!=', $id)
            ->whereIn('status', ['scheduled'])
            ->whereBetween('date', [$bufferStart, $bufferEnd])
            ->first();

        if ($clientConflict) {
            return back()->withInput()->with('error', '⚠️ Jadwal Bentrok! Klien sudah memiliki sesi latihan lain pada jam tersebut (' . $clientConflict->date->format('H:i') . ' WIB).');
        }

        $session->update($validated);

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil diperbarui!');
    }

    /**
     * Remove the specified coaching session.
     */
    public function destroy($id)
    {
        $session = CoachingSession::findOrFail($id);
        $session->delete();

        return redirect()->route('admin.sessions.index')->with('success', 'Sesi berhasil dihapus!');
    }

    /**
     * AJAX quick status update for sessions.
     */
    public function updateStatus(Request $request, $id)
    {
        $session = CoachingSession::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:scheduled,completed,cancelled'
        ]);

        $session->update(['status' => $validated['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status sesi berhasil diperbarui!',
            'status' => $session->status,
            'status_label' => ucfirst($session->status)
        ]);
    }
}
