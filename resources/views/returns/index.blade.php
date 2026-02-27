@extends('layout')

@section('title', 'Pengembalian Alat')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-arrow-return-left"></i> Pengembalian Alat</h3>
        @if(auth()->user()->role !== 'peminjam')
            <div>
                <a href="{{ route('returns.print') }}" class="btn btn-info me-2" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
                <a href="{{ route('returns.export') }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Export CSV
                </a>
            </div>
        @endif
    </div>

    @if(auth()->user()->role === 'peminjam')
        <div class="card">
            <div class="card-header">
                <i class="bi bi-box-seam"></i> Alat yang Siap untuk Dikembalikan
            </div>
            <div class="card-body">
                @if($borrowings->isEmpty())
                    <div class="alert alert-info">Anda tidak memiliki alat yang perlu dikembalikan</div>
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
                                @foreach($borrowings as $borrowing)
                                    <tr>
                                        <td>{{ $borrowing->tool->name }}</td>
                                        <td>{{ $borrowing->quantity }}</td>
                                        <td>{{ $borrowing->borrow_date->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if($borrowing->due_date < now())
                                                <span class="badge bg-danger">Terlambat</span><br>
                                            @endif
                                            {{ $borrowing->due_date->format('d/m/Y') }}
                                        </td>
                                        <td><span class="badge bg-success">Aktif</span></td>
                                        <td>
                                            <a href="{{ route('returns.create', $borrowing) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-arrow-return-left"></i> Kembalikan
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <i class="bi bi-check-circle"></i> Daftar Pengembalian
            </div>
            <div class="card-body">
                @if($borrowings->isEmpty())
                    <div class="alert alert-info">Belum ada pengembalian</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Alat</th>
                                    <th>Jumlah Dikembalikan</th>
                                    <th>Kondisi</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Diterima Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($borrowings as $return)
                                    <tr>
                                        <td>{{ $return->borrowing->user->name }}</td>
                                        <td>{{ $return->borrowing->tool->name }}</td>
                                        <td>{{ $return->quantity_returned }}</td>
                                        <td>
                                            @if($return->condition === 'sangat baik')
                                                <span class="badge bg-success">Sangat Baik</span>
                                            @elseif($return->condition === 'baik')
                                                <span class="badge bg-info">Baik</span>
                                            @elseif($return->condition === 'sedang')
                                                <span class="badge bg-warning">Sedang</span>
                                            @else
                                                <span class="badge bg-danger">Rusak</span>
                                            @endif
                                        </td>
                                        <td>{{ $return->return_date->format('d/m/Y H:i') }}</td>
                                        <td>{{ $return->receiver->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endsection
