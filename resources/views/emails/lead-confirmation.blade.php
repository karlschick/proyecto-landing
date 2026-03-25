<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4F46E5; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; }
        .message-box { background: white; padding: 15px; margin: 20px 0; border-left: 4px solid #4F46E5; }
        .footer { text-align: center; padding: 20px; color: #666; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
        </div>

        <div class="content">
            <h2>¡Hola {{ $lead->name }}!</h2>

            <p>Gracias por contactarnos. Hemos recibido tu mensaje correctamente.</p>

            <div class="message-box">
                <strong>Tu mensaje:</strong>
                <p>{{ $lead->message }}</p>
            </div>

            <p>Revisaremos tu solicitud y te responderemos lo antes posible.</p>
            <p>Generalmente respondemos en menos de 24 horas hábiles.</p>

            <hr>

            <p><strong>Información de contacto:</strong></p>
            <ul>
                <li>Email: maurofit5asesorados@gmail.com</li>
                <li>Teléfono: +57 311 893 9652</li>
            </ul>

            <p>¡Esperamos poder ayudarte pronto!</p>
        </div>

        <div class="footer">
            <p>Atentamente,<br>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
