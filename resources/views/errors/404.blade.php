<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            padding: 50px 30px;
            text-align: center;
            max-width: 500px;
        }
        .error-code {
            font-size: 4rem;
            font-weight: 700;
            color: #667eea;
            margin: 0;
        }
        .error-message {
            font-size: 1.3rem;
            color: #333;
            margin: 20px 0;
        }
        .error-description {
            color: #666;
            margin: 20px 0;
        }
        .btn-home {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            text-decoration: none;
            margin-top: 20px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code">404</h1>
        <h2 class="error-message">Halaman Tidak Ditemukan</h2>
        <p class="error-description">
            Maaf, halaman yang Anda cari tidak dapat ditemukan. 
            Kemungkinan URL salah atau halaman telah dihapus.
        </p>
        <a href="{{ route('dashboard') }}" class="btn-home">
            ← Kembali ke Dashboard
        </a>
    </div>
</body>
</html>
