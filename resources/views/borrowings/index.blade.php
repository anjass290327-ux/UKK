@extends('layout')

@section('title', 'Peminjaman')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-box-seam"></i> Daftar Peminjaman</h3>
        <div>
            @if(auth()->user()->role === 'peminjam')
                <a href="{{ route('borrowings.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Ajukan Peminjaman Baru
                </a>
            @else
                <a href="{{ route('borrowings.print') }}" class="btn btn-info me-2" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
                <a href="{{ route('borrowings.export') }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Export CSV
                </a>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Alat</th>
                        <th>Jumlah</th>
                        <th>Tanggal Peminjaman</th>
                        <th>Tenggat Waktu</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                        <tr>
                            <td>{{ $borrowing->user->name }}</td>
                            <td>{{ $borrowing->tool->name }}</td>
                            <td>{{ $borrowing->quantity }}</td>
                            <td>{{ $borrowing->borrow_date->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($borrowing->due_date < now() && $borrowing->status === 'approved' && !$borrowing->return)
                                    <span class="badge bg-danger">Terlambat</span><br>
                                @endif
                                {{ $borrowing->due_date->format('d/m/Y') }}
                            </td>
                            <td>
                                @if($borrowing->status === 'pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                @elseif($borrowing->status === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif($borrowing->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($borrowing->status === 'returned')
                                    <span class="badge bg-secondary">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                @if(auth()->user()->role !== 'peminjam' && $borrowing->status === 'pending')
                                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#approveModal{{ $borrowing->id }}" title="Setujui">
                                        <i class="bi bi-check-circle"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $borrowing->id }}" title="Tolak">
                                        <i class="bi bi-x-circle"></i>
                                    </button>

                                    <!-- Approve Modal -->
                                    <div class="modal fade" id="approveModal{{ $borrowing->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Setujui Peminjaman</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menyetujui peminjaman {{ $borrowing->tool->name }} untuk {{ $borrowing->user->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success">Ya, Setujui</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Reject Modal -->
                                    <div class="modal fade" id="rejectModal{{ $borrowing->id }}">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tolak Peminjaman</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Apakah Anda yakin ingin menolak peminjaman {{ $borrowing->tool->name }} untuk {{ $borrowing->user->name }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Ya, Tolak</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(auth()->user()->role === 'peminjam' && $borrowing->status === 'approved' && !$borrowing->return)
                                    <a href="{{ route('returns.create', $borrowing) }}" class="btn btn-sm btn-info" title="Kembalikan">
                                        <i class="bi bi-arrow-return-left"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data peminjaman</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $borrowings->links() }}
    </div>
@endsection
