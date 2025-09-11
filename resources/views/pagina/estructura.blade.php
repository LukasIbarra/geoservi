@extends('layouts_pag.app')

@section('title', 'Estructuras Metálicas')

@section('content')
@include('layouts_pag.flotantes')
<!-- HERO DEL SERVICIO -->
<section class="relative min-h-[60vh] sm:min-h-[70vh] lg:min-h-[80vh] flex items-center justify-center overflow-hidden">
    <video autoplay muted loop playsinline class="absolute w-full h-full object-cover">
        <source src="/videos/02.mp4" type="video/mp4">
    </video>
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/60 to-black/80"></div>

    <div class="text-center text-white z-10 px-4 sm:px-6 max-w-4xl mx-auto" data-aos="fade-up">
        <span class="text-orange-400 tracking-widest text-xs sm:text-sm md:text-base uppercase block mb-2 sm:mb-4">SERVICIO ESPECIALIZADO</span>
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold mt-2 sm:mt-4 mb-4 sm:mb-6 leading-tight">
            Estructuras Metálicas
        </h1>
        <p class="text-base sm:text-lg md:text-xl text-gray-300 mb-6 sm:mb-8 max-w-2xl mx-auto leading-relaxed px-2">
            Diseño, fabricación e instalación de estructuras metálicas para la industria minera.
            Soluciones robustas y personalizadas que garantizan seguridad y durabilidad.
        </p>
        <a href="#contacto-servicio"
           class="inline-flex items-center px-6 sm:px-8 py-3 sm:py-4 bg-orange-500 hover:bg-orange-600 text-white rounded-full font-bold transition-all duration-300 group text-sm sm:text-base">
            Solicitar Cotización
            <i class="fas fa-chevron-down ml-2 group-hover:translate-y-1 transition-transform"></i>
        </a>
    </div>
</section>

<!-- INTRODUCCIÓN -->
<section class="py-12 sm:py-16 lg:py-20 bg-white relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 xl:gap-16 items-center">

            <div class="relative order-2 lg:order-1" data-aos="fade-right">
                <div class="relative z-10 rounded-2xl overflow-hidden shadow-xl">
                    <img src="/img-pag/servi3.jpg" alt="Trabajo en equipo" class="w-full h-auto">
                </div>
                <div class="absolute -bottom-3 sm:-bottom-6 -left-3 sm:-left-6 w-full h-full border-2 border-orange-400 rounded-2xl z-0"></div>
            </div>

            <div class="order-1 lg:order-2" data-aos="fade-left">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-zinc-800 mb-4 sm:mb-6 leading-tight">
                    Estructuras Metálicas de Alta Resistencia
                </h2>
                <p class="text-gray-600 mb-6 sm:mb-8 text-base sm:text-lg leading-relaxed">
                    Diseñamos y fabricamos estructuras metálicas robustas para la industria minera.
                    Nuestras soluciones garantizan estabilidad, seguridad y durabilidad en las condiciones más exigentes.
                </p>

                <ul class="space-y-3 sm:space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-3 sm:mr-4">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                                <i class="fas fa-check text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <span class="text-sm sm:text-base">Diseño estructural certificado</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-3 sm:mr-4">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                                <i class="fas fa-check text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <span class="text-sm sm:text-base">Fabricación con materiales premium</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-3 sm:mr-4">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center">
                                <i class="fas fa-check text-sm sm:text-base"></i>
                            </div>
                        </div>
                        <span class="text-sm sm:text-base">Instalación profesional in situ</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- GALERÍA DEL PROCESO -->
<section class="py-12 sm:py-16 lg:py-20 bg-zinc-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl font-bold text-zinc-800 mb-8 sm:mb-12" data-aos="fade-up">
            Nuestro Proceso en Imágenes
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" data-aos="fade-up" data-aos-delay="100">
            @foreach(['/img/servicios/maquina.jpg','/img/servicios/estructura.jpg','/img/servicios/geomembrana.jpg'] as $img)
            <div class="overflow-hidden rounded-xl shadow-lg group">
                <img src="{{ $img }}" alt="Proceso" class="w-full h-48 sm:h-56 lg:h-64 object-cover transform group-hover:scale-110 transition-transform duration-700">
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- GALERÍA DE VIDEOS -->
<section class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl font-bold text-zinc-800 mb-8 sm:mb-12" data-aos="fade-up">
            Nuestros Trabajos en Video
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8" data-aos="fade-up" data-aos-delay="100">
            @foreach([
                ['video'=>'05.mp4', 'title'=>'Fabricación de Estructuras', 'desc'=>'Proceso de fabricación de estructuras metálicas personalizadas'],
                ['video'=>'06.mp4', 'title'=>'Instalación en Sitio', 'desc'=>'Montaje profesional de estructuras en faenas mineras'],
                ['video'=>'07.mp4', 'title'=>'Control de Calidad', 'desc'=>'Verificación y certificación de estructuras terminadas']
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
                <div class="p-4 sm:p-6">
                    <h3 class="font-bold text-base sm:text-lg text-zinc-800 mb-2">{{ $video['title'] }}</h3>
                    <p class="text-gray-600 text-sm">{{ $video['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- NUESTRO PROCESO -->
<section class="py-12 sm:py-16 lg:py-20 bg-gradient-to-b from-zinc-900 to-zinc-800 text-white relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl font-bold mb-8 sm:mb-12 lg:mb-16" data-aos="fade-up">
            Cómo Trabajamos
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 lg:gap-10">
            @foreach([
                ['icon'=>'fas fa-search','title'=>'Evaluación','text'=>'Analizamos sus necesidades y estado de los equipos.'],
                ['icon'=>'fas fa-pencil-ruler','title'=>'Diseño','text'=>'Definimos la mejor solución técnica.'],
                ['icon'=>'fas fa-cogs','title'=>'Ejecución','text'=>'Implementamos con equipos especializados.'],
                ['icon'=>'fas fa-clipboard-check','title'=>'Entrega','text'=>'Verificación y entrega final.']
            ] as $step)
            <div class="text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index*100 }}">
                <div class="w-12 h-12 sm:w-14 sm:h-14 lg:w-16 lg:h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                    <i class="{{ $step['icon'] }} text-lg sm:text-xl lg:text-2xl"></i>
                </div>
                <h3 class="font-bold text-base sm:text-lg lg:text-xl mb-2">{{ $step['title'] }}</h3>
                <p class="text-gray-300 text-sm sm:text-base leading-relaxed">{{ $step['text'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- FAQ -->
<section class="py-12 sm:py-16 lg:py-20 bg-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-center text-2xl sm:text-3xl lg:text-4xl font-bold text-zinc-800 mb-8 sm:mb-12" data-aos="fade-up">
            Preguntas Frecuentes
        </h2>
        <div class="max-w-4xl mx-auto space-y-4 sm:space-y-6" data-aos="fade-up" data-aos-delay="100">
            @foreach([
                ['q'=>'¿Qué tipos de estructuras fabrican?','a'=>'Fabricamos estructuras para tolvas, plataformas, soportes, galpones y soluciones personalizadas para minería.'],
                ['q'=>'¿Cumplen con normas de seguridad?','a'=>'Todas nuestras estructuras cumplen con las normativas chilenas e internacionales de seguridad estructural.'],
                ['q'=>'¿Ofrecen garantía en sus trabajos?','a'=>'Sí, ofrecemos garantía completa en materiales y mano de obra por el período establecido.']
            ] as $faq)
            <div class="border border-gray-200 rounded-lg p-4 sm:p-6 hover:shadow-lg transition">
                <h3 class="font-semibold text-base sm:text-lg mb-2 text-orange-500">{{ $faq['q'] }}</h3>
                <p class="text-gray-600 text-sm sm:text-base leading-relaxed">{{ $faq['a'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section id="contacto-servicio" class="py-12 sm:py-16 lg:py-20 bg-gradient-to-r from-orange-500 to-orange-600 text-white text-center relative">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-4 sm:mb-6">¿Necesita estructuras metálicas confiables?</h2>
        <p class="mb-6 sm:mb-8 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">Solicite su cotización personalizada y obtenga soluciones estructurales de alta calidad.</p>
        <form class="max-w-2xl mx-auto">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-4">
                <input type="text" placeholder="Nombre" class="px-4 py-3 rounded-lg text-gray-800 text-sm sm:text-base" required>
                <input type="email" placeholder="Correo" class="px-4 py-3 rounded-lg text-gray-800 text-sm sm:text-base" required>
            </div>
            <textarea placeholder="Detalles del servicio" rows="3" class="w-full px-4 py-3 rounded-lg text-gray-800 text-sm sm:text-base mb-4"></textarea>
            <button type="submit" class="w-full sm:w-auto bg-zinc-900 hover:bg-zinc-800 px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-bold transition text-sm sm:text-base">
                Enviar Solicitud
            </button>
        </form>
    </div>
</section>

@endsection


    