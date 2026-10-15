<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        
        <h2 style="color: #ffc107; text-align: center; margin-top: 0;">TALLER "EL CIRUJANO"</h2>
        
        <p>Hola, <strong>{{ $tecnico->nombre_empleado }}</strong>.</p>
        
        <p>Este es tu reporte de ganancias del día:</p>

        <div style="background: #d1e7dd; padding: 20px; border-radius: 8px; text-align: center; margin: 20px 0;">
            <h3 style="margin: 0; color: #0f5132;">Ganancia Acumulada</h3>
            <h1 style="color: #198754; margin: 10px 0 0 0; font-size: 2.5rem;">
                Bs. {{ number_format($totalGanado, 2) }}
            </h1>
        </div>

        <p style="text-align: center; margin-top: 30px;">
            Para ver el detalle completo de tus órdenes, haz clic en el siguiente botón:
        </p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $urlGanancias }}" style="background: #ffc107; color: #000; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                Ver mis ganancias
            </a>
        </div>

        <p style="color: #6c757d; font-size: 0.85rem; text-align: center;">
            Este enlace es válido solo por hoy. Si no solicitaste este correo, ignóralo.
        </p>

        <hr style="border: 1px solid #e9ecef; margin: 20px 0;">

        <p style="color: #6c757d; font-size: 0.8rem; text-align: center; margin: 0;">
            © {{ date('Y') }} Taller Mecánico "El Cirujano" - Trinidad, Beni
        </p>
    </div>
</body>
</html>