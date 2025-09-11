<!-- Modal de Contacto -->
<div id="contact-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Overlay -->
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
        </div>

        <!-- Contenido del modal -->
        <div class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full border border-white/10">
            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button id="close-modal" class="text-gray-400 hover:text-white focus:outline-none">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2">
                <!-- Formulario -->
                <div class="p-6 sm:p-8">
                    <h3 class="text-2xl font-bold text-white mb-6">Contacto Rápido</h3>
                    <form id="contact-form">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="contact-name" class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
                                <input type="text" id="contact-name" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Tu nombre completo" required>
                            </div>
                            <div>
                                <label for="contact-email" class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                                <input type="email" id="contact-email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="correo@ejemplo.com" required>
                            </div>
                            <div>
                                <label for="contact-phone" class="block text-sm font-medium text-gray-300 mb-1">Teléfono</label>
                                <input type="tel" id="contact-phone" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="+56 9 3116 5525">
                            </div>
                            <div>
                                <label for="contact-service" class="block text-sm font-medium text-gray-300 mb-1">Servicio de Interés</label>
                                <select id="contact-service" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400">
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
                                <label for="contact-message" class="block text-sm font-medium text-gray-300 mb-1">Mensaje *</label>
                                <textarea id="contact-message" rows="3" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Describe tu consulta o requerimiento" required></textarea>
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
                            <span class="ml-4">Araucania edif 1 5427 105 Espacio la florida La serena</span>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-500/20 text-orange-400">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                            </div>
                            <a href="tel:+56931165525" class="ml-4 hover:text-orange-400 transition-colors">+56 9 3116 5525</a>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-500/20 text-orange-400">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <a href="mailto:ventas@geoservi.cl" class="ml-4 hover:text-orange-400 transition-colors">ventas@geoservi.cl</a>
                        </li>
                        <li class="flex items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="flex items-center justify-center h-10 w-10 rounded-full bg-orange-500/20 text-orange-400">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <p class="font-medium">Horario de Atención:</p>
                                <p>Lunes a Viernes: 8:30 - 18:30 hrs</p>
                                <p>Sábado: 9:00 - 14:00 hrs</p>
                            </div>
                        </li>
                    </ul>
                    
                    <div class="mt-4">
                        <h4 class="text-lg font-bold text-white mb-4">Síguenos</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="h-12 w-12 flex items-center justify-center bg-white/5 hover:bg-orange-500 rounded-full transition-colors duration-300 group">
                                <i class="fab fa-linkedin-in text-gray-300 group-hover:text-white"></i>
                            </a>
                            <a href="#" class="h-12 w-12 flex items-center justify-center bg-white/5 hover:bg-orange-500 rounded-full transition-colors duration-300 group">
                                <i class="fab fa-facebook-f text-gray-300 group-hover:text-white"></i>
                            </a>
                            <a href="#" class="h-12 w-12 flex items-center justify-center bg-white/5 hover:bg-orange-500 rounded-full transition-colors duration-300 group">
                                <i class="fab fa-instagram text-gray-300 group-hover:text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botón flotante para abrir el modal -->
<button id="open-contact-modal" class="fixed bottom-6 right-24 bg-orange-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-orange-600 transition-colors z-40">
    <i class="fas fa-comments text-xl"></i>
</button>

<!-- Script para manejar el modal -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('contact-modal');
        const openModalBtn = document.getElementById('open-contact-modal');
        const closeModalBtn = document.getElementById('close-modal');
        const contactForm = document.getElementById('contact-form');
        
        // Abrir modal
        openModalBtn.addEventListener('click', function() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
        
        // Cerrar modal
        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
        
        // Cerrar modal al hacer clic fuera del contenido
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
            }
        });
        
        // Manejar envío del formulario
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Obtener valores del formulario
            const name = document.getElementById('contact-name').value;
            const email = document.getElementById('contact-email').value;
            const phone = document.getElementById('contact-phone').value;
            const service = document.getElementById('contact-service').value;
            const message = document.getElementById('contact-message').value;
            
            // Aquí normalmente enviarías los datos a tu backend
            // Por ahora, solo mostraremos una alerta
            alert(`Gracias ${name} por tu mensaje. Nos pondremos en contacto contigo pronto.`);
            
            // Limpiar formulario
            contactForm.reset();
            
            // Cerrar modal
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        });
    });
</script>
