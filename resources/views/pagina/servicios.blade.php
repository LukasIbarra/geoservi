@extends('layouts_pag.app')

@section('title', 'Servicios - Geoservi Minería')

@section('content')

<!-- Hero Servicios con Video de Fondo -->
<section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden">
    <!-- Video de fondo -->
    <video autoplay loop muted playsinline class="absolute z-0 w-full h-full object-cover">
        <source src="{{ asset('videos/hero-servicios.mp4') }}" type="video/mp4">
        <!-- Fallback imagen -->
        <img src="{{ asset('img-pag/conten2.jpg') }}" alt="Servicios mineros" class="absolute w-full h-full object-cover">
    </video>
    
    <!-- Overlay oscuro con gradiente -->
    <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-black/50 to-black/80 z-1"></div>
    
    <!-- Contenido hero -->
    <div class="text-center px-4 z-10 max-w-5xl mx-auto" data-aos="fade-up">
        <span class="text-orange-400 font-semibold tracking-[0.2em] text-sm md:text-base mb-4 inline-block">NUESTROS SERVICIOS</span>
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-gray-200 to-white">
            Excelencia Técnica <br>en Minería e Industria
        </h1>
        <p class="text-xl text-gray-300 max-w-3xl mx-auto mb-8">
            Soluciones integrales con tecnología de punta y personal altamente calificado para maximizar su productividad.
        </p>
        <a href="#servicios" class="inline-flex items-center px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-full font-bold transition-all duration-300 group">
            Explorar Servicios
            <i class="fas fa-chevron-down ml-2 group-hover:translate-y-1 transition-transform"></i>
        </a>
    </div>
    
    <!-- Separador SVG inferior -->
    <div class="absolute -bottom-[1px] left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-full h-20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-white"></path>
        </svg>
    </div>
</section>

<!-- Introducción Impactante -->
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Imagen con efecto 3D -->
            <div class="relative" data-aos="fade-right">
                <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('img-pag/conten2.jpg') }}" alt="Equipo minero" class="w-full h-auto">
                </div>
                <div class="absolute -bottom-6 -left-6 w-full h-full border-2 border-orange-400 rounded-2xl z-0" data-aos="fade-right" data-aos-delay="200"></div>
                
                <!-- Badge de experiencia -->
                <div class="absolute -top-6 -right-6 bg-zinc-900 text-white px-6 py-3 rounded-full shadow-xl z-20" data-aos="fade-left" data-aos-delay="300">
                    <div class="flex items-center">
                        <span class="text-orange-400 font-bold text-3xl mr-2">15+</span>
                        <span class="text-sm">Años de<br>Experiencia</span>
                    </div>
                </div>
            </div>
            
            <!-- Contenido -->
            <div data-aos="fade-left">
                <h2 class="text-4xl font-bold text-zinc-800 mb-6">Innovación y Precisión en Cada Proyecto</h2>
                <p class="text-lg text-gray-600 mb-8">
                    En Geoservi combinamos tecnología avanzada con conocimiento especializado para ofrecer soluciones que superan las expectativas del sector minero e industrial.
                </p>
                
                <!-- Lista de ventajas -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/10 text-orange-500">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <span class="text-gray-700 font-medium">Equipos de última generación</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/10 text-orange-500">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <span class="text-gray-700 font-medium">Personal certificado y especializado</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/10 text-orange-500">
                                <i class="fas fa-check"></i>
                            </div>
                        </div>
                        <span class="text-gray-700 font-medium">Protocolos de seguridad estrictos</span>
                    </li>
                </ul>
                
                <a href="#servicios" class="inline-flex items-center text-orange-500 font-semibold hover:text-orange-600 group">
                    Ver nuestros servicios
                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Servicios Destacados -->
<section id="servicios" class="py-24 bg-zinc-50 relative overflow-hidden">
    <div class="absolute -top-[1px] left-0 w-full overflow-hidden leading-[0] transform rotate-180">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-white"></path>
        </svg>
    </div>
    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 w-full h-full opacity-5">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-orange-500 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-64 h-64 bg-orange-500 rounded-full blur-[120px]"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <!-- Encabezado -->
        <div class="text-center mb-20" data-aos="fade-up">
            <span class="text-orange-400 font-semibold tracking-widest">NUESTROS SERVICIOS</span>
            <h2 class="text-4xl font-bold text-zinc-800 mt-3 mb-4">Soluciones Especializadas</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-orange-300 mx-auto rounded-full"></div>
        </div>
        
        <!-- Servicios - Diseño innovador -->
        <div class="grid grid-cols-1 gap-16">
            @foreach([
                [
                    'title' => 'Equipos Industriales',
                    'tagline' => 'Mantenimiento y Fabricación',
                    'description' => 'Servicios integrales para equipos mineros e industriales, desde reparaciones urgentes hasta fabricación de piezas personalizadas con los más altos estándares de calidad.',
                    'image' => asset('img/servicios/maquina.jpg'),
                    'features' => [
                        'Reparación de partes y piezas',
                        'Fabricación personalizada',
                        'Mantenimiento preventivo',
                        'Diagnóstico técnico avanzado'
                    ],
                    'link' => url('/servicios/equipos')
                ],
                [
                    'title' => 'Estructuras Metálicas',
                    'tagline' => 'Diseño y Construcción',
                    'description' => 'Fabricación de estructuras metálicas resistentes y duraderas para la industria minera, diseñadas para soportar las condiciones más exigentes.',
                    'image' => asset('img/servicios/estructura1.jpg'),
                    'features' => [
                        'Diseño ingenieril',
                        'Materiales de primera calidad',
                        'Resistencia estructural',
                        'Montaje in situ'
                    ],
                    'link' => url('/servicios/estructuras')
                ],
                [
                    'title' => 'Geomembranas HDPE',
                    'tagline' => 'Instalación Profesional',
                    'description' => 'Instalación y soldadura de geomembranas y tuberías con tecnología de punta, garantizando estanqueidad y durabilidad en sus proyectos.',
                    'image' => asset('img/servicios/geomembrana.jpg'),
                    'features' => [
                        'Instalación certificada',
                        'Soldadura de alta precisión',
                        'Control de calidad estricto',
                        'Soluciones a medida'
                    ],
                    'link' => url('/servicios/geomembranas')
                ],
                [
                    'title' => 'Cilindros Hidráulicos',
                    'tagline' => 'Reparación y Fabricación',
                    'description' => 'Reparación, mantenimiento y fabricación de cilindros hidráulicos con garantía de calidad, asegurando el óptimo funcionamiento de sus equipos.',
                    'image' => asset('img/servicios/cilindro1.jpg'),
                    'features' => [
                        'Reparación integral',
                        'Fabricación a medida',
                        'Pruebas de presión y calidad',
                        'Asesoría técnica especializada'
                    ],
                    'link' => url('/servicios/cilindros')
                ]
            ] as $service)
            <div class="group relative rounded-3xl overflow-hidden shadow-2xl bg-white" data-aos="fade-up">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <!-- Imagen con efecto -->
                    <div class="relative h-96 lg:h-auto overflow-hidden">
                        <img src="{{ $service['image'] }}" alt="{{ $service['title'] }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-[10000ms] ease-linear group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>
                        <!-- Badge flotante -->
                        <div class="absolute top-6 left-6 bg-orange-500 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg">
                            {{ $service['tagline'] }}
                        </div>
                    </div>
                    
                    <!-- Contenido -->
                    <div class="p-10 flex flex-col justify-center">
                        <h3 class="text-3xl font-bold text-zinc-800 mb-4">{{ $service['title'] }}</h3>
                        <p class="text-gray-600 mb-6">{{ $service['description'] }}</p>
                        
                        <!-- Lista de características -->
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8">
                            @foreach($service['features'] as $feature)
                            <li class="flex items-start">
                                <div class="flex-shrink-0 mt-1 mr-3">
                                    <div class="flex items-center justify-center w-5 h-5 rounded-full bg-orange-500/20 text-orange-500">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                </div>
                                <span class="text-gray-700">{{ $feature }}</span>
                            </li>
                            @endforeach
                        </ul>
                        
                        <div class="mt-auto">
                            <a href="{{ $service['link'] }}" class="inline-flex items-center text-orange-500 font-semibold hover:text-orange-600 group">
                                Ver detalles del servicio
                                <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
        <div class="absolute -bottom-[1px] left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-white"></path>
        </svg>
    </div>
</section>

<!-- Proceso de Trabajo -->
<section class="py-24 bg-white relative">
    <div class="container mx-auto px-4">
        <div class="text-center mb-20" data-aos="fade-up">
            <span class="text-orange-400 font-semibold tracking-widest">NUESTRO MÉTODO</span>
            <h2 class="text-4xl font-bold text-zinc-800 mt-3 mb-4">Excelencia en Cada Etapa</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Nuestro proceso garantiza resultados de calidad desde el primer contacto hasta la entrega final.</p>
        </div>
        
        <!-- Timeline horizontal -->
        <div class="relative">
            <!-- Línea de tiempo -->
            <div class="hidden lg:block absolute top-1/2 left-0 right-0 h-1 bg-gray-200 transform -translate-y-1/2 z-0"></div>
            
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8 lg:gap-4 relative z-10">
                @foreach([
                    ['icon' => 'fas fa-search', 'title' => 'Evaluación', 'text' => 'Análisis técnico detallado de sus necesidades'],
                    ['icon' => 'fas fa-pencil-ruler', 'title' => 'Diseño', 'text' => 'Propuesta de solución técnica personalizada'],
                    ['icon' => 'fas fa-cogs', 'title' => 'Ejecución', 'text' => 'Implementación con estándares de calidad'],
                    ['icon' => 'fas fa-clipboard-check', 'title' => 'Entrega', 'text' => 'Revisión final y documentación']
                ] as $step)
                <div class="flex flex-col items-center text-center" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center text-white text-2xl mb-4 shadow-lg">
                        <i class="{{ $step['icon'] }}"></i>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-800 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-gray-600">{{ $step['text'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- CTA Final con Estadísticas -->
<section class="py-20 bg-gradient-to-r from-zinc-900 to-zinc-800 text-white relative overflow-hidden">
        <div class="absolute -top-[1px] left-0 w-full overflow-hidden leading-[0] transform rotate-180">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-white"></path>
        </svg>
    </div>
    <!-- Elementos decorativos -->
    <div class="absolute top-0 left-0 w-full h-full opacity-10">
        <div class="absolute top-1/3 left-1/4 w-64 h-64 bg-orange-500 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-1/3 right-1/4 w-64 h-64 bg-orange-500 rounded-full blur-[120px]"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Estadísticas -->
            <div class="grid grid-cols-2 gap-8" data-aos="fade-right">
                <div class="text-center">
                    <div class="text-5xl font-bold text-orange-400 mb-2" data-countup="150">0</div>
                    <span class="text-gray-300">Proyectos Completados</span>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-orange-400 mb-2" data-countup="98">0</div>
                    <span class="text-gray-300">% Satisfacción Clientes</span>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-orange-400 mb-2" data-countup="50">0</div>
                    <span class="text-gray-300">Clientes Activos</span>
                </div>
                <div class="text-center">
                    <div class="text-5xl font-bold text-orange-400 mb-2" data-countup="24">0</div>
                    <span class="text-gray-300">Horas Respuesta</span>
                </div>
            </div>
            
            <!-- Formulario CTA -->
            <div data-aos="fade-left">
                <h2 class="text-3xl font-bold mb-6">¿Listo para optimizar sus operaciones?</h2>
                <p class="text-gray-300 mb-8">
                    Nuestro equipo está preparado para asesorarle y ofrecerle la mejor solución para sus necesidades.
                </p>
                <form class="space-y-4">
                    <input type="text" placeholder="Nombre de la Empresa" class="w-full px-6 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <input type="email" placeholder="Correo Electrónico" class="w-full px-6 py-3 bg-white/5 border border-white/10 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <select class="w-full px-6 py-3 bg-white/5 border border-white/10 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                        <option value="" disabled selected>Servicio de Interés</option>
                        <option>Equipos Industriales</option>
                        <option>Estructuras Metálicas</option>
                        <option>Geomembranas HDPE</option>
                        <option>Otro Servicio</option>
                    </select>
                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-300">
                        Solicitar Asesoría
                    </button>
                </form>
            </div>
        </div>
    </div>
    
</section>

<!-- Script para animación de números -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const counters = document.querySelectorAll('[data-countup]');
        const speed = 200;
        
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-countup');
            const count = +counter.innerText;
            const increment = target / speed;
            
            if(count < target) {
                const updateCount = () => {
                    const newCount = Math.ceil(count + increment);
                    counter.innerText = newCount;
                    
                    if(newCount < target) {
                        setTimeout(updateCount, 1);
                    } else {
                        counter.innerText = target + (target === 24 ? 'h' : '+');
                    }
                };
                updateCount();
            } else {
                counter.innerText = target + (target === 24 ? 'h' : '+');
            }
        });
    });
</script>

@endsection