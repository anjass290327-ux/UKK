<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tool;
use App\Models\Borrowing;
use App\Models\ReturnItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            return $this->adminDashboard();
        } elseif ($user->role === 'petugas') {
            return $this->petugasDashboard();
        } else {
            return $this->peminjamDashboard();
        }
    }

    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalTools = Tool::count();
        $totalBorrowings = Borrowing::count();
        $pendingBorrowings = Borrowing::where('status', 'pending')->count();
        $recentLogs = ActivityLog::with('user')->latest()->limit(10)->get();
        
        return view('dashboard.admin', compact(
            'totalUsers',
            'totalTools',
            'totalBorrowings',
            'pendingBorrowings',
            'recentLogs'
        ));
    }

    private function petugasDashboard()
    {
        $pendingBorrowings = Borrowing::where('status', 'pending')
            ->with(['user', 'tool'])
            ->get();
        $approvedBorrowings = Borrowing::where('status', 'approved')
            ->whereDoesntHave('returnItem')
            ->with(['user', 'tool'])
            ->get();
        
        return view('dashboard.petugas', compact('pendingBorrowings', 'approvedBorrowings'));
    }

    private function peminjamDashboard()
    {
        $myBorrowings = Borrowing::where('user_id', auth()->id())
            ->with('tool')
            ->latest()
            ->limit(10)
            ->get();
        
        $tools = Tool::where('is_active', true)
            ->where('available_quantity', '>', 0)
            ->with('category')
            ->limit(6)
            ->get();
        
        return view('dashboard.peminjam', compact('myBorrowings', 'tools'));
    }
}
