<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Panel Administrativo - Geoservi')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Tailwind / app (Vite) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    {{-- DataTables CSS --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
    
    <style>
        .sidebar-link {
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: linear-gradient(to bottom, #f97316, #ea580c);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .sidebar-link:hover::before,
        .sidebar-link.active::before {
            opacity: 1;
        }
        
        .notification-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        /* Estilos corregidos para el sidebar */
        .sidebar-container {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }
        
        .sidebar-content {
            flex: 1;
            overflow-y: auto;
        }
        
        .sidebar-footer {
            flex-shrink: 0;
        }
        
        /* Estilos personalizados para scrollbars - Webkit (Chrome, Safari, Edge) */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        
        ::-webkit-scrollbar-track {
            background: #18181b;
            border-radius: 4px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #3f3f46;
            border-radius: 4px;
            transition: background 0.3s ease;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }
        
        ::-webkit-scrollbar-thumb:active {
            background: #71717a;
        }
        
        /* Para scrollbars más delgados en áreas específicas */
        .thin-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .thin-scrollbar::-webkit-scrollbar-track {
            background: #27272a;
        }
        
        .thin-scrollbar::-webkit-scrollbar-thumb {
            background: #52525b;
        }
        
        /* Firefox scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: #3f3f46 #18181b;
        }
        
        .thin-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #52525b #27272a;
        }
        
        /* Ocultar scrollbar pero mantener funcionalidad en móviles */
        @media (max-width: 768px) {
            ::-webkit-scrollbar {
                width: 4px;
                height: 4px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gradient-to-br from-zinc-900 to-zinc-800 text-gray-100 min-h-screen">
    <div class="flex h-screen">
        <!-- Sidebar oscuro con acentos naranja -->
        <aside id="sidebar" class="w-64 bg-zinc-800 border-r border-orange-500/20 shadow-xl flex flex-col sidebar-container fixed md:relative top-0 left-0 h-full transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-50">
            <!-- Logo -->
            <div class="p-5 border-b border-orange-500/20 flex-shrink-0">
                <div class="flex flex-col items-center space-y-3">
                    <!-- Logo de Geoservi -->
                    <img src="{{ asset('img-pag/geoservi-logo-white.png') }}" 
                         alt="Geoservi Logo" 
                         class="h-12 w-auto object-contain filter drop-shadow-lg">
                    
                    <!-- Texto descriptivo -->
                    <div class="text-center">
                        <p class="text-xs text-gray-400 uppercase tracking-wider">Sistema de Mantenimiento</p>
                        <p class="text-xs text-orange-400 font-semibold">Panel Administrativo</p>
                    </div>
                </div>
            </div>
            
            <!-- Menú de navegación - Contenido principal del sidebar -->
            <nav class="p-4 space-y-1 sidebar-content">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200">
                    <i class="fas fa-chart-line w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Maquinarias -->
                <a href="{{ route('admin.maquinarias.index') }}" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200">
                    <i class="fas fa-truck-monster w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Maquinarias</span>
                </a>
                
                <!-- Pautas de Mantención -->
                <a href="{{ route('admin.pautas.index') }}" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200">
                    <i class="fas fa-clipboard-list w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Pautas Mantención</span>
                </a>
                
                <!-- Órdenes de Trabajo -->
                <a href="{{ route('admin.ordenes.index') }}" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200 relative">
                    <i class="fas fa-clipboard-check w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Órdenes de Trabajo</span>
                    <span class="notification-badge">3</span>
                </a>
                
                <!-- Notificaciones -->
                <a href="#" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200 relative">
                    <i class="fas fa-bell w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Notificaciones</span>
                    <span class="notification-badge">5</span>
                </a>
                
                <!-- Separador -->
                <div class="border-t border-orange-500/20 my-3"></div>

                <!-- Productos -->
                <a href="{{ route('admin.productos.create') }}" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200">
                    <i class="fas fa-box-open w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Productos</span>
                </a>
                
                <!-- Usuarios -->
                <a href="#" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200">
                    <i class="fas fa-users-cog w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Gestión de Usuarios</span>
                </a>
                
                <!-- Configuración -->
                <a href="#" class="sidebar-link flex items-center py-3 px-4 rounded-lg text-gray-300 hover:bg-zinc-700/50 hover:text-white group transition-all duration-200">
                    <i class="fas fa-cog w-5 mr-3 text-orange-400 group-hover:scale-110 transition-transform"></i>
                    <span>Configuración</span>
                </a>
            </nav>
            
            <!-- Footer del sidebar - Ahora correctamente posicionado -->
            <div class="sidebar-footer border-t border-orange-500/20 p-4">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-orange-500/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-orange-400 capitalize">{{ Auth::user()->role }}</p>
                    </div>
                </div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center py-2 px-4 rounded-lg bg-zinc-700/50 text-gray-300 hover:bg-orange-500/20 hover:text-white transition-colors duration-200 group">
                        <i class="fas fa-sign-out-alt mr-2 group-hover:animate-pulse"></i>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Header con degradado -->
            <header class="bg-gradient-to-r from-zinc-800 to-zinc-900 border-b border-orange-500/20 shadow-md p-6">
                <h2 class="text-2xl md:text-3xl font-bold text-white">
                    @yield('title', 'Panel de Control')
                </h2>
                    <button class="md:hidden text-orange-400 focus:outline-none" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                <p class="text-sm text-gray-400 mt-1">@yield('subtitle', 'Bienvenido al panel administrativo de Geoservi')</p>
            </header>

            <!-- Contenido principal -->
            <div class="p-6">
                <!-- Breadcrumbs -->
                <nav class="flex mb-6" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-orange-400">
                                <i class="fas fa-home mr-2"></i>
                                Dashboard
                            </a>
                        </li>
                        @hasSection('breadcrumb')
                            @yield('breadcrumb')
                        @endif
                    </ol>
                </nav>

                <!-- Alertas -->
                @if(session('success'))
                    <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-lg mb-6 flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-lg mb-6">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Contenido de la vista -->
                @yield('content')
            </div>
        </main>
    </div>

    {{-- jQuery + DataTables + SweetAlert2 --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Scripts personalizados --}}
    <script>
        // Inicializar DataTables
        $(document).ready(function() {
            $('.data-table').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json'
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]],
                responsive: true,
                dom: '<"flex justify-between items-center mb-4"<"flex"l><"flex"f>>rt<"flex justify-between items-center mt-4"<"flex"i><"flex"p>>'
            });
        });
        
        // Confirmación para eliminaciones
        function confirmDelete(event, title = "¿Estás seguro?", text = "Esta acción no se puede deshacer") {
            event.preventDefault();
            const form = event.target.closest('form');
            
            Swal.fire({
                title: title,
                text: text,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
        
        // Toggle sidebar en móviles
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('-translate-x-full');
    }

    </script>

    {{-- Scripts específicos de cada vista --}}
    @stack('scripts')
</body>
</html>