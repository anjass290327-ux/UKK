@extends('layout')

@section('title', 'Kembalikan Alat')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-arrow-return-left"></i> Kembalikan Alat
                </div>
                <div class="card-body">
                    <div class="alert alert-info mb-4">
                        <strong>Alat:</strong> {{ $borrowing->tool->name }}<br>
                        <strong>Kategori:</strong> {{ $borrowing->tool->category->name }}<br>
                        <strong>Jumlah Dipinjam:</strong> {{ $borrowing->quantity }}<br>
                        <strong>Tanggal Peminjaman:</strong> {{ $borrowing->borrow_date->format('d/m/Y H:i') }}<br>
                        <strong>Tenggat Waktu:</strong> {{ $borrowing->due_date->format('d/m/Y') }}
                        @if($borrowing->due_date < now())
                            <span class="badge bg-danger">TERLAMBAT</span>
                        @endif
                    </div>

                    <form action="{{ route('returns.store', $borrowing) }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="quantity_returned" class="form-label">Jumlah Alat yang Dikembalikan <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_returned') is-invalid @enderror" id="quantity_returned" name="quantity_returned" value="{{ old('quantity_returned', $borrowing->quantity) }}" min="1" max="{{ $borrowing->quantity }}" required>
                            <small class="text-muted">Maksimal {{ $borrowing->quantity }} buah</small>
                            @error('quantity_returned') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="condition" class="form-label">Kondisi Alat <span class="text-danger">*</span></label>
                            <select class="form-select @error('condition') is-invalid @enderror" id="condition" name="condition" required>
                                <option value="">-- Pilih Kondisi --</option>
                                <option value="sangat baik" {{ old('condition') === 'sangat baik' ? 'selected' : '' }}>Sangat Baik</option>
                                <option value="baik" {{ old('condition') === 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="sedang" {{ old('condition') === 'sedang' ? 'selected' : '' }}>Sedang</option>
                                <option value="rusak" {{ old('condition') === 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                            @error('condition') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3" placeholder="Tuliskan catatan atau keluhan tentang alat jika ada">{{ old('notes') }}</textarea>
                            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Kembalikan Alat
                            </button>
                            <a href="{{ route('returns.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
