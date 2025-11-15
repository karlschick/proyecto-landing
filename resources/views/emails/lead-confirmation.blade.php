<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de mensaje</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <!-- Contenedor principal -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">

                    <!-- Header con logo -->
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 20px;">
                            <img src="{{ asset('images/settings/logo.png') }}"
                                 alt="{{ $settings->site_name ?? 'Logo' }}"
                                 style="max-width: 200px; height: auto; display: block;">
                            <h1 style="color: #ffffff; margin: 15px 0 0 0; font-size: 24px;">
                                {{ $settings->site_name ?? config('app.name') }}
                            </h1>
                        </td>
                    </tr>

                    <!-- Contenido -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            <h2 style="color: #333333; margin: 0 0 20px 0; font-size: 22px;">
                                ¡Hola {{ $lead->name }}! 👋
                            </h2>

                            <p style="color: #555555; line-height: 1.6; margin: 0 0 20px 0;">
                                Gracias por contactarnos. Hemos recibido tu mensaje correctamente.
                            </p>

                            <!-- Caja del mensaje -->
                            <div style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 15px; margin: 20px 0; border-radius: 5px;">
                                <strong style="color: #333333;">Tu mensaje:</strong>
                                <p style="color: #555555; margin: 10px 0 0 0; line-height: 1.6;">
                                    {{ $lead->message }}
                                </p>
                            </div>

                            <p style="color: #555555; line-height: 1.6; margin: 0 0 15px 0;">
                                Revisaremos tu solicitud y te responderemos lo antes posible.
                            </p>

                            <p style="color: #555555; line-height: 1.6; margin: 0 0 25px 0;">
                                Generalmente respondemos en menos de <strong>24 horas hábiles</strong>.
                            </p>

                            <!-- Información de contacto -->
                            <div style="background-color: #e3f2fd; padding: 20px; border-radius: 5px; margin: 20px 0;">
                                <strong style="color: #333333; font-size: 16px;">📧 Información de contacto:</strong>
                                <table width="100%" cellpadding="5" cellspacing="0" border="0" style="margin-top: 10px;">
                                    @if($settings->contact_email)
                                    <tr>
                                        <td style="color: #555555; padding: 5px 0;">
                                            ✉️ Email: <a href="mailto:{{ $settings->contact_email }}" style="color: #667eea; text-decoration: none;">{{ $settings->contact_email }}</a>
                                        </td>
                                    </tr>
                                    @endif
                                    @if($settings->contact_phone)
                                    <tr>
                                        <td style="color: #555555; padding: 5px 0;">
                                            📱 Teléfono: <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->contact_phone) }}" style="color: #667eea; text-decoration: none;">{{ $settings->contact_phone }}</a>
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>

                            <p style="color: #555555; line-height: 1.6; margin: 25px 0 20px 0;">
                                ¡Esperamos poder ayudarte pronto!
                            </p>

                            <p style="color: #333333; margin: 0;">
                                <strong>Atentamente,</strong><br>
                                {{ $settings->site_name ?? config('app.name') }}
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="background-color: #f8f9fa; padding: 20px; border-top: 1px solid #e0e0e0;">
                            <p style="color: #999999; font-size: 12px; margin: 0 0 5px 0;">
                                Este es un correo automático, por favor no respondas a este mensaje.
                            </p>
                            <p style="color: #999999; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} {{ $settings->site_name ?? config('app.name') }}. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
