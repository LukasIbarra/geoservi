@extends('layouts_pag.app')

@section('title', 'Software de Gestión Minera')

@section('content')
@include('layouts_pag.flotantes')
<!-- HERO DEL SERVICIO -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden">
    <img src="/img/servicios/erp.jpg" alt="Software de Gestión Minera"
         class="absolute w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-black/80"></div>

    <div class="text-center text-white z-10 px-6 max-w-4xl" data-aos="fade-up">
        <span class="text-orange-400 tracking-widest text-sm md:text-base">SOFTWARE DE GESTIÓN</span>
        <h1 class="text-4xl md:text-6xl font-extrabold mt-4 mb-6">
            Sistema Integral de Gestión Minera
        </h1>
        <p class="text-lg text-gray-300 mb-8">
            Tecnología avanzada para optimizar operaciones mineras, controlar equipos y maximizar la eficiencia
            en tiempo real desde cualquier dispositivo.
        </p>
        <a href="#contacto-servicio"
           class="inline-flex items-center px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-full font-bold transition-all duration-300 group">
            Solicitar Demo
            <i class="fas fa-chevron-down ml-2 group-hover:translate-y-1 transition-transform"></i>
        </a>
    </div>
</section>

<!-- INTRODUCCIÓN -->
<section class="py-20 bg-white relative">
    <div class="container mx-auto px-4 grid lg:grid-cols-2 gap-16 items-center">

        <div class="relative" data-aos="fade-right">
            <div class="relative z-10 rounded-2xl overflow-hidden shadow-xl">
                <img src="{{ asset('/img/servicios/servi6.jpg') }}" alt="Sistema de Gestión Digital" class="w-full h-auto">
            </div>
            <div class="absolute -bottom-6 -left-6 w-full h-full border-2 border-orange-400 rounded-2xl z-0"></div>
        </div>

        <div data-aos="fade-left">
            <h2 class="text-3xl font-bold text-zinc-800 mb-6">
                Tecnología que Transforma la Minería
            </h2>
            <p class="text-gray-600 mb-8">
                Nuestro software de gestión integral está diseñado específicamente para el sector minero,
                permitiendo controlar y optimizar todos los procesos operativos desde una única plataforma digital.
            </p>

            <ul class="space-y-4">
                <li class="flex items-start">
                    <div class="flex-shrink-0 mt-1 mr-4">
                        <div class="w-8 h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <span>Dashboard en tiempo real con métricas clave</span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 mt-1 mr-4">
                        <div class="w-8 h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <span>Gestión completa de flota y mantenimientos</span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 mt-1 mr-4">
                        <div class="w-8 h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <span>Reportes automáticos y análisis predictivo</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- MÓDULOS DEL SISTEMA -->
<section class="py-20 bg-zinc-50">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-bold text-zinc-800 mb-12" data-aos="fade-up">
            Módulos del Sistema
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up">
            <!-- Módulo 1 -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-cogs text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 mb-3 text-center">Gestión de Equipos</h3>
                <p class="text-gray-600 text-center mb-4">
                    Control total de maquinaria, mantenimientos preventivos y seguimiento de rendimiento.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Registro de equipos y especificaciones</li>
                    <li>• Programación de mantenimientos</li>
                    <li>• Seguimiento de horas de uso</li>
                    <li>• Alertas de mantenimiento</li>
                </ul>
            </div>

            <!-- Módulo 2 -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-users text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 mb-3 text-center">Gestión de Personal</h3>
                <p class="text-gray-600 text-center mb-4">
                    Administración de equipos de trabajo, asignaciones y control de productividad.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Perfiles de empleados</li>
                    <li>• Asignación de tareas</li>
                    <li>• Control de asistencia</li>
                    <li>• Reportes de productividad</li>
                </ul>
            </div>

            <!-- Módulo 3 -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-chart-line text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 mb-3 text-center">Análisis y Reportes</h3>
                <p class="text-gray-600 text-center mb-4">
                    Información en tiempo real y reportes personalizados para toma de decisiones.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Dashboards interactivos</li>
                    <li>• KPIs en tiempo real</li>
                    <li>• Reportes automáticos</li>
                    <li>• Análisis predictivo</li>
                </ul>
            </div>

            <!-- Módulo 4 -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 mb-3 text-center">Seguridad Industrial</h3>
                <p class="text-gray-600 text-center mb-4">
                    Monitoreo de protocolos de seguridad y gestión de incidentes.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Registro de incidentes</li>
                    <li>• Checklist de seguridad</li>
                    <li>• Capacitaciones</li>
                    <li>• Alertas de seguridad</li>
                </ul>
            </div>

            <!-- Módulo 5 -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-truck text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 mb-3 text-center">Logística y Abastecimiento</h3>
                <p class="text-gray-600 text-center mb-4">
                    Control de inventarios, pedidos y cadena de suministro.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• Gestión de inventarios</li>
                    <li>• Órdenes de compra</li>
                    <li>• Proveedores</li>
                    <li>• Control de stock</li>
                </ul>
            </div>

            <!-- Módulo 6 -->
            <div class="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-mobile-alt text-2xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-zinc-800 mb-3 text-center">Acceso Móvil</h3>
                <p class="text-gray-600 text-center mb-4">
                    Aplicación móvil para acceso remoto y gestión en campo.
                </p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• App iOS y Android</li>
                    <li>• Sincronización offline</li>
                    <li>• Notificaciones push</li>
                    <li>• GPS tracking</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- BENEFICIOS -->
<section class="py-20 bg-gradient-to-b from-zinc-900 to-zinc-800 text-white relative">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-bold mb-16" data-aos="fade-up">
            Beneficios del Sistema
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            @foreach([
                ['icon'=>'fas fa-clock','title'=>'Tiempo Real','text'=>'Información actualizada al instante'],
                ['icon'=>'fas fa-dollar-sign','title'=>'Reducción de Costos','text'=>'Optimización de recursos y eficiencia'],
                ['icon'=>'fas fa-chart-pie','title'=>'Mejor Toma de Decisiones','text'=>'Datos precisos para análisis'],
                ['icon'=>'fas fa-users-cog','title'=>'Mayor Productividad','text'=>'Automatización de procesos']
            ] as $benefit)
            <div class="text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index*100 }}">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $benefit['icon'] }} text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">{{ $benefit['title'] }}</h3>
                <p class="text-gray-300">{{ $benefit['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- DEMO INTERACTIVA -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-zinc-800 mb-4">Conoce Nuestro Sistema</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Descubre cómo funciona nuestro software a través de esta demostración interactiva
            </p>
        </div>

        <div class="max-w-4xl mx-auto" data-aos="fade-up">
            <div class="bg-zinc-100 rounded-xl p-8 text-center">
                <div class="w-24 h-24 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-play text-3xl text-white"></i>
                </div>
                <h3 class="text-2xl font-bold text-zinc-800 mb-4">Demo Interactiva Disponible</h3>
                <p class="text-gray-600 mb-6">
                    Solicita una demostración personalizada y descubre todas las funcionalidades de nuestro sistema.
                </p>
                <button onclick="openContactModal()" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-lg font-bold transition duration-300">
                    <i class="fas fa-play-circle mr-2"></i> Solicitar Demo
                </button>
            </div>
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-20 bg-zinc-50">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-bold text-zinc-800 mb-12" data-aos="fade-up">
            Preguntas Frecuentes
        </h2>
        <div class="max-w-3xl mx-auto space-y-6" data-aos="fade-up" data-aos-delay="100">
            @foreach([
                ['q'=>'¿Es compatible con nuestros sistemas actuales?','a'=>'Sí, nuestro software se integra perfectamente con la mayoría de los sistemas existentes y ofrece APIs abiertas para conexiones personalizadas.'],
                ['q'=>'¿Qué tiempo toma la implementación?','a'=>'El proceso de implementación varía según la complejidad, pero generalmente toma entre 2-4 semanas para una instalación completa.'],
                ['q'=>'¿Ofrecen capacitación al personal?','a'=>'Sí, incluimos capacitación completa para administradores y usuarios finales, además de soporte técnico continuo.'],
                ['q'=>'¿Es seguro el almacenamiento de datos?','a'=>'Utilizamos encriptación de nivel empresarial y cumplimos con las normativas de protección de datos más estrictas.']
            ] as $faq)
            <div class="border border-gray-200 rounded-lg p-6 hover:shadow-lg transition">
                <h3 class="font-semibold text-lg mb-2 text-orange-500">{{ $faq['q'] }}</h3>
                <p class="text-gray-600">{{ $faq['a'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section id="contacto-servicio" class="py-20 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center relative">
    <div class="container mx-auto px-4 relative z-10">
        <h2 class="text-3xl font-bold mb-4">¿Listo para digitalizar tus operaciones?</h2>
        <p class="mb-8">Complete el formulario y nos pondremos en contacto en menos de 24 horas.</p>
        <form class="max-w-2xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" placeholder="Nombre" class="px-4 py-3 rounded-lg text-gray-800" required>
            <input type="email" placeholder="Correo" class="px-4 py-3 rounded-lg text-gray-800" required>
            <textarea placeholder="Detalles del proyecto" rows="3" class="md:col-span-2 px-4 py-3 rounded-lg text-gray-800"></textarea>
            <button type="submit" class="md:col-span-2 bg-zinc-900 hover:bg-zinc-800 px-6 py-3 rounded-lg font-bold transition">
                Enviar Solicitud
            </button>
        </form>
    </div>
</section>

@endsection
