@extends('layout')

@section('title', 'Dashboard Peminjam')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Selamat Datang, {{ auth()->user()->name }}!
                </div>
                <div class="card-body">
                    <p>Anda dapat meminjam berbagai alat yang tersedia. Silakan jelajahi daftar alat di bawah ini atau ajukan peminjaman baru.</p>
                    <a href="{{ route('borrowings.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajukan Peminjaman Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alat Tersedia -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h5 class="mb-3"><i class="bi bi-tools"></i> Alat Tersedia</h5>
            <div class="row">
                @forelse($tools as $tool)
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">{{ $tool->name }}</h5>
                                <p class="card-text">
                                    <small class="text-muted">{{ $tool->category->name }}</small>
                                    <br>
                                    <strong>Stok Tersedia:</strong> <span class="badge bg-success">{{ $tool->available_quantity }}</span>
                                </p>
                                <p class="card-text">{{ Str::limit($tool->description, 50) }}</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <a href="{{ route('borrowings.create') }}" class="btn btn-sm btn-primary w-100">
                                    <i class="bi bi-plus-circle"></i> Pinjam
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12">
                        <div class="alert alert-info">Tidak ada alat yang tersedia saat ini</div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Peminjaman Saya -->
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-box-seam"></i> Peminjaman Saya
                </div>
                <div class="card-body">
                    @if($myBorrowings->isEmpty())
                        <div class="alert alert-info">Anda belum memiliki peminjaman</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Alat</th>
                                        <th>Jumlah</th>
                                        <th>Tanggal Peminjaman</th>
                                        <th>Tenggat Waktu</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($myBorrowings as $borrowing)
                                        <tr>
                                            <td>{{ $borrowing->tool->name }}</td>
                                            <td>{{ $borrowing->quantity }}</td>
                                            <td>{{ $borrowing->borrow_date->format('d/m/Y H:i') }}</td>
                                            <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
                                            <td>
                                                @if($borrowing->status === 'pending')
                                                    <span class="badge bg-warning">Menunggu Persetujuan</span>
                                                @elseif($borrowing->status === 'approved')
                                                    <span class="badge bg-success">Disetujui</span>
                                                @elseif($borrowing->status === 'rejected')
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @elseif($borrowing->status === 'returned')
                                                    <span class="badge bg-secondary">Dikembalikan</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($borrowing->status === 'approved' && !$borrowing->return)
                                                    <a href="{{ route('returns.create', $borrowing) }}" class="btn btn-sm btn-info" title="Kembalikan">
                                                        <i class="bi bi-arrow-return-left"></i>
                                                    </a>
                                                @endif
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
@endsection
