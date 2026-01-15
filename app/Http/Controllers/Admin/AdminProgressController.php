<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProgressController extends Controller
{
    public function index()
    {
        $logs = \App\Models\ProgressLog::with(['client', 'coach'])
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.progress.index', compact('logs'));
    }

    public function show($id)
    {
        // Get specific log for detail view
        $log = \App\Models\ProgressLog::with(['client', 'coach'])->findOrFail($id);

        // Get all logs for this client for the charts
        $clientLogs = \App\Models\ProgressLog::where('client_id', $log->client_id)
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.progress.show', compact('log', 'clientLogs'));
    }
}
