@extends('layout')

@section('title', 'Dashboard Petugas')

@section('content')
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="stat-card primary">
                <i class="bi bi-hourglass-split" style="font-size: 2rem;"></i>
                <h3>{{ $pendingBorrowings->count() }}</h3>
                <p>Peminjaman Menunggu Persetujuan</p>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="stat-card success">
                <i class="bi bi-arrow-return-left" style="font-size: 2rem;"></i>
                <h3>{{ $approvedBorrowings->count() }}</h3>
                <p>Peminjaman Aktif (Menunggu Pengembalian)</p>
            </div>
        </div>
    </div>

    <!-- Peminjaman Pending -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-hourglass-split"></i> Peminjaman Menunggu Persetujuan
                </div>
                <div class="card-body">
                    @if($pendingBorrowings->isEmpty())
                        <div class="alert alert-info">Tidak ada peminjaman yang menunggu persetujuan</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Alat</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Tenggat Waktu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingBorrowings as $borrowing)
                                        <tr>
                                            <td>{{ $borrowing->user->name }}</td>
                                            <td>{{ $borrowing->tool->name }}</td>
                                            <td><span class="badge bg-warning">{{ $borrowing->quantity }}</span></td>
                                            <td>{{ $borrowing->borrow_date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
                                            <td>
                                                <form action="{{ route('borrowings.approve', $borrowing) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" title="Setujui">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('borrowings.reject', $borrowing) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Tolak">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Peminjaman Approved -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-arrow-return-left"></i> Peminjaman Aktif (Menunggu Pengembalian)
                </div>
                <div class="card-body">
                    @if($approvedBorrowings->isEmpty())
                        <div class="alert alert-info">Tidak ada peminjaman aktif</div>
                    @else
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
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($approvedBorrowings as $borrowing)
                                        <tr>
                                            <td>{{ $borrowing->user->name }}</td>
                                            <td>{{ $borrowing->tool->name }}</td>
                                            <td><span class="badge bg-info">{{ $borrowing->quantity }}</span></td>
                                            <td>{{ $borrowing->borrow_date->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($borrowing->due_date < now())
                                                    <span class="badge bg-danger">Terlambat</span>
                                                    <small class="d-block">{{ $borrowing->due_date->format('d/m/Y') }}</small>
                                                @else
                                                    {{ $borrowing->due_date->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td><span class="badge bg-success">Aktif</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
