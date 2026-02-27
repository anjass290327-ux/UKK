<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\ReturnItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'peminjam') {
            $borrowings = Borrowing::where('user_id', auth()->id())
                ->where('status', 'approved')
                ->whereDoesntHave('returnItem')
                ->with('tool')
                ->paginate(10);
            return view('returns.index', compact('borrowings'));
        }

        $returns = ReturnItem::with(['borrowing.user', 'borrowing.tool'])->paginate(10);
        return view('returns.list', compact('returns'));
    }

    public function create(Borrowing $borrowing)
    {
        if ($borrowing->user_id !== auth()->id() && auth()->user()->role === 'peminjam') {
            abort(403);
        }

        return view('returns.create', compact('borrowing'));
    }

    public function store(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->user_id !== auth()->id() && auth()->user()->role === 'peminjam') {
            abort(403);
        }

        $validated = $request->validate([
            'quantity_returned' => 'required|integer|min:1|max:' . $borrowing->quantity,
            'condition' => 'required|in:sangat baik,baik,sedang,rusak',
            'notes' => 'nullable|string',
        ]);

        $return = ReturnItem::create([
            'borrowing_id' => $borrowing->id,
            'return_date' => now(),
            'quantity_returned' => $validated['quantity_returned'],
            'condition' => $validated['condition'],
            'notes' => $validated['notes'] ?? null,
            'received_by' => auth()->user()->role !== 'peminjam' ? auth()->id() : null,
        ]);

        // Tambah available_quantity
        $borrowing->tool->increment('available_quantity', $validated['quantity_returned']);

        // Jika semua alat dikembalikan, ubah status peminjaman menjadi returned
        if ($validated['quantity_returned'] == $borrowing->quantity) {
            $borrowing->update(['status' => 'returned']);
        }

        $this->logActivity('RETURN', "Alat {$borrowing->tool->name} sebanyak {$validated['quantity_returned']} buah berhasil dikembalikan", 'returns', $return->id);

        return redirect()->route('returns.index')->with('success', 'Pengembalian alat berhasil dicatat');
    }

    public function export()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'petugas') {
            abort(403);
        }

        $returns = ReturnItem::with(['borrowing.user', 'borrowing.tool'])->get();
        
        $csv = "ID,Peminjam,Email,Alat,Kategori,Quantity Dikembalikan,Tanggal Kembali,Kondisi,Diterima Oleh,Catatan\n";
        
        foreach ($returns as $return) {
            $receivedByName = $return->receivedBy ? $return->receivedBy->name : '-';
            
            $csv .= sprintf(
                "%d,%s,%s,%s,%s,%d,%s,%s,%s,%s\n",
                $return->id,
                "\"{$return->borrowing->user->name}\"",
                $return->borrowing->user->email,
                $return->borrowing->tool->name,
                $return->borrowing->tool->category->name ?? 'N/A',
                $return->quantity_returned,
                $return->return_date->format('Y-m-d H:i'),
                ucfirst($return->condition),
                $receivedByName,
                "\"{$return->notes}\""
            );
        }

        return response($csv, 200)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="laporan-pengembalian-' . now()->format('Y-m-d-His') . '.csv"');
    }

    public function printReport()
    {
        if (auth()->user()->role !== 'admin' && auth()->user()->role !== 'petugas') {
            abort(403);
        }

        $returns = ReturnItem::with(['borrowing.user', 'borrowing.tool', 'receivedBy'])->get();

        return view('returns.print', compact('returns'));
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
