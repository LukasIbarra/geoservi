@extends('layouts_pag.app')

@section('title', 'Nosotros')

@section('content')
@include('layouts_pag.flotantes')
<!-- Sección Nosotros -->
<section id="nosotros" class="relative py-24 bg-gradient-to-b from-[#0a0a0a] via-[#141414] to-[#0a0a0a] text-white overflow-hidden">
    <!-- Separador superior SVG -->
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
        <!-- Título -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-orange-400 font-semibold tracking-wider uppercase text-sm">Sobre nosotros</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-5 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">
                GEOSERVI SPA
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-orange-300 mx-auto rounded-full"></div>
        </div>

        <!-- Video placeholder -->
        <div class="max-w-4xl mx-auto mb-20 rounded-xl overflow-hidden shadow-2xl border border-white/10 bg-black" data-aos="fade-up">
            <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-zinc-900 to-zinc-800 flex items-center justify-center">
                <div class="text-center p-8">
                    <div class="w-20 h-20 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-play text-orange-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Conoce nuestra empresa</h3>
                    <p class="text-gray-300 max-w-md mx-auto">Próximamente: Video corporativo de Geoservi SPA</p>
                </div>
            </div>
        </div>

        <!-- Misión y Visión -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-20">
            <!-- Misión -->
            <div class="bg-zinc-900/50 border border-white/10 rounded-xl p-8 md:p-10 hover:bg-zinc-800/30 transition-all duration-500 group" data-aos="fade-right">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-orange-500/10 rounded-lg flex items-center justify-center group-hover:bg-orange-500/20 transition-colors duration-300">
                            <i class="fas fa-bullseye text-orange-400 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white ml-4 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">
                        Nuestra Misión
                    </h3>
                </div>
                <p class="text-gray-300 mb-6">
                    Brindar un servicio ágil, confiable y personalizado que responda con excelencia a los desafíos diarios de nuestros clientes en el sector minero, industrial y de la construcción.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                <i class="fas fa-check text-orange-400 text-xs"></i>
                            </div>
                        </div>
                        <span class="ml-3 text-gray-300">Equipo profesional altamente capacitado</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                <i class="fas fa-check text-orange-400 text-xs"></i>
                            </div>
                        </div>
                        <span class="ml-3 text-gray-300">Red sólida de proveedores estratégicos</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                <i class="fas fa-check text-orange-400 text-xs"></i>
                            </div>
                        </div>
                        <span class="ml-3 text-gray-300">Continuidad operacional y eficiencia</span>
                    </li>
                </ul>
            </div>

            <!-- Visión -->
            <div class="bg-zinc-900/50 border border-white/10 rounded-xl p-8 md:p-10 hover:bg-zinc-800/30 transition-all duration-500 group" data-aos="fade-left">
                <div class="flex items-center mb-6">
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-orange-500/10 rounded-lg flex items-center justify-center group-hover:bg-orange-500/20 transition-colors duration-300">
                            <i class="fas fa-eye text-orange-400 text-xl"></i>
                        </div>
                    </div>
                    <h3 class="text-2xl font-bold text-white ml-4 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">
                        Nuestra Visión
                    </h3>
                </div>
                <p class="text-gray-300 mb-6">
                    Ser reconocidos como el socio estratégico de confianza para empresas del rubro minero, industrial y de la construcción, entregando soluciones rápidas, precisas y personalizadas.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                <i class="fas fa-check text-orange-400 text-xs"></i>
                            </div>
                        </div>
                        <span class="ml-3 text-gray-300">Conexión eficiente entre necesidades y proveedores</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                <i class="fas fa-check text-orange-400 text-xs"></i>
                            </div>
                        </div>
                        <span class="ml-3 text-gray-300">Especialización en equipos de línea amarilla</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-5 w-5 rounded-full bg-orange-500/20">
                                <i class="fas fa-check text-orange-400 text-xs"></i>
                            </div>
                        </div>
                        <span class="ml-3 text-gray-300">Referente en atención especializada</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Nuestros Valores -->
        <div class="max-w-5xl mx-auto mb-20" data-aos="fade-up">
            <h3 class="text-2xl font-bold text-center text-white mb-12">Nuestros <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">Valores</span></h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500/10 rounded-full flex items-center justify-center mx-auto mb-4 group hover:bg-orange-500/20 transition-colors duration-300">
                        <i class="fas fa-handshake text-orange-400 text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Compromiso</h4>
                    <p class="text-sm text-gray-300">Con nuestros clientes y sus objetivos operacionales</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500/10 rounded-full flex items-center justify-center mx-auto mb-4 group hover:bg-orange-500/20 transition-colors duration-300">
                        <i class="fas fa-bolt text-orange-400 text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Agilidad</h4>
                    <p class="text-sm text-gray-300">Respuesta rápida a los desafíos productivos</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500/10 rounded-full flex items-center justify-center mx-auto mb-4 group hover:bg-orange-500/20 transition-colors duration-300">
                        <i class="fas fa-star text-orange-400 text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Excelencia</h4>
                    <p class="text-sm text-gray-300">En cada solución que entregamos</p>
                </div>
                
                <div class="text-center">
                    <div class="w-20 h-20 bg-orange-500/10 rounded-full flex items-center justify-center mx-auto mb-4 group hover:bg-orange-500/20 transition-colors duration-300">
                        <i class="fas fa-users text-orange-400 text-2xl group-hover:scale-110 transition-transform"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Trabajo en Equipo</h4>
                    <p class="text-sm text-gray-300">Interno y con nuestros socios estratégicos</p>
                </div>
            </div>
        </div>

        <!-- Equipo (placeholder para cuando tengan fotos) -->
        <div class="max-w-5xl mx-auto mb-20" data-aos="fade-up">
            <h3 class="text-2xl font-bold text-center text-white mb-12">Nuestro <span class="bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">Equipo</span></h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                <!-- Miembro 1 -->
                <div class="group text-center">
                    <div class="relative mb-4 rounded-xl overflow-hidden h-64 bg-gradient-to-br from-zinc-800 to-zinc-900">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-user-hard-hat text-5xl text-orange-400 opacity-30"></i>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <div class="text-left">
                                <p class="text-sm text-gray-300">Especialista en equipos mineros con más de 15 años de experiencia en el rubro.</p>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold text-white">Juan Miranda</h4>
                    <p class="text-orange-400 text-sm">Gerente General</p>
                    <a href="mailto:juanmiranda@geoservi.cl" class="text-gray-400 text-sm hover:text-orange-400 transition-colors">juanmiranda@geoservi.cl</a>
                </div>
                
                <!-- Miembro 2 -->
                <div class="group text-center">
                    <div class="relative mb-4 rounded-xl overflow-hidden h-64 bg-gradient-to-br from-zinc-800 to-zinc-900">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-user-cog text-5xl text-orange-400 opacity-30"></i>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <div class="text-left">
                                <p class="text-sm text-gray-300">Experto en operaciones y logística con amplia trayectoria en proyectos mineros.</p>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold text-white">Walter Smith</h4>
                    <p class="text-orange-400 text-sm">Gerente de Operaciones</p>
                    <a href="mailto:waltersmith@geoservi.cl" class="text-gray-400 text-sm hover:text-orange-400 transition-colors">waltersmith@geoservi.cl</a>
                </div>
                
                <!-- Miembro 3 -->
                <div class="group text-center">
                    <div class="relative mb-4 rounded-xl overflow-hidden h-64 bg-gradient-to-br from-zinc-800 to-zinc-900">
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-user-tie text-5xl text-orange-400 opacity-30"></i>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                            <div class="text-left">
                                <p class="text-sm text-gray-300">Especialista en relaciones comerciales y atención al cliente del sector industrial.</p>
                            </div>
                        </div>
                    </div>
                    <h4 class="text-lg font-bold text-white">Equipo Comercial</h4>
                    <p class="text-orange-400 text-sm">Ventas y Servicio</p>
                    <a href="mailto:ventas@geoservi.cl" class="text-gray-400 text-sm hover:text-orange-400 transition-colors">ventas@geoservi.cl</a>
                </div>
            </div>
        </div>

        <!-- CTA de contacto -->
        <div class="max-w-4xl mx-auto bg-gradient-to-r from-zinc-900 to-zinc-800 rounded-2xl overflow-hidden shadow-2xl border border-white/10" data-aos="fade-up">
            <div class="p-8 md:p-12 flex flex-col md:flex-row items-center">
                <div class="md:w-2/3 mb-6 md:mb-0 md:pr-8">
                    <h3 class="text-2xl font-bold text-white mb-3">¿Listo para trabajar con nosotros?</h3>
                    <p class="text-gray-300 mb-4">Nuestro equipo está preparado para entender tus necesidades y ofrecerte las mejores soluciones del mercado minero e industrial.</p>
                    <div class="flex flex-wrap gap-3">
                        <div class="flex items-center text-sm text-orange-400">
                            <i class="fas fa-check-circle mr-2"></i> Respuesta en menos de 24 horas
                        </div>
                        <div class="flex items-center text-sm text-orange-400">
                            <i class="fas fa-check-circle mr-2"></i> Asesoría especializada
                        </div>
                        <div class="flex items-center text-sm text-orange-400">
                            <i class="fas fa-check-circle mr-2"></i> Soluciones a medida
                        </div>
                    </div>
                </div>
                <div class="md:w-1/3 flex justify-center md:justify-end">
                    <a href="#contacto" class="relative inline-flex items-center justify-center px-8 py-3 overflow-hidden font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full group">
                        <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-orange-700 rounded-full group-hover:w-56 group-hover:h-56"></span>
                        <span class="absolute inset-0 w-full h-full -mt-1 rounded-full opacity-30 bg-gradient-to-b from-transparent via-transparent to-white"></span>
                        <span class="relative flex items-center">
                            <i class="fas fa-envelope mr-2"></i> Contactar
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