@extends('landing.layout')

@section('title', 'Política de Privacidad')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Política de Privacidad</h1>
            <p class="text-sm text-gray-500 mb-8">Última actualización: {{ now()->format('d/m/Y') }}</p>

            <div class="prose prose-lg max-w-none space-y-6">
                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">1. Información que Recopilamos</h2>
                    <p class="text-gray-700 mb-3">
                        Recopilamos información que usted nos proporciona directamente cuando:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li>Crea una cuenta en nuestro sitio</li>
                        <li>Realiza una compra</li>
                        <li>Se suscribe a nuestro boletín</li>
                        <li>Nos contacta a través de formularios</li>
                        <li>Participa en encuestas o promociones</li>
                    </ul>
                    <p class="text-gray-700 mt-3">
                        Esta información puede incluir: nombre, dirección de correo electrónico, número de teléfono,
                        dirección de envío, información de pago e información demográfica.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">2. Cómo Utilizamos su Información</h2>
                    <p class="text-gray-700 mb-2">Utilizamos la información que recopilamos para:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li>Procesar y completar sus pedidos</li>
                        <li>Enviar productos digitales y físicos</li>
                        <li>Comunicarnos con usted sobre su pedido</li>
                        <li>Responder a sus preguntas y solicitudes</li>
                        <li>Enviar actualizaciones y ofertas promocionales (con su consentimiento)</li>
                        <li>Mejorar nuestros productos y servicios</li>
                        <li>Prevenir fraudes y proteger la seguridad</li>
                        <li>Cumplir con obligaciones legales</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">3. Compartir su Información</h2>
                    <p class="text-gray-700 mb-3">
                        No vendemos ni alquilamos su información personal a terceros. Podemos compartir
                        su información con:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-2 ml-4">
                        <li><strong>Proveedores de servicios:</strong> Empresas que nos ayudan a operar
                        nuestro negocio (procesamiento de pagos, envío, hosting)</li>
                        <li><strong>Cumplimiento legal:</strong> Cuando sea requerido por ley o para
                        proteger nuestros derechos</li>
                        <li><strong>Transferencias comerciales:</strong> En caso de fusión, adquisición
                        o venta de activos</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">4. Cookies y Tecnologías Similares</h2>
                    <p class="text-gray-700 mb-3">
                        Utilizamos cookies y tecnologías similares para:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li>Mantener su sesión activa</li>
                        <li>Recordar sus preferencias</li>
                        <li>Analizar el tráfico del sitio</li>
                        <li>Personalizar su experiencia</li>
                        <li>Mostrar anuncios relevantes</li>
                    </ul>
                    <p class="text-gray-700 mt-3">
                        Puede configurar su navegador para rechazar cookies, pero esto puede afectar
                        la funcionalidad del sitio.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">5. Seguridad de los Datos</h2>
                    <p class="text-gray-700">
                        Implementamos medidas de seguridad técnicas y organizativas para proteger
                        su información personal contra acceso no autorizado, pérdida, destrucción
                        o alteración. Sin embargo, ningún método de transmisión por Internet o
                        almacenamiento electrónico es 100% seguro.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">6. Retención de Datos</h2>
                    <p class="text-gray-700">
                        Conservamos su información personal durante el tiempo necesario para cumplir
                        con los fines descritos en esta política, a menos que la ley requiera un
                        período de retención más largo.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">7. Sus Derechos</h2>
                    <p class="text-gray-700 mb-2">De acuerdo con la legislación colombiana, usted tiene derecho a:</p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li><strong>Acceder:</strong> Solicitar una copia de su información personal</li>
                        <li><strong>Rectificar:</strong> Corregir información inexacta o incompleta</li>
                        <li><strong>Eliminar:</strong> Solicitar la eliminación de su información</li>
                        <li><strong>Limitar:</strong> Restringir el procesamiento de su información</li>
                        <li><strong>Oponerse:</strong> Objetar ciertos usos de su información</li>
                        <li><strong>Portabilidad:</strong> Recibir sus datos en formato estructurado</li>
                        <li><strong>Retirar consentimiento:</strong> En cualquier momento</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">8. Privacidad de Menores</h2>
                    <p class="text-gray-700">
                        Nuestro sitio no está dirigido a menores de 18 años. No recopilamos
                        intencionalmente información personal de menores. Si descubrimos que
                        hemos recopilado información de un menor, la eliminaremos inmediatamente.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">9. Enlaces a Otros Sitios</h2>
                    <p class="text-gray-700">
                        Nuestro sitio puede contener enlaces a sitios web de terceros. No somos
                        responsables de las prácticas de privacidad de estos sitios. Le recomendamos
                        leer sus políticas de privacidad.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">10. Cambios a esta Política</h2>
                    <p class="text-gray-700">
                        Podemos actualizar esta política periódicamente. Le notificaremos sobre
                        cambios significativos publicando la nueva política en esta página con
                        una fecha de actualización revisada.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">11. Transferencias Internacionales</h2>
                    <p class="text-gray-700">
                        Su información puede ser transferida y procesada en servidores ubicados
                        fuera de Colombia. Nos aseguramos de que estos terceros cumplan con
                        estándares de protección de datos adecuados.
                    </p>
                </section>

                <section class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">📧 Contacto para Asuntos de Privacidad</h2>
                    <p class="text-gray-700 mb-3">
                        Si tiene preguntas sobre esta Política de Privacidad o desea ejercer
                        sus derechos, puede contactarnos en:
                    </p>
                    <ul class="space-y-2 text-gray-700">
                        <li><strong>Email:</strong> privacidad@tuempresa.com</li>
                        <li><strong>Teléfono:</strong> +57 311 893 9652</li>
                        <li><strong>Dirección:</strong> Bogotá, Colombia</li>
                    </ul>
                    <p class="text-gray-700 mt-3">
                        Responderemos a su solicitud dentro de los 15 días hábiles siguientes
                        a su recepción.
                    </p>
                </section>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-200">
                <a href="{{ url()->previous() }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
