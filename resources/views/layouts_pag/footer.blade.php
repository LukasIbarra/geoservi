<!-- Footer -->
<footer class="relative bg-gradient-to-b from-zinc-900 to-zinc-800 text-gray-300 pt-20 pb-10 overflow-hidden">
    <!-- Separador superior SVG -->
    <div class="absolute -top-[1px] left-0 w-full overflow-hidden leading-[0] transform rotate-180">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-zinc-800"></path>
        </svg>
    </div>

    <!-- Elementos decorativos -->
    <div class="absolute top-20 left-1/4 w-64 h-64 bg-orange-500 rounded-full filter blur-[100px] opacity-5"></div>
    <div class="absolute bottom-10 right-1/4 w-64 h-64 bg-orange-500 rounded-full filter blur-[100px] opacity-5"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 mb-12">
            <!-- Columna 1: Logo y descripción -->
            <div class="md:col-span-2">
                <div class="flex items-center mb-6">
                    <img src="{{ asset('img-pag/geoservi-logo-white.png') }}" alt="Geoservi Logo" class="h-14 mr-4">
                    <span class="text-2xl font-bold text-white">GEOSERVI SPA</span>
                </div>
                <p class="mb-6 text-gray-400">Líderes en soluciones integrales para la industria minera y construcción, brindando servicios de excelencia con el más alto estándar de calidad.</p>
                
                <!-- Suscripción a newsletter -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-white mb-3">Suscríbete a nuestro boletín</h4>
                    <form id="newsletter-form" class="flex">
                        @csrf
                        <input type="email" name="email" placeholder="Tu correo electrónico" required
                               class="flex-grow px-4 py-2 bg-white/5 border border-white/10 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-r-lg transition-colors duration-300 newsletter-submit">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <div id="newsletter-message" class="mt-2 text-sm hidden"></div>
                </div>
            </div>

            <!-- Columna 2: Enlaces rápidos -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-6 border-b border-white/10 pb-2">Enlaces Rápidos</h4>
                <ul class="space-y-3">
                    <li><a href="#" class="hover:text-orange-400 transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right text-xs text-orange-400 mr-2"></i> Inicio</a></li>
                    <li><a href="#servicios" class="hover:text-orange-400 transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right text-xs text-orange-400 mr-2"></i> Servicios</a></li>
                    <li><a href="#representaciones" class="hover:text-orange-400 transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right text-xs text-orange-400 mr-2"></i> Representaciones</a></li>
                    <li><a href="#nosotros" class="hover:text-orange-400 transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right text-xs text-orange-400 mr-2"></i> Nosotros</a></li>
                    <li><a href="#contacto" class="hover:text-orange-400 transition-colors duration-300 flex items-center"><i class="fas fa-chevron-right text-xs text-orange-400 mr-2"></i> Contacto</a></li>
                </ul>
            </div>

            <!-- Columna 3: Contacto -->
            <div>
                <h4 class="text-lg font-semibold text-white mb-6 border-b border-white/10 pb-2">Contacto</h4>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-orange-500/20 text-orange-400">
                                <i class="fas fa-map-marker-alt text-xs"></i>
                            </div>
                        </div>
                        <span class="ml-3">Araucania edif 1 5427 105 Espacio la florida La serena</span>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-orange-500/20 text-orange-400">
                                <i class="fas fa-phone-alt text-xs"></i>
                            </div>
                        </div>
                        <a href="tel:+56931165525" class="ml-3 hover:text-orange-400 transition-colors duration-300">+56 9 3116 5525</a>
                    </li>
                    <li class="flex items-start">
                        <div class="flex-shrink-0 mt-1">
                            <div class="flex items-center justify-center h-6 w-6 rounded-full bg-orange-500/20 text-orange-400">
                                <i class="fas fa-envelope text-xs"></i>
                            </div>
                        </div>
                        <a href="mailto:ventas@geoservi.cl" class="ml-3 hover:text-orange-400 transition-colors duration-300">ventas@geoservi.cl</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-white/10 my-8"></div>

        <!-- Redes sociales y copyright -->
        <div class="flex flex-col md:flex-row justify-between items-center">
            <div class="mb-4 md:mb-0">
                <p class="text-sm text-gray-400">&copy; <span id="current-year"></span> Geoservi Spa. Todos los derechos reservados.</p>
            </div>
            
            <div class="flex space-x-6">
                <a href="#" class="h-10 w-10 flex items-center justify-center bg-white/5 hover:bg-orange-500 rounded-full transition-colors duration-300 group">
                    <i class="fab fa-facebook-f text-gray-300 group-hover:text-white"></i>
                </a>
                <a href="#" class="h-10 w-10 flex items-center justify-center bg-white/5 hover:bg-orange-500 rounded-full transition-colors duration-300 group">
                    <i class="fab fa-linkedin-in text-gray-300 group-hover:text-white"></i>
                </a>
                <a href="#" class="h-10 w-10 flex items-center justify-center bg-white/5 hover:bg-orange-500 rounded-full transition-colors duration-300 group">
                    <i class="fab fa-instagram text-gray-300 group-hover:text-white"></i>
                </a>
                <a href="#" class="h-10 w-10 flex items-center justify-center bg-white/5 hover:bg-orange-500 rounded-full transition-colors duration-300 group">
                    <i class="fab fa-youtube text-gray-300 group-hover:text-white"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Script para año actual -->
    <script>
        document.getElementById('current-year').textContent = new Date().getFullYear();

        // Script para manejar el formulario del newsletter
        document.addEventListener('DOMContentLoaded', function() {
            const newsletterForm = document.getElementById('newsletter-form');
            const newsletterMessage = document.getElementById('newsletter-message');
            
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const formData = new FormData(newsletterForm);
                    const submitButton = newsletterForm.querySelector('.newsletter-submit');
                    const originalHtml = submitButton.innerHTML;
                    
                    // Mostrar indicador de carga
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                    submitButton.disabled = true;
                    newsletterMessage.classList.add('hidden');
                    
                    fetch('{{ route("newsletter.subscribe") }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Restaurar botón
                        submitButton.innerHTML = originalHtml;
                        submitButton.disabled = false;
                        
                        // Mostrar mensaje
                        newsletterMessage.textContent = data.message;
                        newsletterMessage.classList.remove('hidden');
                        
                        if (data.success) {
                            newsletterMessage.classList.add('text-green-400');
                            newsletterMessage.classList.remove('text-red-400');
                            newsletterForm.reset();
                        } else {
                            newsletterMessage.classList.add('text-red-400');
                            newsletterMessage.classList.remove('text-green-400');
                        }
                        
                        // Ocultar mensaje después de 5 segundos
                        setTimeout(() => {
                            newsletterMessage.classList.add('hidden');
                        }, 5000);
                    })
                    .catch(error => {
                        // Restaurar botón
                        submitButton.innerHTML = originalHtml;
                        submitButton.disabled = false;
                        
                        // Mostrar mensaje de error
                        newsletterMessage.textContent = 'Error de conexión. Por favor, inténtalo de nuevo.';
                        newsletterMessage.classList.remove('hidden');
                        newsletterMessage.classList.add('text-red-400');
                        
                        console.error('Error:', error);
                    });
                });
            }
        });
    </script>
</footer>
