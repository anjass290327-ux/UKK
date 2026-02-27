@extends('layout')

@section('title', 'Ajukan Peminjaman')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-plus-circle"></i> Ajukan Peminjaman Alat
                </div>
                <div class="card-body">
                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="tool_id" class="form-label">Pilih Alat <span class="text-danger">*</span></label>
                            <select class="form-select @error('tool_id') is-invalid @enderror" id="tool_id" name="tool_id" required onchange="updateAvailability()">
                                <option value="">-- Pilih Alat --</option>
                                @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}" {{ old('tool_id') == $tool->id ? 'selected' : '' }} data-available="{{ $tool->available_quantity }}">
                                        {{ $tool->name }} ({{ $tool->category->name }}) - Tersedia: {{ $tool->available_quantity }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tool_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="alert alert-info" id="availabilityAlert" style="display: none;">
                            Alat ini memiliki stok sebanyak <strong id="availabilityCount">0</strong> buah yang tersedia.
                        </div>

                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah yang Diminta <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', 1) }}" min="1" required>
                            @error('quantity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="due_date" class="form-label">Tenggat Waktu Pengembalian <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                            @error('due_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan (Opsional)</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="alert alert-warning" role="alert">
                            <i class="bi bi-exclamation-circle"></i> Pastikan Anda telah membaca dan menyetujui Syarat dan Ketentuan Penggunaan Alat sebelum mengajukan peminjaman.
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Ajukan Peminjaman
                            </button>
                            <a href="{{ route('borrowings.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-info-circle"></i> Informasi Penting
                </div>
                <div class="card-body">
                    <p><strong>Cara Mengajukan Peminjaman:</strong></p>
                    <ol>
                        <li>Pilih alat yang ingin Anda pinjam</li>
                        <li>Tentukan jumlah alat</li>
                        <li>Atur tanggal pengembalian</li>
                        <li>Ajukan permintaan</li>
                        <li>Tunggu persetujuan dari petugas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateAvailability() {
            const select = document.getElementById('tool_id');
            const alert = document.getElementById('availabilityAlert');
            const count = document.getElementById('availabilityCount');
            
            if (select.value) {
                const option = select.options[select.selectedIndex];
                const available = option.getAttribute('data-available');
                count.textContent = available;
                alert.style.display = 'block';
            } else {
                alert.style.display = 'none';
            }
        }

        // Initialize on page load
        window.addEventListener('load', updateAvailability);
    </script>
@endsection
