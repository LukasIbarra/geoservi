<!-- Sección Contacto -->
<section id="contacto" class="relative py-24 bg-gradient-to-b from-zinc-900 to-zinc-800 text-white overflow-hidden">
    <!-- Separador superior SVG -->
    <div class="absolute -top-[1px] left-0 w-full overflow-hidden leading-[0] transform rotate-180">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-zinc-800"></path>
        </svg>
    </div>

    <!-- Elementos decorativos -->
    <div class="absolute top-1/4 -right-20 w-64 h-64 bg-orange-500 rounded-full filter blur-[100px] opacity-10"></div>
    <div class="absolute bottom-1/4 -left-20 w-64 h-64 bg-orange-500 rounded-full filter blur-[100px] opacity-10"></div>

    <div class="container mx-auto px-4 relative z-10">
        <!-- Encabezado -->
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-orange-400 font-semibold tracking-wider">CONTACTO</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-5">¿Listo para trabajar con nosotros?</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-orange-300 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">
            <!-- Formulario con efecto vidrio -->
            <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl shadow-2xl overflow-hidden" data-aos="fade-right">
                <div class="p-8 md:p-10">
                    <h3 class="text-2xl font-bold mb-6 text-orange-400">Envíanos un mensaje</h3>
                    
                    <form id="contact-form-section" class="space-y-6">
                        @csrf
                        <div>
                            <label for="contact-name-section" class="block mb-2 font-medium text-gray-300">Nombre Completo *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-orange-400">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" id="contact-name-section" name="name" required class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300" placeholder="Ingresa tu nombre">
                            </div>
                        </div>
                        
                        <div>
                            <label for="contact-email-section" class="block mb-2 font-medium text-gray-300">Correo Electrónico *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-orange-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input type="email" id="contact-email-section" name="email" required class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300" placeholder="tucorreo@ejemplo.com">
                            </div>
                        </div>
                        
                        <div>
                            <label for="contact-phone-section" class="block mb-2 font-medium text-gray-300">Teléfono</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-orange-400">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <input type="tel" id="contact-phone-section" name="phone" class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300" placeholder="+56 9 1234 5678">
                            </div>
                        </div>
                        
                        <div>
                            <label for="contact-service-section" class="block mb-2 font-medium text-gray-300">Servicio de Interés</label>
                            <select id="contact-service-section" name="service" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400">
                                <option value="">Selecciona una opción</option>
                                <option value="equipos">Equipos Mineros</option>
                                <option value="reparaciones">Reparaciones y Mantención</option>
                                <option value="estructuras">Fabricación de Estructuras</option>
                                <option value="gecomembrana">Geomembranas HDPE</option>
                                <option value="cilindros">Cilindros Hidráulicos</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="contact-message-section" class="block mb-2 font-medium text-gray-300">Mensaje *</label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 text-orange-400">
                                    <i class="fas fa-comment-dots"></i>
                                </div>
                                <textarea id="contact-message-section" name="message" rows="5" required class="w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400 transition-all duration-300" placeholder="Cuéntanos sobre tu proyecto..."></textarea>
                            </div>
                        </div>
                        
                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-orange-500/30 flex items-center justify-center">
                            <i class="fas fa-paper-plane mr-2"></i> Enviar Mensaje
                        </button>
                    </form>
                </div>
            </div>

            <!-- Información de contacto -->
            <div class="flex flex-col justify-center" data-aos="fade-left">
                <div class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl shadow-2xl overflow-hidden h-full">
                    <div class="p-8 md:p-10">
                        <h3 class="text-2xl font-bold mb-8 text-orange-400">Información de contacto</h3>
                        
                        <!-- Tarjeta de correos -->
                        <div class="mb-10 p-6 bg-white/5 rounded-xl border border-white/10 hover:border-orange-400/30 transition-all duration-300 group">
                            <h4 class="text-xl font-semibold mb-5 flex items-center text-white">
                                <span class="w-3 h-3 bg-orange-500 rounded-full mr-3"></span>
                                Correos Electrónicos
                            </h4>
                            <ul class="space-y-4">
                                <li class="flex items-start group-hover:text-white transition-colors duration-300">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <span class="block text-sm text-gray-400">Gerencia General</span>
                                        <a href="mailto:juanmiranda@geoservi.cl" class="text-base font-medium hover:text-orange-400 transition-colors duration-300">juanmiranda@geoservi.cl</a>
                                    </div>
                                </li>
                                <li class="flex items-start group-hover:text-white transition-colors duration-300">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <span class="block text-sm text-gray-400">Operaciones</span>
                                        <a href="mailto:waltersmith@geoservi.cl" class="text-base font-medium hover:text-orange-400 transition-colors duration-300">waltersmith@geoservi.cl</a>
                                    </div>
                                </li>
                                <li class="flex items-start group-hover:text-white transition-colors duration-300">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <span class="block text-sm text-gray-400">Ventas</span>
                                        <a href="mailto:ventas@geoservi.cl" class="text-base font-medium hover:text-orange-400 transition-colors duration-300">ventas@geoservi.cl</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        <!-- Tarjeta de sitio web -->
                        <div class="p-6 bg-white/5 rounded-xl border border-white/10 hover:border-orange-400/30 transition-all duration-300 group">
                            <h4 class="text-xl font-semibold mb-5 flex items-center text-white">
                                <span class="w-3 h-3 bg-orange-500 rounded-full mr-3"></span>
                                Sitio Web
                            </h4>
                            <div class="flex items-start group-hover:text-white transition-colors duration-300">
                                <div class="flex-shrink-0">
                                    <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <a href="http://www.geoservi.cl" target="_blank" class="text-base font-medium hover:text-orange-400 transition-colors duration-300">www.geoservi.cl</a>
                                    <p class="text-sm text-gray-400 mt-1">Visita nuestro sitio para más información</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- CTA adicional -->
                        <div class="mt-10 p-6 bg-gradient-to-r from-orange-500/10 to-orange-600/10 rounded-xl border border-orange-500/20">
                            <h4 class="text-xl font-semibold mb-3 text-white">¿Necesitas respuesta inmediata?</h4>
                            <p class="text-gray-300 mb-5">Contáctanos directamente por teléfono para consultas urgentes.</p>
                            <a href="tel:+56212345678" class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-bold transition-colors duration-300">
                                <i class="fas fa-phone-volume mr-2"></i> Llamar ahora
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Separador inferior SVG -->
    <div class="absolute -bottom-[1px] left-0 w-full overflow-hidden leading-[0]">
        <svg class="relative block w-full h-16" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" viewBox="0 0 1200 120">
            <path d="M321.39,56.44C207.33,35.37,92.27,14.29,0,0V120H1200V0C1078.52,22.51,957.05,45.02,835.57,66.1,714.1,87.17,592.62,106.84,471.15,90.32,399.12,80.27,360.25,65.5,321.39,56.44Z" 
                  class="fill-zinc-800"></path>
        </svg>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactFormSection = document.getElementById('contact-form-section');
        
        if (contactFormSection) {
            contactFormSection.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(contactFormSection);
                const submitButton = contactFormSection.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...';
                submitButton.disabled = true;

                fetch('{{ route("contacto.enviar") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;

                    if (data.message) {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: data.message,
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#f97316'
                        });

                        // Limpiar formulario
                        contactFormSection.reset();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al enviar el mensaje.',
                            confirmButtonText: 'Entendido',
                            confirmButtonColor: '#f97316'
                        });
                    }
                })
                .catch(error => {
                    submitButton.innerHTML = originalText;
                    submitButton.disabled = false;
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de conexión',
                        text: 'Ocurrió un error al enviar el mensaje. Por favor, inténtalo de nuevo.',
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#f97316'
                    });
                    console.error('Error:', error);
                });
            });
        }
    });
</script>
@endpush
