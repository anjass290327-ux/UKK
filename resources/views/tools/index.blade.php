@extends('layout')

@section('title', 'Kelola Alat')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="bi bi-tools"></i> Kelola Alat</h3>
        <a href="{{ route('tools.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah Alat
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Tersedia</th>
                        <th>Kondisi</th>
                        <th>Status</th>
                        <th>Aksi</th>x
                    </tr>
                </thead>
                <tbody>
                    @forelse($tools as $tool)
                        <tr>
                            <td><strong>{{ $tool->code }}</strong></td>
                            <td>{{ $tool->name }}</td>
                            <td>{{ $tool->category->name }}</td>
                            <td>{{ $tool->quantity }}</td>
                            <td><span class="badge bg-info">{{ $tool->available_quantity }}</span></td>
                            <td>
                                @if($tool->condition === 'sangat baik')
                                    <span class="badge bg-success">Sangat Baik</span>
                                @elseif($tool->condition === 'baik')
                                    <span class="badge bg-info">Baik</span>
                                @elseif($tool->condition === 'sedang')
                                    <span class="badge bg-warning">Sedang</span>
                                @else
                                    <span class="badge bg-danger">Rusak</span>
                                @endif
                            </td>
                            <td>
                                @if($tool->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('tools.edit', $tool) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('tools.destroy', $tool) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada alat</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $tools->links() }}
    </div>
@endsection
