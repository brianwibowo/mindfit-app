<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminProgressController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->query('view', 'recent');

        if ($view === 'clients') {
            $clients = \App\Models\User::where('role', 'client')
                ->whereHas('progressLogs')
                ->with(['coaches', 'progressLogs' => function($q) {
                    $q->orderBy('date', 'desc');
                }])
                ->paginate(4)
                ->withQueryString();

            if ($request->ajax()) {
                return view('admin.progress.partials.tab_content', compact('clients', 'view'))->render();
            }

            return view('admin.progress.index', compact('clients', 'view'));
        } else {
            // Recent unreviewed logs
            $logs = \App\Models\ProgressLog::with(['client.clientProfile', 'coach'])
                ->whereNull('coach_note')
                ->orderBy('date', 'desc')
                ->paginate(10)
                ->withQueryString();

            if ($request->ajax()) {
                return view('admin.progress.partials.tab_content', compact('logs', 'view'))->render();
            }

            return view('admin.progress.index', compact('logs', 'view'));
        }
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

    /**
     * Client Timeline — show all progress logs for a specific client.
     * Provides paginated log list, chart data, coaches info, and summary stats.
     */
    public function clientTimeline($clientId)
    {
        $client = \App\Models\User::where('role', 'client')
            ->with('coaches')
            ->findOrFail($clientId);

        // Paginated logs for the table (newest first)
        $logs = \App\Models\ProgressLog::where('client_id', $clientId)
            ->with('coach')
            ->orderBy('date', 'desc')
            ->paginate(10);

        // All logs for the chart (oldest first, no pagination)
        $chartLogs = \App\Models\ProgressLog::where('client_id', $clientId)
            ->orderBy('date', 'asc')
            ->get();

        return view('admin.progress.client_timeline', compact('client', 'logs', 'chartLogs'));
    }

    public function downloadPdf($id)
    {
        $log = \App\Models\ProgressLog::with(['client', 'coach'])->findOrFail($id);
        
        $clientLogs = \App\Models\ProgressLog::where('client_id', $log->client_id)
            ->orderBy('date', 'asc')
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('layouts.pdf_report', compact('log', 'clientLogs'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Progress_Klien_' . str_replace(' ', '_', $log->client->name) . '_' . date('Ymd') . '.pdf');
    }
}
