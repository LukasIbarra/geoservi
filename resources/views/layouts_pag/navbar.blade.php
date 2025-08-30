<nav class="bg-zinc-900 text-white shadow-lg sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-20">
            <!-- Logo con efecto hover -->
            <div class="flex items-center space-x-2 group">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('img-pag/geoservi-logo-white.png') }}" alt="Geoservi Logo" class="h-12 transition-transform duration-300 group-hover:scale-105">
                </a>
            </div>
            
            <!-- Menú principal desktop -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="{{ url('/') }}" class="px-4 py-2 font-medium text-gray-300 hover:text-orange-400 hover:bg-zinc-800 rounded-lg transition-all duration-300 flex items-center group">
                    <i class="fas fa-home mr-2 group-hover:text-orange-400"></i>
                    Inicio
                </a>
                
                <div class="relative group">
                    <a href="{{ url('/servicios') }}" class="px-4 py-2 font-medium text-gray-300 hover:text-orange-400 hover:bg-zinc-800 rounded-lg transition-all duration-300 flex items-center">
                        <i class="fas fa-cogs mr-2 group-hover:text-orange-400"></i>
                        Servicios
                        <i class="fas fa-chevron-down ml-2 text-xs"></i>
                    </a>
                    <!-- Submenú desplegable -->
                    <div class="absolute left-0 mt-2 w-56 bg-zinc-800 rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-50">
                        <div class="py-1">
                            <a href="{{ url('/equipo') }}" class="block px-4 py-2 text-gray-300 hover:bg-zinc-700 hover:text-orange-400 transition duration-300">
                                <i class="fas fa-cog mr-2"></i> Equipos y Reparaciones
                            </a>
                            <a href="{{ url('/estructura') }}" class="block px-4 py-2 text-gray-300 hover:bg-zinc-700 hover:text-orange-400 transition duration-300">
                                <i class="fas fa-industry mr-2"></i> Estructuras
                            </a>
                            <a href="{{ url('/geom') }}" class="block px-4 py-2 text-gray-300 hover:bg-zinc-700 hover:text-orange-400 transition duration-300">
                                <i class="fas fa-layer-group mr-2"></i> Geomembranas
                            </a>
                            <a href="{{ url('/cilindros') }}" class="block px-4 py-2 text-gray-300 hover:bg-zinc-700 hover:text-orange-400 transition duration-300">
                                <i class="fas fa-tools mr-2"></i> Cilindros Hidráulicos
                            </a>
                        </div>
                    </div>
                </div>
                
                <a href="{{ url('/represent') }}" class="px-4 py-2 font-medium text-gray-300 hover:text-orange-400 hover:bg-zinc-800 rounded-lg transition-all duration-300 flex items-center group">
                    <i class="fas fa-handshake mr-2 group-hover:text-orange-400"></i>
                    Representaciones
                </a>
                
                <a href="{{ url('/nosotros') }}" class="px-4 py-2 font-medium text-gray-300 hover:text-orange-400 hover:bg-zinc-800 rounded-lg transition-all duration-300 flex items-center group">
                    <i class="fas fa-building mr-2 group-hover:text-orange-400"></i>
                    Nosotros
                </a>
                
                <a href="{{ url('/contacto') }}" class="px-4 py-2 font-medium text-gray-300 hover:text-orange-400 hover:bg-zinc-800 rounded-lg transition-all duration-300 flex items-center group">
                    <i class="fas fa-envelope mr-2 group-hover:text-orange-400"></i>
                    Contacto
                </a>
            </div>
            
            <!-- Botón de acceso clientes -->
            <div class="hidden md:block ml-4">
                <a href="/login" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-gray-900 px-6 py-2 rounded-lg font-medium transition-all duration-300 shadow-lg hover:shadow-orange-500/30 flex items-center">
                    <i class="fas fa-user-circle mr-2"></i>
                    Acceso Clientes
                </a>
            </div>
            
            <!-- Menú móvil button -->
            <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none p-2 rounded-lg hover:bg-zinc-800 transition duration-300">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </div>
    
    <!-- Menú móvil (oculto por defecto) -->
    <div id="mobile-menu" class="md:hidden hidden bg-zinc-800 transition-all duration-300 max-h-0 overflow-hidden">
        <div class="container mx-auto px-4 py-2">
            <a href="#" class="block py-3 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                <i class="fas fa-home mr-3"></i> Inicio
            </a>
            <div class="relative">
                <button id="services-dropdown-button" class="w-full text-left py-3 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300 flex justify-between items-center">
                    <span><i class="fas fa-cogs mr-3"></i> Servicios</span>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-300"></i>
                </button>
                <div id="services-dropdown" class="pl-6 hidden">
                    <a href="#equipos" class="block py-2 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                        <i class="fas fa-cog mr-2"></i> Equipos
                    </a>
                    <a href="#estructuras" class="block py-2 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                        <i class="fas fa-industry mr-2"></i> Estructuras
                    </a>
                    <a href="#gecomembranas" class="block py-2 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                        <i class="fas fa-layer-group mr-2"></i> Geomembranas
                    </a>
                    <a href="#cilindros" class="block py-2 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                        <i class="fas fa-tools mr-2"></i> Cilindros
                    </a>
                </div>
            </div>
            <a href="#representaciones" class="block py-3 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                <i class="fas fa-handshake mr-3"></i> Representaciones
            </a>
            <a href="#nosotros" class="block py-3 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                <i class="fas fa-building mr-3"></i> Nosotros
            </a>
            <a href="#contacto" class="block py-3 px-4 text-gray-300 hover:text-orange-400 hover:bg-zinc-700 rounded-lg transition duration-300">
                <i class="fas fa-envelope mr-3"></i> Contacto
            </a>
            <a href="/login" class="block mt-2 py-2 px-4 bg-orange-500 hover:bg-orange-600 text-gray-900 rounded-lg font-medium text-center transition duration-300">
                <i class="fas fa-user-circle mr-2"></i> Acceso Clientes
            </a>
        </div>
    </div>
</nav>

<!-- Script para el menú móvil -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const servicesDropdownButton = document.getElementById('services-dropdown-button');
        const servicesDropdown = document.getElementById('services-dropdown');
        
        // Toggle menú móvil principal
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('max-h-0');
            mobileMenu.classList.toggle('py-2');
            mobileMenu.classList.toggle('max-h-screen');
        });
        
        // Toggle submenú de servicios en móvil
        servicesDropdownButton.addEventListener('click', function() {
            servicesDropdown.classList.toggle('hidden');
            const icon = this.querySelector('.fa-chevron-down');
            icon.classList.toggle('transform');
            icon.classList.toggle('rotate-180');
        });
        
        // Cerrar menú al hacer clic en un enlace (opcional)
        const mobileLinks = document.querySelectorAll('#mobile-menu a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('py-2');
                mobileMenu.classList.add('max-h-0');
                mobileMenu.classList.remove('max-h-screen');
            });
        });
    });
</script>