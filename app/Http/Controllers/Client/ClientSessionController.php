<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CoachingSession;

class ClientSessionController extends Controller
{
    public function index()
    {
        $sessions = CoachingSession::where('client_id', Auth::id())
            ->orderBy('date', 'desc')
            ->get();

        return view('client.sessions.index', compact('sessions'));
    }
}
