@extends('layout')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stat-card primary">
                <i class="bi bi-people-fill" style="font-size: 2rem;"></i>
                <h3>{{ $totalUsers }}</h3>
                <p>Total User</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card success">
                <i class="bi bi-tools" style="font-size: 2rem;"></i>
                <h3>{{ $totalTools }}</h3>
                <p>Total Alat</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card warning">
                <i class="bi bi-box-seam" style="font-size: 2rem;"></i>
                <h3>{{ $totalBorrowings }}</h3>
                <p>Total Peminjaman</p>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stat-card info">
                <i class="bi bi-hourglass-split" style="font-size: 2rem;"></i>
                <h3>{{ $pendingBorrowings }}</h3>
                <p>Peminjaman Menunggu</p>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-clock-history"></i> Aktivitas Terbaru
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Aksi</th>
                                    <th>Deskripsi</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentLogs as $log)
                                    <tr>
                                        <td><strong>{{ $log->user->name }}</strong></td>
                                        <td><span class="badge bg-primary">{{ $log->action }}</span></td>
                                        <td>{{ $log->description }}</td>
                                        <td>{{ $log->created_at->diffForHumans() }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Belum ada aktivitas</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
