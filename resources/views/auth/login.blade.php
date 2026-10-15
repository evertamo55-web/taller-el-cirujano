<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Taller "El Cirujano"</title>
    <link rel="stylesheet" href="{{ asset('css/boastrap.min.css') }}">
    <style>
        body {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .login-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
            max-width: 420px;
            width: 100%;
            overflow: hidden;
        }
        .login-header {
            background: linear-gradient(135deg, #d4a017 0%, #b8860b 100%);
            color: #ffffff;
            padding: 30px 20px;
            text-align: center;
        }
        .login-header h1 {
            font-size: 22px;
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .login-header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            opacity: 0.9;
        }
        .login-body {
            padding: 30px 25px;
        }
        .form-label {
            font-weight: 600;
            font-size: 13px;
            color: #333;
            margin-bottom: 6px;
        }
        .form-control {
            border: 1.5px solid #ddd;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #d4a017;
            box-shadow: 0 0 0 3px rgba(212, 160, 23, 0.15);
        }
        .btn-login {
            background: linear-gradient(135deg, #d4a017 0%, #b8860b 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-size: 15px;
            letter-spacing: 0.5px;
            transition: transform 0.2s;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            color: #fff;
        }
        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            border-radius: 8px;
            font-size: 13px;
            padding: 10px 14px;
        }
        .login-footer {
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            font-size: 12px;
            color: #6c757d;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-header">
            <h1>TALLER "EL CIRUJANO"</h1>
            <p>Sistema de control y seguimiento de servicios</p>
        </div>
        <div class="login-body">
            @if ($errors->any())
                <div class="alert alert-danger mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success mb-3" style="background:#f0fdf4;color:#166534;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;padding:10px 14px;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="email">Correo Electrónico</label>
                    <input type="email" name="email" id="email" class="form-control"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label class="form-check-label" for="remember" style="font-size:13px;color:#555;">
                        Recordarme en este equipo
                    </label>
                </div>

                <button type="submit" class="btn btn-login">Iniciar Sesión</button>
            </form>
        </div>
        <div class="login-footer">
            © 2026 Taller Mecánico "El Cirujano" · Trinidad, Beni
        </div>
    </div>
</body>
</html>