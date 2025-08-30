<!-- Sección de Servicios -->
<section id="servicios" class="relative py-20 bg-[#121212] text-white">
    <!-- Separador superior -->
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-full h-10" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.09C204.56,76.31,85.29,95.5,0,120V0H1200V27.35c-85.29,20.15-204.56,39.34-321.39,28.74C748.44,46.08,669.23,16.9,589.29,7.49,509.35-1.91,429.45,35.86,321.39,56.09Z" fill="#fff"></path>
        </svg>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Encabezado -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-orange-500 font-semibold">NUESTROS SERVICIOS</span>
            <h2 class="text-4xl font-bold mt-2 mb-4">Soluciones Integrales para la Industria Minera</h2>
            <div class="w-20 h-1 bg-orange-500 mx-auto"></div>
        </div>
        
        <!-- Grid de servicios -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $servicios = [
                    [
                        'img' => '/img/servicios/maquina.jpg',
                        'icon' => 'fa-cogs',
                        'titulo' => 'Equipos Industriales',
                        'desc' => 'Reparación y fabricación de partes y piezas de equipos mineros e industriales con estándares de calidad.',
                    ],
                    [
                        'img' => '/img/servicios/estructura.jpg',
                        'icon' => 'fa-industry',
                        'titulo' => 'Estructuras Metálicas',
                        'desc' => 'Diseño y fabricación de estructuras metálicas resistentes para la minería y construcción industrial.',
                    ],
                    [
                        'img' => '/img/servicios/geomembrana.jpg',
                        'icon' => 'fa-layer-group',
                        'titulo' => 'Geomembranas HDPE',
                        'desc' => 'Instalación profesional de geomembranas y soldadura de tuberías con tecnología de punta.',
                    ],
                    [
                        'img' => '/img/servicios/cilindro1.jpg',
                        'icon' => 'fa-tools',
                        'titulo' => 'Cilindros Hidráulicos',
                        'desc' => 'Reparación, mantención y fabricación de cilindros hidráulicos con garantía de calidad.',
                    ]
                ];
            @endphp

            @foreach ($servicios as $index => $servicio)
            <div class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition-all duration-500" 
                 data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                <div class="h-60 overflow-hidden relative">
                    <img src="{{ $servicio['img'] }}" alt="{{ $servicio['titulo'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent"></div>
                    <div class="absolute top-6 right-6 bg-orange-500 text-white p-3 rounded-full shadow-lg">
                        <i class="fas {{ $servicio['icon'] }} text-2xl"></i>
                    </div>
                </div>
                <div class="p-6 bg-[#1c1c1c]">
                    <h3 class="text-xl font-bold text-white mb-2">{{ $servicio['titulo'] }}</h3>
                    <p class="text-gray-300 mb-4">{{ $servicio['desc'] }}</p>
                    <a href="#" class="inline-flex items-center text-orange-500 font-medium hover:text-orange-400 group-hover:underline">
                        Ver detalles
                        <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- CTA adicional -->
        <div class="mt-16 text-center" data-aos="fade-up">
            <div class="inline-flex flex-col sm:flex-row items-center bg-[#1c1c1c] rounded-xl p-6 shadow-lg">
                <div class="text-left mb-4 sm:mb-0 sm:mr-8">
                    <h3 class="text-xl font-bold text-white">¿Necesitas una solución personalizada?</h3>
                    <p class="text-gray-400">Contáctanos para evaluar tus requerimientos específicos</p>
                </div>
                <button onclick="openContactModal()" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-6 py-3 rounded-lg font-bold whitespace-nowrap transition-all duration-300 shadow-lg hover:shadow-orange-500/30">
                    <i class="fas fa-envelope mr-2"></i> Contactar Ahora
                </button>
            </div>
        </div>
    </div>
</section>
