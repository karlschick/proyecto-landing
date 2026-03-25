<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #10B981; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .info-box { background: white; padding: 15px; margin: 10px 0; border: 1px solid #ddd; }
        .message-box { background: #FEF3C7; padding: 15px; margin: 20px 0; border-left: 4px solid #F59E0B; }
        .button { display: inline-block; padding: 12px 24px; background: #4F46E5; color: white; text-decoration: none; border-radius: 5px; margin: 20px 0; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔔 Nuevo Contacto</h1>
        </div>

        <div class="content">
            <h2>¡Hola!</h2>

            <p>Has recibido un nuevo mensaje de contacto desde tu sitio web.</p>

            <div class="info-box">
                <h3>Detalles del contacto:</h3>
                <ul>
                    <li><strong>Nombre:</strong> {{ $lead->name }}</li>
                    <li><strong>Email:</strong> <a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a></li>
                    <li><strong>Teléfono:</strong> {{ $lead->phone ?? 'No proporcionado' }}</li>
                    <li><strong>Asunto:</strong> {{ $lead->subject ?? 'Sin asunto' }}</li>
                </ul>
            </div>

            <div class="message-box">
                <strong>Mensaje:</strong>
                <p>{{ $lead->message }}</p>
            </div>

            <div class="info-box">
                <h3>Información adicional:</h3>
                <ul>
                    <li><strong>Recibido:</strong> {{ $lead->created_at->format('d/m/Y H:i') }}</li>
                    <li><strong>IP:</strong> {{ $lead->ip_address }}</li>
                </ul>
            </div>

            <center>
                <a href="{{ url('/admin/leads/' . $lead->id) }}" class="button">Ver en el Panel de Admin</a>
            </center>
        </div>

        <div class="footer">
            <p>Saludos,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
