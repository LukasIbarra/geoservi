@extends('layouts_pag.app')

@section('title', 'Contacto')

@section('content')
@include('layouts_pag.flotantes')

<!-- Sección Contacto -->
<section id="contacto" class="relative py-24 bg-gradient-to-b from-[#0a0a0a] via-[#141414] to-[#0a0a0a] text-white overflow-hidden">
    <!-- Modal de Contacto -->
    @include('components.contact-modal-improved')
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
            <span class="text-orange-400 font-semibold tracking-wider uppercase text-sm">Conecta con nosotros</span>
            <h2 class="text-4xl md:text-5xl font-bold mt-3 mb-5 bg-clip-text text-transparent bg-gradient-to-r from-orange-400 to-orange-600">
                Contacto
            </h2>
            <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-orange-300 mx-auto rounded-full"></div>
            <p class="max-w-2xl mx-auto mt-6 text-gray-300">Estamos listos para responder tus consultas, cotizaciones y propuestas de colaboración.</p>
        </div>

        <!-- Pestañas de formularios -->
        <div class="max-w-4xl mx-auto mb-12" data-aos="fade-up">
            <div class="flex flex-wrap border-b border-white/10">
                <button class="tab-button active px-6 py-3 font-medium text-white border-b-2 border-orange-500" data-tab="empresas">
                    <i class="fas fa-building mr-2"></i> Empresas
                </button>
                <button class="tab-button px-6 py-3 font-medium text-gray-400 hover:text-white transition-colors" data-tab="proveedores">
                    <i class="fas fa-truck mr-2"></i> Proveedores
                </button>
                <button class="tab-button px-6 py-3 font-medium text-gray-400 hover:text-white transition-colors" data-tab="trabajo">
                    <i class="fas fa-briefcase mr-2"></i> Trabajar con nosotros
                </button>
            </div>
        </div>

        <!-- Contenido de pestañas -->
        <div class="max-w-4xl mx-auto">
            <!-- Formulario Empresas (activo por defecto) -->
            <div id="empresas-tab" class="tab-content active" data-aos="fade-up">
                <div class="bg-zinc-900/50 border border-white/10 rounded-xl overflow-hidden shadow-2xl">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <!-- Formulario -->
                        <div class="p-8 md:p-10">
                            <h3 class="text-2xl font-bold text-white mb-6">Consulta para Empresas</h3>
                            <form id="empresa-form" class="space-y-6">
                                @csrf
                                <div>
                                    <label for="empresa-nombre" class="block text-sm font-medium text-gray-300 mb-1">Nombre de Empresa *</label>
                                    <input type="text" id="empresa-nombre" name="company" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Ingresa el nombre de tu empresa" required>
                                </div>
                                <div>
                                    <label for="empresa-contacto" class="block text-sm font-medium text-gray-300 mb-1">Persona de Contacto *</label>
                                    <input type="text" id="empresa-contacto" name="name" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Nombre completo" required>
                                </div>
                                <div>
                                    <label for="empresa-email" class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                                    <input type="email" id="empresa-email" name="email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="correo@empresa.com" required>
                                </div>
                                <div>
                                    <label for="empresa-telefono" class="block text-sm font-medium text-gray-300 mb-1">Teléfono *</label>
                                    <input type="tel" id="empresa-telefono" name="phone" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="+56 9 3116 5525" required>
                                </div>
                                <div>
                                    <label for="empresa-servicio" class="block text-sm font-medium text-gray-300 mb-1">Servicio de Interés</label>
                                    <select id="empresa-servicio" name="service" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400">
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
                                    <label for="empresa-mensaje" class="block text-sm font-medium text-gray-300 mb-1">Mensaje *</label>
                                    <textarea id="empresa-mensaje" name="message" rows="4" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Describe tu consulta o requerimiento" required></textarea>
                                </div>
                                <div>
                                    <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium py-3 px-6 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-colors duration-300 flex items-center justify-center">
                                        <i class="fas fa-paper-plane mr-2"></i> Enviar Consulta
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Info de contacto -->
                        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 p-8 md:p-10 flex flex-col justify-center">
                            <h3 class="text-xl font-bold text-white mb-6">Información de Contacto</h3>
                            <ul class="space-y-4">
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
                            <span class="ml-4">+56 9 3116 5525</span>
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
                            
                            <div class="mt-8">
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

            <!-- Formulario Proveedores -->
            <div id="proveedores-tab" class="tab-content hidden" data-aos="fade-up">
                <div class="bg-zinc-900/50 border border-white/10 rounded-xl overflow-hidden shadow-2xl">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <!-- Formulario -->
                        <div class="p-8 md:p-10">
                            <h3 class="text-2xl font-bold text-white mb-6">Formulario para Proveedores</h3>
                            <form>
                                <div class="grid grid-cols-1 gap-6">
                                    <div>
                                        <label for="proveedor-empresa" class="block text-sm font-medium text-gray-300 mb-1">Nombre de Empresa *</label>
                                        <input type="text" id="proveedor-empresa" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Nombre de tu empresa" required>
                                    </div>
                                    <div>
                                        <label for="proveedor-contacto" class="block text-sm font-medium text-gray-300 mb-1">Persona de Contacto *</label>
                                        <input type="text" id="proveedor-contacto" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Nombre completo" required>
                                    </div>
                                    <div>
                                        <label for="proveedor-email" class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                                        <input type="email" id="proveedor-email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="correo@empresa.com" required>
                                    </div>
                                    <div>
                                        <label for="proveedor-telefono" class="block text-sm font-medium text-gray-300 mb-1">Teléfono *</label>
                                    <input type="tel" id="proveedor-telefono" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="+56 9 3116 5525" required>
                                    </div>
                                    <div>
                                        <label for="proveedor-rubro" class="block text-sm font-medium text-gray-300 mb-1">Rubro de Proveedor *</label>
                                        <select id="proveedor-rubro" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" required>
                                            <option value="">Selecciona tu rubro</option>
                                            <option value="equipos">Equipos Mineros</option>
                                            <option value="repuestos">Repuestos y Componentes</option>
                                            <option value="servicios">Servicios Técnicos</option>
                                            <option value="materiales">Materiales Industriales</option>
                                            <option value="tecnologia">Tecnología Minera</option>
                                            <option value="otros">Otros</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="proveedor-productos" class="block text-sm font-medium text-gray-300 mb-1">Productos/Servicios que Ofrece *</label>
                                        <textarea id="proveedor-productos" rows="3" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Describe los productos o servicios que ofrece tu empresa" required></textarea>
                                    </div>
                                    <div>
                                        <label for="proveedor-experiencia" class="block text-sm font-medium text-gray-300 mb-1">Experiencia en el Rubro *</label>
                                        <textarea id="proveedor-experiencia" rows="2" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Breve descripción de tu experiencia en el sector" required></textarea>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="proveedor-terminos" type="checkbox" class="w-4 h-4 bg-white/5 border border-white/10 rounded focus:ring-orange-500 focus:ring-2" required>
                                        </div>
                                        <label for="proveedor-terminos" class="ml-2 text-sm text-gray-300">
                                            Acepto los <a href="#" class="text-orange-400 hover:underline">términos y condiciones</a> y autorizo el uso de mis datos para fines comerciales.
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium py-3 px-6 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-colors duration-300 flex items-center justify-center">
                                            <i class="fas fa-handshake mr-2"></i> Enviar Solicitud
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Beneficios para proveedores -->
                        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 p-8 md:p-10 flex flex-col justify-center">
                            <h3 class="text-xl font-bold text-white mb-6">Ventajas de ser Proveedor de Geoservi</h3>
                            <ul class="space-y-5">
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-chart-line"></i>
                                        </div>
                                    </div>
                                    <span class="ml-4">
                                        <strong class="text-white">Mayor visibilidad:</strong> Acceso a nuestra cartera de clientes en el sector minero e industrial.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-bullseye"></i>
                                        </div>
                                    </div>
                                    <span class="ml-4">
                                        <strong class="text-white">Oportunidades de negocio:</strong> Participación en licitaciones y proyectos estratégicos.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-users"></i>
                                        </div>
                                    </div>
                                    <span class="ml-4">
                                        <strong class="text-white">Red de contactos:</strong> Integración a nuestra red de proveedores calificados.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-file-contract"></i>
                                        </div>
                                    </div>
                                    <span class="ml-4">
                                        <strong class="text-white">Contratos claros:</strong> Relaciones comerciales transparentes y a largo plazo.
                                    </span>
                                </li>
                                <li class="flex items-start">
                                    <div class="flex-shrink-0 mt-1">
                                        <div class="flex items-center justify-center h-8 w-8 rounded-full bg-orange-500/20 text-orange-400">
                                            <i class="fas fa-shield-alt"></i>
                                        </div>
                                    </div>
                                    <span class="ml-4">
                                        <strong class="text-white">Respaldo profesional:</strong> Aval de Geoservi como representante en la región.
                                    </span>
                                </li>
                            </ul>
                            
                            <div class="mt-8 bg-zinc-700/30 rounded-lg p-6 border border-white/10">
                                <h4 class="text-lg font-bold text-white mb-3 flex items-center">
                                    <i class="fas fa-info-circle text-orange-400 mr-2"></i> Proceso de Evaluación
                                </h4>
                                <p class="text-gray-300 text-sm">Todas las solicitudes son evaluadas por nuestro equipo de compras. Nos contactaremos dentro de los 5 días hábiles para informar los resultados del proceso de calificación.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Formulario Trabajar con Nosotros -->
            <div id="trabajo-tab" class="tab-content hidden" data-aos="fade-up">
                <div class="bg-zinc-900/50 border border-white/10 rounded-xl overflow-hidden shadow-2xl">
                    <div class="grid grid-cols-1 lg:grid-cols-2">
                        <!-- Formulario -->
                        <div class="p-8 md:p-10">
                            <h3 class="text-2xl font-bold text-white mb-6">Únete a Nuestro Equipo</h3>
                            <form>
                                <div class="grid grid-cols-1 gap-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="trabajo-nombre" class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
                                            <input type="text" id="trabajo-nombre" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Nombre completo" required>
                                        </div>
                                        <div>
                                            <label for="trabajo-email" class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                                            <input type="email" id="trabajo-email" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="correo@ejemplo.com" required>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label for="trabajo-telefono" class="block text-sm font-medium text-gray-300 mb-1">Teléfono *</label>
                                            <input type="tel" id="trabajo-telefono" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="+56 9 3116 5525" required>
                                        </div>
                                        <div>
                                            <label for="trabajo-ciudad" class="block text-sm font-medium text-gray-300 mb-1">Ciudad/Región *</label>
                                            <input type="text" id="trabajo-ciudad" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Ciudad donde resides" required>
                                        </div>
                                    </div>
                                    <div>
                                        <label for="trabajo-cargo" class="block text-sm font-medium text-gray-300 mb-1">Área de Interés *</label>
                                        <select id="trabajo-cargo" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" required>
                                            <option value="">Selecciona un área</option>
                                            <option value="tecnico">Técnico Especializado</option>
                                            <option value="operaciones">Operaciones y Logística</option>
                                            <option value="ventas">Ventas y Comercial</option>
                                            <option value="administracion">Administración</option>
                                            <option value="ingenieria">Ingeniería y Proyectos</option>
                                            <option value="otros">Otros</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="trabajo-experiencia" class="block text-sm font-medium text-gray-300 mb-1">Experiencia Laboral *</label>
                                        <textarea id="trabajo-experiencia" rows="3" class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400" placeholder="Describe tu experiencia laboral relevante" required></textarea>
                                    </div>
                                    <div>
                                        <label for="trabajo-cv" class="block text-sm font-medium text-gray-300 mb-1">Adjuntar CV (PDF) *</label>
                                        <div class="flex items-center justify-center w-full">
                                            <label for="trabajo-cv" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-white/10 rounded-lg cursor-pointer bg-white/5 hover:bg-white/10 transition-colors">
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <i class="fas fa-cloud-upload-alt text-2xl text-orange-400 mb-2"></i>
                                                    <p class="mb-2 text-sm text-gray-300">Haz clic para subir tu CV</p>
                                                    <p class="text-xs text-gray-400">PDF (Máx. 5MB)</p>
                                                </div>
                                                <input id="trabajo-cv" type="file" class="hidden" accept=".pdf" required>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input id="trabajo-terminos" type="checkbox" class="w-4 h-4 bg-white/5 border border-white/10 rounded focus:ring-orange-500 focus:ring-2" required>
                                        </div>
                                        <label for="trabajo-terminos" class="ml-2 text-sm text-gray-300">
                                            Autorizo el tratamiento de mis datos personales para procesos de selección.
                                        </label>
                                    </div>
                                    <div>
                                        <button type="submit" class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-medium py-3 px-6 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-colors duration-300 flex items-center justify-center">
                                            <i class="fas fa-user-tie mr-2"></i> Enviar Solicitud
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Oportunidades laborales -->
                        <div class="bg-gradient-to-br from-zinc-800 to-zinc-900 p-8 md:p-10 flex flex-col justify-center">
                            <h3 class="text-xl font-bold text-white mb-6">Oportunidades en Geoservi</h3>
                            <p class="text-gray-300 mb-6">En Geoservi valoramos el talento, la dedicación y el compromiso con la excelencia. Únete a un equipo en constante crecimiento en el sector minero e industrial.</p>
                            
                            <div class="space-y-6">
                                <div class="bg-zinc-700/30 rounded-lg p-5 border border-white/10 hover:border-orange-500/50 transition-colors">
                                    <h4 class="font-bold text-white mb-2 flex items-center">
                                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                        Técnicos Especializados
                                    </h4>
                                    <p class="text-sm text-gray-300">Buscamos profesionales con experiencia en mantención y reparación de equipos mineros e industriales.</p>
                                </div>
                                
                                <div class="bg-zinc-700/30 rounded-lg p-5 border border-white/10 hover:border-orange-500/50 transition-colors">
                                    <h4 class="font-bold text-white mb-2 flex items-center">
                                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                        Ejecutivos Comerciales
                                    </h4>
                                    <p class="text-sm text-gray-300">Perfiles con experiencia en ventas técnicas y conocimiento del rubro minero/industrial.</p>
                                </div>
                                
                                <div class="bg-zinc-700/30 rounded-lg p-5 border border-white/10 hover:border-orange-500/50 transition-colors">
                                    <h4 class="font-bold text-white mb-2 flex items-center">
                                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                        Ingenieros de Proyectos
                                    </h4>
                                    <p class="text-sm text-gray-300">Profesionales con capacidad de gestión y coordinación de proyectos mineros e industriales.</p>
                                </div>
                                
                                <div class="bg-zinc-700/30 rounded-lg p-5 border border-white/10 hover:border-orange-500/50 transition-colors">
                                    <h4 class="font-bold text-white mb-2 flex items-center">
                                        <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
                                        Prácticas Profesionales
                                    </h4>
                                    <p class="text-sm text-gray-300">Oportunidades para estudiantes de carreras técnicas y profesionales afines.</p>
                                </div>
                            </div>
                            
                            <div class="mt-8 bg-orange-500/10 rounded-lg p-6 border border-orange-500/20">
                                <h4 class="text-lg font-bold text-white mb-3 flex items-center">
                                    <i class="fas fa-lightbulb text-orange-400 mr-2"></i> Beneficios
                                </h4>
                                <ul class="space-y-2 text-sm text-gray-300">
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-orange-400 text-xs mt-1 mr-2"></i>
                                        <span>Contrato estable según competencias</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-orange-400 text-xs mt-1 mr-2"></i>
                                        <span>Capacitaciones continuas</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-orange-400 text-xs mt-1 mr-2"></i>
                                        <span>Ambiente de trabajo colaborativo</span>
                                    </li>
                                    <li class="flex items-start">
                                        <i class="fas fa-check text-orange-400 text-xs mt-1 mr-2"></i>
                                        <span>Oportunidades de crecimiento</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mapa -->
        <div class="max-w-4xl mx-auto mt-20 rounded-xl overflow-hidden shadow-2xl border border-white/10" data-aos="fade-up">
            <div class="aspect-w-16 aspect-h-9 bg-zinc-800 flex items-center justify-center">
                <div class="text-center p-8">
                    <div class="w-20 h-20 bg-orange-500/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-map-marked-alt text-orange-400 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Nuestra Ubicación</h3>
                    <p class="text-gray-300 mb-4">Araucania EDIF 1 5427 105 Espacio La Florida | La Serena</p>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3457.7444575961204!2d-71.20835279039987!3d-29.929258174877432!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9691cb0013c311e7%3A0x6ae241b22bc34877!2sCondominio%20Espacio%20La%20Florida!5e0!3m2!1ses-419!2scl!4v1756759003667!5m2!1ses-419!2scl" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    <a href="https://maps.google.com" target="_blank" class="inline-flex items-center text-orange-400 hover:text-white group text-sm font-medium">
                        Ver en Google Maps
                        <i class="fas fa-external-link-alt ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
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

    <!-- Script para pestañas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // Remover clases activas
                    tabButtons.forEach(btn => {
                        btn.classList.remove('active', 'text-white', 'border-orange-500');
                        btn.classList.add('text-gray-400');
                    });
                    tabContents.forEach(content => content.classList.add('hidden'));
                    
                    // Añadir clases activas
                    button.classList.add('active', 'text-white', 'border-orange-500');
                    button.classList.remove('text-gray-400');
                    
                    const tabId = button.getAttribute('data-tab') + '-tab';
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
    </script>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const empresaForm = document.getElementById('empresa-form');
        
        if (empresaForm) {
            empresaForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(empresaForm);
                const submitButton = empresaForm.querySelector('button[type="submit"]');
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
                        empresaForm.reset();
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
    
@endsection
