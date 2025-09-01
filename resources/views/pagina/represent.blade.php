@extends('layouts_pag.app')

@section('title', 'Representaciones')

@section('content')
@include('layouts_pag.flotantes')
<!-- Sección Representaciones -->
<section id="representaciones" class="relative py-24 bg-gradient-to-b from-[#0a0a0a] via-[#141414] to-[#0a0a0a] text-white overflow-hidden">
    <!-- Separador superior SVG con efecto -->
    <div class="absolute -top-[1px] left-0 w-full overflow-hidden leading-[0] transform rotate-180">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-zinc-900"></path>
        </svg>
    </div>

    <!-- Elementos decorativos de fondo -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-64 h-64 bg-orange-500 rounded-full filter blur-3xl opacity-20 mix-blend-overlay"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-orange-500 rounded-full filter blur-3xl opacity-20 mix-blend-overlay"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Título con efecto -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-orange-400 font-semibold tracking-wider uppercase text-sm">Alianzas estratégicas</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-5 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">
                Nuestras Representaciones
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-orange-300 mx-auto rounded-full"></div>
            <p class="max-w-2xl mx-auto mt-6 text-gray-300">Colaboramos con los mejores proveedores del rubro minero para ofrecer soluciones integrales con los más altos estándares de calidad.</p>
        </div>

        <!-- Grid de Representaciones -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-20">
            <!-- Representación 1 -->
            <div class="group relative rounded-xl overflow-hidden shadow-2xl border border-white/10 bg-gradient-to-br from-zinc-900/50 to-zinc-800/20 hover:bg-zinc-800/30 transition-all duration-500 hover:shadow-orange-500/20"
                data-aos="fade-up" data-aos-delay="100">
                <div class="h-60 overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent z-10"></div>
                    <img src="{{ asset('img-pag/remining-logo-white.png') }}" alt="Equipos Mineros"
                        class="w-full h-full object-cover transition-transform duration-[10000ms] ease-linear group-hover:scale-110">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('img-pag/remining-logo-white.png') }}" alt="Partner Logo" class="h-12 mr-4 transition-transform duration-300 group-hover:scale-105">
                        <span class="text-sm font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">Representación Exclusiva</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Equipos Mineros Premium</h3>
                    <p class="text-gray-300 mb-4">Distribución exclusiva de maquinaria pesada y equipos especializados para la industria minera.</p>
                    <ul class="space-y-2 text-gray-300 mb-5">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Equipos nuevos y usados</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Garantía extendida</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Soporte técnico especializado</span>
                        </li>
                    </ul>
                    <a href="#" class="inline-flex items-center text-orange-400 hover:text-white group text-sm font-medium">
                        Más información
                        <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>

            <!-- Representación 2 -->
            <div class="group relative rounded-xl overflow-hidden shadow-2xl border border-white/10 bg-gradient-to-br from-zinc-900/50 to-zinc-800/20 hover:bg-zinc-800/30 transition-all duration-500 hover:shadow-orange-500/20"
                data-aos="fade-up" data-aos-delay="200">
                <div class="h-60 overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent z-10"></div>
                    <img src="{{ asset('img-pag/logo-sm-em-white.png') }}" alt="Componentes Industriales"
                        class="w-full h-full object-cover transition-transform duration-[10000ms] ease-linear group-hover:scale-110">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('img-pag/logo-sm-em-white.png') }}" alt="Partner Logo" class="h-12 mr-4 transition-transform duration-300 group-hover:scale-105">
                        <span class="text-sm font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">Representación Oficial</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Componentes y Repuestos</h3>
                    <p class="text-gray-300 mb-4">Suministro de componentes originales y repuestos de alta calidad para mantenimiento industrial.</p>
                    <ul class="space-y-2 text-gray-300 mb-5">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Partes originales</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Entrega express</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Asesoría técnica</span>
                        </li>
                    </ul>
                    <a href="#" class="inline-flex items-center text-orange-400 hover:text-white group text-sm font-medium">
                        Más información
                        <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>

            <!-- Representación 3 -->
            <div class="group relative rounded-xl overflow-hidden shadow-2xl border border-white/10 bg-gradient-to-br from-zinc-900/50 to-zinc-800/20 hover:bg-zinc-800/30 transition-all duration-500 hover:shadow-orange-500/20"
                data-aos="fade-up" data-aos-delay="300">
                <div class="h-60 overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent z-10"></div>
                    <img src="{{ asset('img-pag/geoservi-logo-white.png') }}" alt="Tecnología Minera"
                        class="w-full h-full object-cover transition-transform duration-[10000ms] ease-linear group-hover:scale-110">
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('img-pag/geoservi-logo-white.png') }}" alt="Partner Logo" class="h-12 mr-4 transition-transform duration-300 group-hover:scale-105">

                        <span class="text-sm font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">Distribuidor Autorizado</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">Tecnología Minera</h3>
                    <p class="text-gray-300 mb-4">Soluciones tecnológicas avanzadas para optimización de procesos y seguridad en minería.</p>
                    <ul class="space-y-2 text-gray-300 mb-5">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Sistemas de monitoreo</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Software especializado</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                    <i class="fas fa-check text-orange-400 text-xs"></i>
                                </div>
                            </div>
                            <span class="ml-2">Capacitación incluida</span>
                        </li>
                    </ul>
                    <a href="#" class="inline-flex items-center text-orange-400 hover:text-white group text-sm font-medium">
                        Más información
                        <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Beneficios de las representaciones -->
        <div class="max-w-5xl mx-auto mb-20" data-aos="fade-up">
            <h3 class="text-2xl font-bold text-center text-white mb-12">Ventajas de trabajar con nuestros <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">socios estratégicos</span></h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-zinc-900/50 border border-white/10 rounded-xl p-6 hover:bg-zinc-800/30 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-500/20 transition-colors duration-300">
                        <i class="fas fa-award text-2xl text-orange-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-3">Calidad Garantizada</h4>
                    <p class="text-gray-300">Todos nuestros socios cumplen con los más altos estándares de calidad y certificaciones internacionales.</p>
                </div>
                
                <div class="bg-zinc-900/50 border border-white/10 rounded-xl p-6 hover:bg-zinc-800/30 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-500/20 transition-colors duration-300">
                        <i class="fas fa-headset text-2xl text-orange-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-3">Soporte Integral</h4>
                    <p class="text-gray-300">Asesoría técnica especializada y soporte post-venta para garantizar el máximo rendimiento.</p>
                </div>
                
                <div class="bg-zinc-900/50 border border-white/10 rounded-xl p-6 hover:bg-zinc-800/30 transition-all duration-300 group">
                    <div class="w-14 h-14 bg-orange-500/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-500/20 transition-colors duration-300">
                        <i class="fas fa-handshake text-2xl text-orange-400"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-3">Relaciones a Largo Plazo</h4>
                    <p class="text-gray-300">Trabajamos en conjunto con nuestros socios para ofrecer soluciones adaptadas a sus necesidades.</p>
                </div>
            </div>
        </div>

        <!-- CTA para empresas -->
        <div class="max-w-4xl mx-auto bg-gradient-to-r from-zinc-900 to-zinc-800 rounded-2xl overflow-hidden shadow-2xl border border-white/10" data-aos="fade-up">
            <div class="p-8 md:p-12 flex flex-col md:flex-row items-center">
                <div class="md:w-2/3 mb-6 md:mb-0 md:pr-8">
                    <h3 class="text-2xl font-bold text-white mb-3">¿Eres proveedor del rubro minero?</h3>
                    <p class="text-gray-300 mb-4">Únete a nuestra red de representaciones estratégicas y amplía tu alcance en el mercado con el respaldo de Geoservi.</p>
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center text-sm text-orange-400">
                            <i class="fas fa-check-circle mr-2"></i> Representación exclusiva
                        </div>
                        <div class="flex items-center text-sm text-orange-400">
                            <i class="fas fa-check-circle mr-2"></i> Visibilidad garantizada
                        </div>
                        <div class="flex items-center text-sm text-orange-400">
                            <i class="fas fa-check-circle mr-2"></i> Crecimiento mutuo
                        </div>
                    </div>
                </div>
                <div class="md:w-1/3 flex justify-center md:justify-end">
                    <a href="#contacto" class="relative inline-flex items-center justify-center px-8 py-3 overflow-hidden font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full group">
                        <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-orange-700 rounded-full group-hover:w-56 group-hover:h-56"></span>
                        <span class="absolute inset-0 w-full h-full -mt-1 rounded-full opacity-30 bg-gradient-to-b from-transparent via-transparent to-white"></span>
                        <span class="relative flex items-center">
                            <i class="fas fa-handshake mr-2"></i> Ser Proveedor
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Separador inferior SVG -->
    <div class="absolute -bottom-[1px] left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-zinc-900"></path>
        </svg>
    </div>
</section>

    
@endsection