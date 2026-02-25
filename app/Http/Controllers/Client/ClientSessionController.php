<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CoachingSession;

class ClientSessionController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->input('type'); // 'coach' or 'nutritionist' or null

        $query = CoachingSession::where('client_id', Auth::id());

        if ($type) {
            // Map the URL parameter 'coach' to the database pivot enums ('fitness' or 'nutritionist')
            $pivotType = ($type === 'coach') ? 'fitness' : $type;

            $query->whereIn('coach_id', function ($subquery) use ($pivotType) {
                $subquery->select('coach_id')
                    ->from('coach_client')
                    ->where('client_id', Auth::id())
                    ->where('type', $pivotType);
            });
        }

        $sessions = $query->orderBy('date', 'desc')->get();

        return view('client.sessions.index', compact('sessions', 'type'));
    }

    public function show($id)
    {
        // Cari sesi dan pastikan sesi tersebut milik klien yang sedang login
        $session = CoachingSession::where('id', $id)
            ->where('client_id', Auth::id())
            ->with('coach')
            ->firstOrFail();

        return view('client.sessions.show', compact('session'));
    }
}
