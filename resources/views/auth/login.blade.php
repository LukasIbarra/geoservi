<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistema de Mantenimiento Geoservi</title>
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        html, body {
            height: 100%;
            overflow-x: hidden;
        }
        
        .bg-pattern {
            background-image: 
                linear-gradient(135deg, rgba(251, 146, 60, 0.1) 0%, transparent 50%),
                linear-gradient(225deg, rgba(251, 146, 60, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 20% 80%, rgba(251, 146, 60, 0.08) 0%, transparent 50%);
        }
        
        .floating {
            animation: floating 6s ease-in-out infinite;
        }
        
        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-8px); }
        }
        
        .glow-orange {
            box-shadow: 0 0 20px rgba(251, 146, 60, 0.3);
        }
        
        .input-focus {
            transition: all 0.3s ease;
        }
        
        .input-focus:focus {
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(251, 146, 60, 0.2);
        }
        
        /* Animación de partículas de fondo */
        .particle {
            position: fixed;
            pointer-events: none;
            opacity: 0.2;
            animation: float-up 20s infinite;
        }
        
        @keyframes float-up {
            0% {
                opacity: 0;
                transform: translateY(100vh) scale(0);
            }
            10% {
                opacity: 0.2;
            }
            90% {
                opacity: 0.2;
            }
            100% {
                opacity: 0;
                transform: translateY(-100vh) scale(1.5);
            }
        }
        
        /* Ajustes para pantallas pequeñas */
        @media (max-height: 700px) {
            .login-container {
                padding-top: 1rem !important;
                padding-bottom: 1rem !important;
            }
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-zinc-900 via-zinc-800 to-zinc-900 flex items-center justify-center overflow-auto">
    
    <!-- Partículas de fondo animadas (solo en pantallas grandes) -->
    <div class="hidden md:block">
        <div class="particle w-2 h-2 bg-orange-500 rounded-full" style="left: 10%; animation-delay: 0s;"></div>
        <div class="particle w-3 h-3 bg-orange-400 rounded-full" style="left: 20%; animation-delay: 3s;"></div>
        <div class="particle w-2 h-2 bg-orange-600 rounded-full" style="left: 35%; animation-delay: 6s;"></div>
        <div class="particle w-4 h-4 bg-orange-500 rounded-full" style="left: 50%; animation-delay: 9s;"></div>
        <div class="particle w-2 h-2 bg-orange-400 rounded-full" style="left: 65%; animation-delay: 12s;"></div>
        <div class="particle w-3 h-3 bg-orange-600 rounded-full" style="left: 80%; animation-delay: 15s;"></div>
        <div class="particle w-2 h-2 bg-orange-500 rounded-full" style="left: 90%; animation-delay: 18s;"></div>
    </div>
    
    <!-- Patrón de fondo -->
    <div class="fixed inset-0 bg-pattern opacity-50"></div>
    
    <!-- Contenedor principal con padding responsive -->
    <div class="relative z-10 w-full max-w-md px-4 py-6 md:py-8">
        
        <!-- Logo flotante más compacto -->
        <div class="text-center mb-4 md:mb-6 floating">
<img src="{{ asset('img-pag/geoservi-logo-white.png') }}" 
                         alt="Geoservi Logo" 
                         class="h-13 w-auto object-contain filter drop-shadow-lg object-center mx-auto ">
            <h1 class="text-2xl md:text-3xl font-bold text-white mb-1">

            </h1>
            <p class="text-gray-400 text-xs md:text-sm">Sistema de Mantenimiento Minero</p>
        </div>
        
        <!-- Card de login más compacta -->
        <div class="bg-zinc-800/90 backdrop-blur-xl rounded-xl md:rounded-2xl shadow-2xl border border-zinc-700/50 p-5 md:p-6 lg:p-8 transform hover:scale-[1.01] transition-transform duration-300 login-container">
            
            <!-- Header del card más compacto -->
            <div class="text-center mb-4 md:mb-5">
                <h2 class="text-xl md:text-2xl font-semibold text-white mb-1">Bienvenido de vuelta</h2>
                <p class="text-gray-400 text-xs md:text-sm">Ingresa tus credenciales para continuar</p>
            </div>
            
            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-3 p-2 md:p-3 bg-green-500/10 border border-green-500/20 rounded-lg">
                    <p class="text-xs md:text-sm text-green-400">{{ session('status') }}</p>
                </div>
            @endif
            
            <!-- Formulario con espaciado más compacto -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4 md:space-y-5">
                @csrf
                
                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="text-xs md:text-sm font-medium text-gray-300 flex items-center">
                        <i class="fas fa-envelope mr-2 text-orange-400 text-xs"></i>
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus 
                            autocomplete="username"
                            placeholder="admin@geoservi.com"
                            class="w-full px-3 py-2 md:px-4 md:py-2.5 bg-zinc-900/50 border border-zinc-600 rounded-lg text-sm md:text-base text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-focus transition-all duration-300"
                        >
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-at text-gray-500 text-sm"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="text-red-400 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Password -->
                <div class="space-y-1">
                    <label for="password" class="text-xs md:text-sm font-medium text-gray-300 flex items-center">
                        <i class="fas fa-lock mr-2 text-orange-400 text-xs"></i>
                        Contraseña
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full px-3 py-2 md:px-4 md:py-2.5 bg-zinc-900/50 border border-zinc-600 rounded-lg text-sm md:text-base text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 input-focus transition-all duration-300"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-orange-400 transition-colors">
                            <i id="toggleIcon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-400 text-xs mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1 text-xs"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Remember Me & Forgot Password -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                    <label for="remember_me" class="flex items-center cursor-pointer group">
                        <input 
                            id="remember_me" 
                            type="checkbox" 
                            name="remember"
                            class="w-3.5 h-3.5 bg-zinc-900 border-zinc-600 rounded text-orange-500 focus:ring-orange-500 focus:ring-offset-0 focus:ring-2 transition-all duration-200"
                        >
                        <span class="ml-2 text-xs md:text-sm text-gray-400 group-hover:text-gray-300 transition-colors">
                            Recordarme
                        </span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs md:text-sm text-orange-400 hover:text-orange-300 transition-colors duration-200 flex items-center group">
                            <span>¿Olvidaste tu contraseña?</span>
                            <i class="fas fa-arrow-right ml-1 text-xs group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    @endif
                </div>
                
                <!-- Submit Button más compacto -->
                <button 
                    type="submit" 
                    class="w-full py-2.5 md:py-3 px-4 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white text-sm md:text-base font-semibold rounded-lg shadow-lg hover:shadow-orange-500/25 transform hover:scale-[1.01] transition-all duration-300 flex items-center justify-center space-x-2 group"
                >
                    <span>Iniciar Sesión</span>
                    <i class="fas fa-sign-in-alt text-sm group-hover:translate-x-1 transition-transform"></i>
                </button>
                
                <!-- Divider más compacto -->
                <div class="relative my-3 md:my-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-zinc-700"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-zinc-800 text-gray-500">O</span>
                    </div>
                </div>
                
                <!-- Demo Access Info más compacto -->
                <div class="bg-zinc-900/50 rounded-lg p-3 md:p-4 border border-zinc-700">
                    <div class="flex items-start space-x-2">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-orange-400 text-sm mt-0.5"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 leading-relaxed">
                                <span class="font-semibold text-gray-300">Acceso Demo:</span><br>
                                Email: admin@example.com<br>
                                Contraseña: password
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Footer más compacto y oculto en móviles muy pequeños -->
        <div class="text-center mt-4 md:mt-6">
            <p class="text-xs text-gray-500 hidden sm:block">
                © 2024 Geoservi - Sistema de Mantenimiento Minero
            </p>
            <div class="flex items-center justify-center space-x-3 md:space-x-4 mt-2">
                <a href="#" class="text-gray-500 hover:text-orange-400 transition-colors">
                    <i class="fab fa-facebook text-sm"></i>
                </a>
                <a href="#" class="text-gray-500 hover:text-orange-400 transition-colors">
                    <i class="fab fa-twitter text-sm"></i>
                </a>
                <a href="#" class="text-gray-500 hover:text-orange-400 transition-colors">
                    <i class="fab fa-linkedin text-sm"></i>
                </a>
                <a href="#" class="text-gray-500 hover:text-orange-400 transition-colors">
                    <i class="fab fa-instagram text-sm"></i>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
        
        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.bg-zinc-800\\/90');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
