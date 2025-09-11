<!-- Sección de Servicio de Software/Sistema -->
<section class="relative py-20 bg-gradient-to-b from-zinc-900 to-zinc-800 text-white">
    <!-- Separador superior -->
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-full h-10" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.09C204.56,76.31,85.29,95.5,0,120V0H1200V27.35c-85.29,20.15-204.56,39.34-321.39,28.74C748.44,46.08,669.23,16.9,589.29,7.49,509.35-1.91,429.45,35.86,321.39,56.09Z" fill="#000000"></path>
        </svg>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Encabezado -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-orange-500 font-semibold">NUESTRO SISTEMA DE GESTIÓN</span>
            <h2 class="text-4xl font-bold mt-2 mb-4">Software de Gestión Minera Integral</h2>
            <div class="w-20 h-1 bg-orange-500 mx-auto"></div>
        </div>

        <!-- Contenido principal -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <!-- Imagen/Ilustración -->
            <div class="relative" data-aos="fade-right">
                <div class="relative z-10 rounded-2xl overflow-hidden shadow-2xl">
                    <img src="{{ asset('/img/servicios/erp.jpg') }}" alt="Sistema de Gestión Minera" class="w-full h-auto">
                </div>
                <div class="absolute -bottom-6 -left-6 w-full h-full border-2 border-orange-400 rounded-2xl z-0" data-aos="fade-right" data-aos-delay="200"></div>

                <!-- Badge de características -->
                <div class="absolute -top-6 -right-6 bg-zinc-900 text-white px-6 py-3 rounded-full shadow-xl z-20" data-aos="fade-left" data-aos-delay="300">
                    <div class="flex items-center">
                        <span class="text-orange-400 font-bold text-3xl mr-2">100%</span>
                        <span class="text-sm">Digital<br>Optimizado</span>
                    </div>
                </div>
            </div>

            <!-- Contenido -->
            <div data-aos="fade-left">
                <h3 class="text-3xl font-bold text-white mb-6">¿Cómo Funciona Nuestro Sistema?</h3>
                <p class="text-lg text-gray-300 mb-8">
                    Nuestro software de gestión integral está diseñado específicamente para la industria minera, permitiendo controlar y optimizar todos los procesos operativos desde una única plataforma digital.
                </p>

                <!-- Lista de características -->
                <ul class="space-y-4 mb-8">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/10 text-orange-500">
                                <i class="fas fa-cogs"></i>
                            </div>
                        </div>
                        <span class="text-gray-300 font-medium">Gestión completa de maquinaria y equipos</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/10 text-orange-500">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                        </div>
                        <span class="text-gray-300 font-medium">Programación y seguimiento de mantenimientos</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/10 text-orange-500">
                                <i class="fas fa-chart-line"></i>
                            </div>
                        </div>
                        <span class="text-gray-300 font-medium">Reportes y análisis en tiempo real</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1 mr-4">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full bg-orange-500/10 text-orange-500">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <span class="text-gray-300 font-medium">Control de personal y asignaciones</span>
                    </li>
                </ul>

                <a href="#contacto" class="inline-flex items-center text-orange-500 font-semibold hover:text-orange-600 group">
                    Solicitar demostración
                    <i class="fas fa-arrow-right ml-2 transition-transform group-hover:translate-x-1"></i>
                </a>
            </div>
        </div>

        <!-- Beneficios y Garantías -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8" data-aos="fade-up">
            <div class="bg-zinc-800/50 backdrop-blur-sm rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-white"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-2">Garantía de Calidad</h4>
                <p class="text-gray-300">Sistema probado y certificado para entornos industriales exigentes</p>
            </div>

            <div class="bg-zinc-800/50 backdrop-blur-sm rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-white"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-2">Soporte 24/7</h4>
                <p class="text-gray-300">Asistencia técnica continua y actualizaciones del sistema</p>
            </div>

            <div class="bg-zinc-800/50 backdrop-blur-sm rounded-xl p-6 text-center">
                <div class="w-16 h-16 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-rocket text-2xl text-white"></i>
                </div>
                <h4 class="text-xl font-bold text-white mb-2">Optimización Continua</h4>
                <p class="text-gray-300">Mejoras constantes basadas en retroalimentación de usuarios</p>
            </div>
        </div>

        <!-- CTA Final -->
        <div class="mt-16 text-center" data-aos="fade-up">
            <div class="inline-flex flex-col sm:flex-row items-center bg-zinc-800/50 backdrop-blur-sm rounded-xl p-8 shadow-lg">
                <div class="text-left mb-4 sm:mb-0 sm:mr-8">
                    <h3 class="text-2xl font-bold text-white">¿Listo para digitalizar tus operaciones?</h3>
                    <p class="text-gray-400">Descubre cómo nuestro sistema puede transformar tu gestión minera</p>
                </div>
                <button onclick="openContactModal()" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-8 py-4 rounded-lg font-bold whitespace-nowrap transition-all duration-300 shadow-lg hover:shadow-orange-500/30">
                    <i class="fas fa-play-circle mr-2"></i> Ver Demo
                </button>
            </div>
        </div>
    </div>

    <!-- Separador inferior -->
    <div class="absolute -bottom-[1px] left-0 w-full overflow-hidden leading-[0] transform rotate-180">
        <svg class="relative block w-full h-10" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.09C204.56,76.31,85.29,95.5,0,120V0H1200V27.35c-85.29,20.15-204.56,39.34-321.39,28.74C748.44,46.08,669.23,16.9,589.29,7.49,509.35-1.91,429.45,35.86,321.39,56.09Z" fill="#18181b"></path>
        </svg>
    </div>
</section>
