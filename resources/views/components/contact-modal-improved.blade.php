<!-- Modal de Contacto Mejorado -->
<div id="contact-modal-improved" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>

        <!-- Contenido del modal -->
        <div class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/10">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button id="close-modal-improved" class="text-gray-400 hover:text-white focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Formulario -->
                <div class="p-6 sm:p-8">
                    <h3 class="text-2xl font-bold text-white mb-6">Contacto Rápido</h3>
                    <form id="contact-form-improved">
                        @csrf
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="contact-name-improved" class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
                                <input type="text" id="contact-name-improved" name="name" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Tu nombre completo" required>
                            </div>
                            <div>
                                <label for="contact-email-improved" class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                                <input type="email" id="contact-email-improved" name="email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="correo@ejemplo.com" required>
                            </div>
                            <div>
                                <label for="contact-phone-improved" class="block text-sm font-medium text-gray-300 mb-1">Teléfono</label>
                                <input type="tel" id="contact-phone-improved" name="phone" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="+56 9 1234 5678">
                            </div>
                            <div>
                                <label for="contact-service-improved" class="block text-sm font-medium text-gray-300 mb-1">Servicio de Interés</label>
                                <select id="contact-service-improved" name="service" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400">
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
                                <label for="contact-message-improved" class="block text-sm font-medium text-gray-300 mb-1">Mensaje *</label>
                                <textarea id="contact-message-improved" name="message" rows="3" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Describe tu consulta o requerimiento" required></textarea>
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium py-3 px-6 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-colors duration-300 flex items-center justify-center">
                                    <i class="fas fa-paper-plane mr-2"></i> Enviar Consulta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Información de contacto -->
                <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 p-6 sm:p-8 flex flex-col justify-center">
                    <h3 class="text-xl font-bold text-white mb-6">Información de Contacto</h3>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-500/20 text-orange-400">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                            <span class="ml-4">Av. Industrial 1234, Rancagua, Región de O'Higgins</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-500/20 text-orange-400">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                            </div>
                            <a href="tel:+56941206045" class="ml-4 hover:text-orange-400 transition-colors">+56 9 4120 6045</a>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-500/20 text-orange-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <a href="mailto:pruebasgeoservi@gmail.com" class="ml-4 hover:text-orange-400 transition-colors">pruebasgeoservi@gmail.com</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script para manejar el modal mejorado -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Función para inicializar el modal
        function initContactModal() {
            const modal = document.getElementById('contact-modal-improved');
            const closeModalBtn = document.getElementById('close-modal-improved');
            const contactForm = document.getElementById('contact-form-improved');
            
            // Cerrar modal
            if (closeModalBtn) {
                closeModalBtn.addEventListener('click', function() {
                    if (modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });
            }
            
            // Cerrar modal al hacer clic fuera del contenido
            if (modal) {
                modal.addEventListener('click', function(event) {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });
            }
            
                    // Manejar envío del formulario
                    if (contactForm) {
                        contactForm.addEventListener('submit', function(e) {
                            e.preventDefault();
                            
                            // Mostrar indicador de carga
                            const submitButton = contactForm.querySelector('button[type="submit"]');
                            const originalText = submitButton.innerHTML;
                            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...';
                            submitButton.disabled = true;
                            
                            // Obtener valores del formulario
                            const formData = new FormData(contactForm);
                            
                            // Enviar datos mediante AJAX
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
                                // Restaurar botón
                                submitButton.innerHTML = originalText;
                                submitButton.disabled = false;
                                
                                if (data.success) {
                                    // Mostrar mensaje de éxito con SweetAlert
                                    Swal.fire({
                                        icon: 'success',
                                        title: '¡Éxito!',
                                        text: data.message,
                                        confirmButtonText: 'Aceptar',
                                        confirmButtonColor: '#f97316'
                                    });
                                    
                                    // Limpiar formulario
                                    contactForm.reset();
                                    
                                    // Cerrar modal después de 2 segundos
                                    setTimeout(() => {
                                        if (modal) {
                                            modal.classList.add('hidden');
                                            document.body.style.overflow = 'auto';
                                        }
                                    }, 2000);
                                } else {
                                    // Mostrar mensaje de error
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: data.message,
                                        confirmButtonText: 'Entendido',
                                        confirmButtonColor: '#f97316'
                                    });
                                }
                            })
                            .catch(error => {
                                // Restaurar botón
                                submitButton.innerHTML = originalText;
                                submitButton.disabled = false;
                                
                                // Mostrar mensaje de error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error de conexión',
                                    text: 'Ocurrió un error al enviar el formulario. Por favor, verifica tu conexión a internet e inténtalo de nuevo.',
                                    confirmButtonText: 'Entendido',
                                    confirmButtonColor: '#f97316'
                                });
                                console.error('Error:', error);
                            });
                        });
                    }
        }
        
        // Inicializar el modal
        initContactModal();
        
        // Exponer función global para abrir el modal
        window.openContactModal = function() {
            const modal = document.getElementById('contact-modal-improved');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        };
    });
</script>
