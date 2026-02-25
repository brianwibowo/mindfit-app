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
            $query->whereIn('coach_id', function ($subquery) use ($type) {
                $subquery->select('coach_id')
                    ->from('coach_client')
                    ->where('client_id', Auth::id())
                    ->where('type', $type);
            });
        }

        $sessions = $query->orderBy('date', 'desc')->get();

        return view('client.sessions.index', compact('sessions', 'type'));
    }
}
