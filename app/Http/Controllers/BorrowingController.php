<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\Tool;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'petugas') {
            $borrowings = Borrowing::with(['user', 'tool'])->paginate(10);
        } else {
            $borrowings = Borrowing::where('user_id', auth()->id())
                ->with(['tool'])
                ->paginate(10);
        }

        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        if (auth()->user()->role === 'peminjam') {
            $tools = Tool::where('is_active', true)
                ->where('available_quantity', '>', 0)
                ->get();
            return view('borrowings.create', compact('tools'));
        }

        abort(403);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tool_id' => 'required|exists:tools,id',
            'quantity' => 'required|integer|min:1',
            'due_date' => 'required|date|after:today',
            'notes' => 'nullable|string',
        ]);

        $tool = Tool::find($validated['tool_id']);

        if ($tool->available_quantity < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Stok alat tidak mencukupi']);
        }

        $borrowing = Borrowing::create([
            'user_id' => auth()->id(),
            'tool_id' => $validated['tool_id'],
            'quantity' => $validated['quantity'],
            'borrow_date' => now(),
            'due_date' => $validated['due_date'],
            'status' => 'pending',
            'notes' => $validated['notes'] ?? null,
        ]);

        $this->logActivity('CREATE', "Peminjaman alat {$tool->name} sebanyak {$validated['quantity']} buah berhasil dibuat", 'borrowings', $borrowing->id);

        return redirect()->route('borrowings.index')->with('success', 'Permintaan peminjaman berhasil dikirim');
    }

    public function show(Borrowing $borrowing)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'petugas' && $borrowing->user_id !== auth()->id()) {
            abort(403);
        }

        return view('borrowings.show', compact('borrowing'));
    }

    public function approve(Borrowing $borrowing)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'petugas') {
            abort(403);
        }

        if ($borrowing->status !== 'pending') {
            return back()->withErrors(['status' => 'Hanya peminjaman dengan status pending yang bisa disetujui']);
        }

        // Kurangi available_quantity
        $borrowing->tool->decrement('available_quantity', $borrowing->quantity);

        $borrowing->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        $this->logActivity('APPROVE', "Peminjaman alat {$borrowing->tool->name} disetujui", 'borrowings', $borrowing->id);

        return back()->with('success', 'Peminjaman berhasil disetujui');
    }

    public function reject(Borrowing $borrowing)
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'petugas') {
            abort(403);
        }

        $borrowing->update(['status' => 'rejected']);

        $this->logActivity('REJECT', "Peminjaman alat {$borrowing->tool->name} ditolak", 'borrowings', $borrowing->id);

        return back()->with('success', 'Peminjaman berhasil ditolak');
    }

    public function export()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'petugas') {
            abort(403);
        }

        $borrowings = Borrowing::with(['user', 'tool'])->get();
        
        $csv = "ID,Peminjam,Email,Alat,Kategori,Quantity,Tanggal Pinjam,Due Date,Status,Disetujui Oleh,Tanggal Setuju,Catatan\n";
        
        foreach ($borrowings as $borrowing) {
            $approverName = $borrowing->approver ? $borrowing->approver->name : '-';
            $approvedAtDate = $borrowing->approved_at ? $borrowing->approved_at->format('Y-m-d H:i') : '-';
            
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,%d,%s,%s,%s,%s,%s,%s\n",
                $borrowing->id,
                "\"{$borrowing->user->name}\"",
                $borrowing->user->email,
                $borrowing->tool->name,
                $borrowing->tool->category->name ?? 'N/A',
                $borrowing->quantity,
                $borrowing->borrow_date->format('Y-m-d H:i'),
                $borrowing->due_date->format('Y-m-d H:i'),
                ucfirst($borrowing->status),
                $approverName,
                $approvedAtDate,
                "\"{$borrowing->notes}\""
            );
        }

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="laporan-peminjaman-' . now()->format('Y-m-d-His') . '.csv"');
    }

    public function printReport()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'petugas') {
            abort(403);
        }

        $borrowings = Borrowing::with(['user', 'tool', 'approver'])->get();

        return view('borrowings.print', compact('borrowings'));
    }

    protected function logActivity($action, $description, $table_name = null, $record_id = null)
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'table_name' => $table_name,
            'record_id' => $record_id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
