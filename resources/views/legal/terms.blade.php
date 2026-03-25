@extends('landing.layout')

@section('title', 'Términos y Condiciones')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Términos y Condiciones</h1>
            <p class="text-sm text-gray-500 mb-8">Última actualización: {{ now()->format('d/m/Y') }}</p>

            <div class="prose prose-lg max-w-none space-y-6">
                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">1. Aceptación de los Términos</h2>
                    <p class="text-gray-700">
                        Al acceder y utilizar este sitio web, usted acepta cumplir con estos términos y condiciones de uso.
                        Si no está de acuerdo con alguna parte de estos términos, no debe utilizar nuestro sitio web.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">2. Uso del Sitio</h2>
                    <p class="text-gray-700 mb-2">
                        El contenido de este sitio web es solo para su información general y uso personal.
                        Está sujeto a cambios sin previo aviso.
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li>No debe reproducir, duplicar o copiar contenido sin permiso</li>
                        <li>No debe realizar actividades ilegales o no autorizadas</li>
                        <li>Debe mantener la confidencialidad de su cuenta</li>
                        <li>Debe proporcionar información precisa y actualizada</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">3. Productos y Servicios</h2>
                    <p class="text-gray-700 mb-3">
                        <strong>Productos Digitales:</strong> Los productos digitales (ebooks, cursos) se entregan
                        inmediatamente después de la confirmación del pago mediante un enlace de descarga enviado
                        a su correo electrónico.
                    </p>
                    <p class="text-gray-700 mb-3">
                        <strong>Productos Físicos:</strong> Los productos físicos se envían a la dirección proporcionada.
                        Los tiempos de entrega varían según la ubicación (3-7 días hábiles).
                    </p>
                    <p class="text-gray-700">
                        <strong>Servicios:</strong> Los servicios se coordinarán directamente con el cliente
                        después de la confirmación del pago.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">4. Precios y Pagos</h2>
                    <p class="text-gray-700 mb-2">
                        Todos los precios están expresados en Pesos Colombianos (COP) e incluyen IVA cuando aplique.
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li>Los precios pueden cambiar sin previo aviso</li>
                        <li>Aceptamos múltiples métodos de pago (Bre-b, Transferencia, QR, Tarjeta)</li>
                        <li>Los pagos deben ser verificados antes de procesar el pedido</li>
                        <li>Para productos digitales, el acceso se otorga tras confirmar el pago</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">5. Política de Devoluciones</h2>
                    <p class="text-gray-700 mb-3">
                        <strong>Productos Físicos:</strong> Tiene 15 días desde la recepción para solicitar
                        una devolución si el producto está defectuoso o no corresponde con lo ordenado.
                        El producto debe estar sin usar y en su empaque original.
                    </p>
                    <p class="text-gray-700 mb-3">
                        <strong>Productos Digitales:</strong> Debido a la naturaleza de los productos digitales,
                        no se aceptan devoluciones una vez que el acceso ha sido entregado, excepto en casos
                        de errores técnicos comprobables.
                    </p>
                    <p class="text-gray-700">
                        <strong>Servicios:</strong> Las cancelaciones deben realizarse con al menos 48 horas
                        de anticipación para recibir un reembolso completo.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">6. Propiedad Intelectual</h2>
                    <p class="text-gray-700">
                        Todo el contenido de este sitio web, incluyendo textos, imágenes, logotipos, gráficos,
                        videos y software, está protegido por derechos de autor y otras leyes de propiedad
                        intelectual. No puede reproducir, distribuir o modificar ningún contenido sin
                        autorización previa por escrito.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">7. Limitación de Responsabilidad</h2>
                    <p class="text-gray-700 mb-2">
                        No seremos responsables por ningún daño directo, indirecto, incidental,
                        especial o consecuente que resulte de:
                    </p>
                    <ul class="list-disc list-inside text-gray-700 space-y-1 ml-4">
                        <li>El uso o la imposibilidad de usar nuestro sitio web</li>
                        <li>Errores u omisiones en el contenido</li>
                        <li>Interrupciones del servicio</li>
                        <li>Pérdida de datos o información</li>
                    </ul>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">8. Enlaces a Terceros</h2>
                    <p class="text-gray-700">
                        Nuestro sitio puede contener enlaces a sitios web de terceros. No tenemos control
                        sobre el contenido y las prácticas de estos sitios y no aceptamos ninguna
                        responsabilidad por ellos.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">9. Modificaciones</h2>
                    <p class="text-gray-700">
                        Nos reservamos el derecho de modificar estos términos en cualquier momento.
                        Las modificaciones entrarán en vigor inmediatamente después de su publicación
                        en el sitio web. Su uso continuado del sitio constituye la aceptación de los
                        términos modificados.
                    </p>
                </section>

                <section>
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">10. Ley Aplicable</h2>
                    <p class="text-gray-700">
                        Estos términos se regirán e interpretarán de acuerdo con las leyes de la
                        República de Colombia. Cualquier disputa relacionada con estos términos
                        estará sujeta a la jurisdicción exclusiva de los tribunales colombianos.
                    </p>
                </section>

                <section class="bg-blue-50 p-6 rounded-lg border border-blue-200">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">📧 Contacto</h2>
                    <p class="text-gray-700">
                        Si tiene alguna pregunta sobre estos Términos y Condiciones, puede contactarnos en:
                    </p>
                    <ul class="mt-3 space-y-2 text-gray-700">
                        <li><strong>Email:</strong> info@tuempresa.com</li>
                        <li><strong>Teléfono:</strong> +57 311 893 9652</li>
                        <li><strong>Dirección:</strong> Bogotá, Colombia</li>
                    </ul>
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
