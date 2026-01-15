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
            $query->whereHas('coach', function ($q) use ($type) {
                if ($type === 'coach') {
                    // Coach biasa bisa punya spec: 'fitness', 'coach', atau NULL/Empty
                    $q->whereIn('specialization', ['fitness', 'coach'])
                        ->orWhereNull('specialization')
                        ->orWhere('specialization', '');
                } else {
                    // Nutritionist spesifik
                    $q->where('specialization', $type); // 'nutritionist'
                }
            });
        }

        $sessions = $query->orderBy('date', 'desc')->get();

        return view('client.sessions.index', compact('sessions', 'type'));
    }
}
