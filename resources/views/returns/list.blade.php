@extends('layout')

@section('title', 'Daftar Pengembalian')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-arrow-return-left"></i> Daftar Pengembalian Alat</h3>
        @if(auth()->user()->role !== 'peminjam')
            <div>
                <a href="{{ route('returns.print') }}" class="btn btn-info me-2" target="_blank">
                    <i class="bi bi-printer"></i> Cetak Laporan
                </a>
                <a href="{{ route('returns.export') }}" class="btn btn-success">
                    <i class="bi bi-download"></i> Export Laporan
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Quantity Dikembalikan</th>
                        <th>Tanggal Kembali</th>
                        <th>Kondisi</th>
                        <th>Diterima Oleh</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returns as $return)
                        <tr>
                            <td>{{ $return->borrowing->user->name }}</td>
                            <td>{{ $return->borrowing->tool->name }}</td>
                            <td>{{ $return->quantity_returned }}</td>
                            <td>{{ $return->return_date->format('d/m/Y H:i') }}</td>
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
                            <td>{{ $return->receivedBy ? $return->receivedBy->name : '-' }}</td>
                            <td>
                                @if($return->notes)
                                    <small class="text-muted">{{ Str::limit($return->notes, 50) }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox"></i> Tidak ada data pengembalian
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($returns->hasPages())
            <div class="card-footer bg-white">
                {{ $returns->links() }}
            </div>
        @endif
    </div>
@endsection
