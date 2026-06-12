<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soporte y Contacto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-100 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-3xl bg-white rounded-3xl shadow-2xl border border-gray-200 overflow-hidden">
        <div class="bg-blue-700 px-6 py-8 text-white text-center">
            <img src="{{ asset('backend/dist/img/image_login.jpeg') }}"
                 alt="Logo del sistema"
                 class="mx-auto h-16 w-auto sm:h-20 object-contain mb-4">
            <h1 class="text-2xl sm:text-3xl font-bold">Soporte y contacto</h1>
            <p class="mt-2 text-blue-100">Estamos aquí para ayudarte con cualquier duda o problema del sistema.</p>
        </div>

        <div class="grid gap-6 p-6 sm:p-8 md:grid-cols-2">
            <section class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <h2 class="text-lg font-semibold text-gray-900">¿Necesitas ayuda?</h2>
                <p class="mt-2 text-gray-600">Puedes comunicarte con el área de soporte para asistencia técnica, acceso o consultas del sistema.</p>
                <ul class="mt-4 space-y-2 text-sm text-gray-700">
                    <li>• Atención durante el horario laboral</li>
                    <li>• Soporte para usuarios y permisos</li>
                    <li>• Ayuda para uso del módulo de compras</li>
                </ul>
            </section>

            <section class="rounded-2xl border border-gray-200 bg-gray-50 p-5">
                <h2 class="text-lg font-semibold text-gray-900">Canales de contacto</h2>
                <div class="mt-4 space-y-3 text-sm text-gray-700">
                    <a href="mailto:soporte@sistema.com" class="block rounded-xl border border-blue-200 bg-white p-3 hover:border-blue-400 hover:bg-blue-50 transition">📧 soporte@sistema.com</a>
                    <a href="tel:+51999999999" class="block rounded-xl border border-blue-200 bg-white p-3 hover:border-blue-400 hover:bg-blue-50 transition">📞 +51 999 999 999</a>
                    <a href="{{ url('/') }}" class="block rounded-xl border border-blue-200 bg-white p-3 hover:border-blue-400 hover:bg-blue-50 transition">🏠 Volver a la bienvenida</a>
                </div>
            </section>
        </div>

        <div class="px-6 pb-6 text-center text-sm text-gray-500">
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Iniciar sesión</a>
            <span class="mx-2">|</span>
            <a href="{{ route('register') }}" class="text-green-600 hover:underline font-medium">Registrarse</a>
        </div>
    </div>
</body>
</html>
