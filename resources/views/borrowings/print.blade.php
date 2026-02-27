<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman Alat</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            color: #666;
        }
        
        .info-section {
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .info-section p {
            margin: 3px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        table thead {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #333;
            color: white;
            font-weight: bold;
        }
        
        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 11px;
        }
        
        .footer-box {
            display: inline-block;
            text-align: center;
            margin-left: 80px;
        }
        
        .footer-box p {
            margin: 20px 0 5px 0;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-rejected {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .status-returned {
            background-color: #d1ecf1;
            color: #0c5460;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            a {
                text-decoration: none;
                color: #000;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PEMINJAMAN ALAT</h1>
        <p>Sistem Manajemen Peminjaman Alat</p>
        <p>{{ now()->format('d F Y H:i') }}</p>
    </div>
    
    <div class="info-section">
        <p><strong>Total Peminjaman:</strong> {{ $borrowings->count() }} item</p>
        <p><strong>Periode:</strong> Semua Data</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 15%">Peminjam</th>
                <th style="width: 15%">Alat</th>
                <th style="width: 8%">Qty</th>
                <th style="width: 12%">Tgl Pinjam</th>
                <th style="width: 12%">Due Date</th>
                <th style="width: 10%">Status</th>
                <th style="width: 12%">Disetujui Oleh</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $key => $borrowing)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $borrowing->user->name }}<br><small>{{ $borrowing->user->email }}</small></td>
                    <td>{{ $borrowing->tool->name }}<br><small>{{ $borrowing->tool->category->name }}</small></td>
                    <td>{{ $borrowing->quantity }}</td>
                    <td>{{ $borrowing->borrow_date->format('d/m/Y H:i') }}</td>
                    <td>{{ $borrowing->due_date->format('d/m/Y') }}</td>
                    <td>
                        <span class="status-badge status-{{ $borrowing->status }}">
                            {{ ucfirst($borrowing->status) }}
                        </span>
                    </td>
                    <td>{{ $borrowing->approver ? $borrowing->approver->name : '-' }}</td>
                </tr>
                @if($borrowing->notes)
                    <tr>
                        <td colspan="8"><small><strong>Catatan:</strong> {{ $borrowing->notes }}</small></td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data peminjaman</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <div class="footer-box">
            <p>Mengetahui,</p>
            <p style="margin-top: 40px;">_________________</p>
            <p>Petugas Penyimpanan</p>
        </div>
    </div>
    
    <div class="no-print" style="margin-top: 30px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; font-size: 14px; cursor: pointer;">
            🖨️ Cetak Laporan
        </button>
        <button onclick="window.history.back()" style="padding: 10px 20px; font-size: 14px; cursor: pointer; margin-left: 10px;">
            ← Kembali
        </button>
    </div>
</body>
</html>
