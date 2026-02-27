@extends('layout')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-clock-history"></i> Log Aktivitas</h3>
        <a href="{{ route('activity-logs.export') }}" class="btn btn-success">
            <i class="bi bi-download"></i> Export CSV
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Deskripsi</th>
                        <th>Tabel</th>
                        <th>IP Address</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>
                                <strong>{{ $log->user->name }}</strong><br>
                                <small class="text-muted">{{ $log->user->email }}</small>
                            </td>
                            <td>
                                @if($log->action === 'CREATE')
                                    <span class="badge bg-success">CREATE</span>
                                @elseif($log->action === 'UPDATE')
                                    <span class="badge bg-info">UPDATE</span>
                                @elseif($log->action === 'DELETE')
                                    <span class="badge bg-danger">DELETE</span>
                                @elseif($log->action === 'LOGIN')
                                    <span class="badge bg-primary">LOGIN</span>
                                @elseif($log->action === 'LOGOUT')
                                    <span class="badge bg-secondary">LOGOUT</span>
                                @elseif($log->action === 'APPROVE')
                                    <span class="badge bg-success">APPROVE</span>
                                @elseif($log->action === 'REJECT')
                                    <span class="badge bg-danger">REJECT</span>
                                @elseif($log->action === 'RETURN')
                                    <span class="badge bg-info">RETURN</span>
                                @else
                                    <span class="badge bg-secondary">{{ $log->action }}</span>
                                @endif
                            </td>
                            <td>{{ $log->description }}</td>
                            <td>
                                @if($log->table_name)
                                    <code>{{ $log->table_name }}</code>
                                @else
                                    -
                                @endif
                            </td>
                            <td><small>{{ $log->ip_address }}</small></td>
                            <td>
                                <strong>{{ $log->created_at->format('d/m/Y') }}</strong><br>
                                <small>{{ $log->created_at->format('H:i:s') }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada log aktivitas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $logs->links() }}
    </div>
@endsection
