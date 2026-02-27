<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(20);
        
        return view('activity-logs.index', compact('logs'));
    }

    public function export()
    {
        $logs = ActivityLog::with('user')->latest()->get();
        
        $csv = "ID,User,Action,Description,Table,Record ID,IP Address,Created At\n";
        
        foreach ($logs as $log) {
            $csv .= "{$log->id},{$log->user->name},{$log->action},\"{$log->description}\",{$log->table_name},{$log->record_id},{$log->ip_address},{$log->created_at}\n";
        }
        
        return response()->streamDownload(function () use ($csv) {
            echo $csv;
        }, 'activity-logs-' . now()->format('Y-m-d-H-i-s') . '.csv');
    }
}
