<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ProgressLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoachClientProgressController extends Controller
{
    public function index()
    {
        // Get all clients assigned to this coach
        $coach = Auth::user();
        $clientIds = $coach->clients()->pluck('users.id');

        $logs = ProgressLog::whereIn('client_id', $clientIds)
            ->with(['client'])
            ->orderBy('date', 'desc')
            ->get();

        return view('coach.progress.index', compact('logs'));
    }

    public function show($id)
    {
        $log = ProgressLog::with('client')->findOrFail($id);

        // Authorization check
        if (!Auth::user()->clients->contains($log->client_id)) {
            abort(403, 'Unauthorized access to this client log.');
        }

        $clientLogs = ProgressLog::where('client_id', $log->client_id)
            ->orderBy('date', 'asc')
            ->get();

        return view('coach.progress.show', compact('log', 'clientLogs'));
    }

    public function update(Request $request, $id)
    {
        $log = ProgressLog::findOrFail($id);

        // Authorization check
        if (!Auth::user()->clients->contains($log->client_id)) {
            abort(403, 'Unauthorized access.');
        }

        $request->validate(['coach_note' => 'required|string']);

        $log->update([
            'coach_note' => $request->coach_note,
            'coach_id' => Auth::id(),
        ]);

        return redirect()->route('coach.progress.show', $id)->with('success', 'Feedback berhasil dikirim!');
    }

    public function downloadPdf($id)
    {
        $log = ProgressLog::with(['client', 'coach'])->findOrFail($id);

        // Authorization check
        if (!Auth::user()->clients->contains($log->client_id)) {
            abort(403, 'Unauthorized access to this client log.');
        }

        $clientLogs = ProgressLog::where('client_id', $log->client_id)
            ->orderBy('date', 'asc')
            ->get();

        return view('layouts.pdf_report', compact('log', 'clientLogs'));
    }
}
