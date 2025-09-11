@extends('layouts_pag.app')

@section('title', 'Geomembranas')

@section('content')
@include('layouts_pag.flotantes')
<!-- HERO DEL SERVICIO -->
<section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden">
    <video autoplay muted loop playsinline class="absolute w-full h-full object-cover">
        <source src="/videos/04.mp4" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-black/80"></div>

    <div class="text-center text-white z-10 px-6 max-w-4xl" data-aos="fade-up">
        <span class="text-orange-400 tracking-widest text-sm md:text-base">SERVICIO ESPECIALIZADO</span>
        <h1 class="text-4xl md:text-6xl font-extrabold mt-4 mb-6">
            Equipos Industriales
        </h1>
        <p class="text-lg text-gray-300 mb-8">
            Mantenimiento, reparación y fabricación de piezas para equipos mineros e industriales,
            con tecnología avanzada y personal altamente calificado.
        </p>
        <a href="#contacto-servicio" 
           class="inline-flex items-center px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-full font-bold transition-all duration-300 group">
            Solicitar Cotización
            <i class="fas fa-chevron-down ml-2 group-hover:translate-y-1 transition-transform"></i>
        </a>
    </div>
</section>

<!-- INTRODUCCIÓN -->
<section class="py-20 bg-white relative">
    <div class="container mx-auto px-4 grid lg:grid-cols-2 gap-16 items-center">
        
        <div class="relative" data-aos="fade-right">
            <div class="relative z-10 rounded-2xl overflow-hidden shadow-xl">
                <img src="/img-pag/servi1.jpg" alt="Trabajo en equipo" class="w-full h-auto">
            </div>
            <div class="absolute -bottom-6 -left-6 w-full h-full border-2 border-orange-400 rounded-2xl z-0"></div>
        </div>
        
        <div data-aos="fade-left">
            <h2 class="text-3xl font-bold text-zinc-800 mb-6">
                Innovación y Precisión para la Industria
            </h2>
            <p class="text-gray-600 mb-8">
                En Geoservi ofrecemos soluciones personalizadas para maximizar la eficiencia de sus equipos.
                Desde mantenimientos preventivos hasta reparaciones críticas, trabajamos con altos estándares de calidad.
            </p>

            <ul class="space-y-4">
                <li class="flex items-start">
                    <div class="flex-shrink-0 mt-1 mr-4">
                        <div class="w-8 h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <span>Diagnóstico técnico avanzado</span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 mt-1 mr-4">
                        <div class="w-8 h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <span>Fabricación de piezas a medida</span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 mt-1 mr-4">
                        <div class="w-8 h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                            <i class="fas fa-check"></i>
                        </div>
                    </div>
                    <span>Mantenimiento preventivo y correctivo</span>
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- GALERÍA DEL PROCESO -->
<section class="py-20 bg-zinc-50">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-bold text-zinc-800 mb-12" data-aos="fade-up">
            Nuestro Proceso en Imágenes
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
            @foreach(['/img/servicios/maquina.jpg','/img/servicios/estructura.jpg','/img/servicios/geomembrana.jpg'] as $img)
            <div class="overflow-hidden rounded-xl shadow-lg group">
                <img src="{{ $img }}" alt="Proceso" class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- GALERÍA DE VIDEOS -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-bold text-zinc-800 mb-12" data-aos="fade-up">
            Nuestros Trabajos en Video
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" data-aos="fade-up" data-aos-delay="100">
            @foreach([
                ['video'=>'05.mp4', 'title'=>'Mantenimiento Industrial', 'desc'=>'Procesos de mantenimiento y reparación de equipos industriales'],
                ['video'=>'06.mp4', 'title'=>'Fabricación de Piezas', 'desc'=>'Creación de componentes personalizados para maquinaria pesada'],
                ['video'=>'07.mp4', 'title'=>'Diagnóstico Técnico', 'desc'=>'Análisis avanzado y control de calidad de equipos']
            ] as $video)
            <div class="bg-zinc-50 rounded-xl overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
                <div class="relative">
                    <video class="w-full h-48 object-cover" autoplay muted loop playsinline>
                        <source src="/videos/{{ $video['video'] }}" type="video/mp4">
                    </video>
                    <div class="absolute inset-0 bg-black/20 flex items-center justify-center">
                        <button class="bg-orange-500 hover:bg-orange-600 text-white p-3 rounded-full transition-colors duration-300">
                            <i class="fas fa-play text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg text-zinc-800 mb-2">{{ $video['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $video['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NUESTRO PROCESO -->
<section class="py-20 bg-gradient-to-b from-zinc-900 to-zinc-800 text-white relative">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-bold mb-16" data-aos="fade-up">
            Cómo Trabajamos
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            @foreach([
                ['icon'=>'fas fa-search','title'=>'Evaluación','text'=>'Analizamos sus necesidades y estado de los equipos.'],
                ['icon'=>'fas fa-pencil-ruler','title'=>'Diseño','text'=>'Definimos la mejor solución técnica.'],
                ['icon'=>'fas fa-cogs','title'=>'Ejecución','text'=>'Implementamos con equipos especializados.'],
                ['icon'=>'fas fa-clipboard-check','title'=>'Entrega','text'=>'Verificación y entrega final.']
            ] as $step)
            <div class="text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index*100 }}">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $step['icon'] }} text-2xl"></i>
                </div>
                <h3 class="font-bold text-lg mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-300">{{ $step['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-center text-3xl font-bold text-zinc-800 mb-12" data-aos="fade-up">
            Preguntas Frecuentes
        </h2>
        <div class="max-w-3xl mx-auto space-y-6" data-aos="fade-up" data-aos-delay="100">
            @foreach([
                ['q'=>'¿Trabajan en todo Chile?','a'=>'Sí, ofrecemos servicios en todas las regiones, adaptándonos a las necesidades de cada cliente.'],
                ['q'=>'¿Pueden fabricar piezas personalizadas?','a'=>'Sí, contamos con taller propio y maquinaria para producción a medida.'],
                ['q'=>'¿Qué tiempo de respuesta tienen?','a'=>'Generalmente respondemos en menos de 24 horas para coordinar asistencia.']
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
        <h2 class="text-3xl font-bold mb-4">¿Listo para optimizar sus equipos?</h2>
        <p class="mb-8">Complete el formulario y nos pondremos en contacto en menos de 24 horas.</p>
        <form class="max-w-2xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="text" placeholder="Nombre" class="px-4 py-3 rounded-lg text-gray-800" required>
            <input type="email" placeholder="Correo" class="px-4 py-3 rounded-lg text-gray-800" required>
            <textarea placeholder="Detalles del servicio" rows="3" class="md:col-span-2 px-4 py-3 rounded-lg text-gray-800"></textarea>
            <button type="submit" class="md:col-span-2 bg-zinc-900 hover:bg-zinc-800 px-6 py-3 rounded-lg font-bold transition">
                Enviar Solicitud
            </button>
        </form>
    </div>
</section>

@endsection
