<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Presensi - Masuk</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --dark: #0f172a;
            --gray-500: #64748b;
            --gray-200: #e2e8f0;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 440px;
            padding: 36px 32px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
        }
        .login-header {
            text-align: center;
            margin-bottom: 28px;
        }
        .brand-icon {
            width: 52px;
            height: 52px;
            background: linear-gradient(135deg, var(--primary), #3b82f6);
            color: white;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            font-weight: 800;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4);
            margin-bottom: 14px;
        }
        .login-header h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -0.02em;
        }
        .login-header p {
            font-size: 13px;
            color: var(--gray-500);
            margin-top: 4px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.2s;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: var(--primary);
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
            margin-top: 8px;
            box-shadow: 0 4px 6px -1px rgba(37, 99, 235, 0.25);
        }
        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 12px -1px rgba(37, 99, 235, 0.35);
        }
        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
        }
        .demo-box {
            margin-top: 24px;
            padding: 14px;
            background: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 10px;
            font-size: 12px;
            color: #475569;
            text-align: center;
        }
        .demo-box strong {
            color: var(--dark);
        }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-header">
            <div class="brand-icon">P</div>
            <h2>Masuk ke PresensiApp</h2>
            <p>Silakan gunakan kredensial akun Anda untuk melanjutkan</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', 'admin@presensi.com') }}" placeholder="nama@perusahaan.com" required autofocus>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi (Password)</label>
                <input type="password" id="password" name="password" class="form-control" value="password123" placeholder="••••••••" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-submit">Masuk ke Sistem</button>
        </form>

        <div class="demo-box">
            <div><strong>Akun Demo Pengujian:</strong></div>
            <div style="margin-top: 4px;">Admin: <code>admin@presensi.com</code> | Pass: <code>password123</code></div>
            <div>Magang: <code>intern@presensi.com</code> | Pass: <code>password123</code></div>
        </div>
    </div>

</body>
</html>
