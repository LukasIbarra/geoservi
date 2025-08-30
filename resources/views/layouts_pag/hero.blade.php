<!-- Hero Carrusel con Swiper -->
<div class="relative h-screen overflow-hidden">
    <!-- Swiper Container -->
    <div class="swiper heroSwiper h-full">
        <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide relative">
                <img src="{{ asset('img-pag/content6.jpg') }}" alt="Slide 1" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                <div class="absolute inset-0 flex items-center justify-center z-10 text-white text-center px-4">
                    <div>
                        <p class="uppercase tracking-wide text-sm text-yellow-400 font-semibold mb-2">+10 años de experiencia en el rubro minero</p>

                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Soluciones Integrales para la Minería</h1>
                        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">Expertos en equipos, estructuras y mantenimiento industrial</p>
                        <div class="flex flex-wrap justify-center gap-4">
                            <a href="#servicios" class="bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-bold text-lg transition duration-300">
                                Nuestros Servicios <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <button onclick="openContactModal()" class="bg-transparent hover:bg-white hover:text-gray-900 border-2 border-white text-white px-6 py-3 rounded-lg font-bold text-lg transition duration-300">
                                Contáctenos <i class="fas fa-phone-alt ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide relative">
                <img src="{{ asset('img-pag/content4.jpg') }}" alt="Slide 2" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                <div class="absolute inset-0 flex items-center justify-center z-10 text-white text-center px-4">
                    <div>
                        <p class="uppercase tracking-wide text-sm text-yellow-400 font-semibold mb-2">Expertos en el rubro de la minería</p>

                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Representantes Oficiales de SM-EM.CL</h1>
                        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">Venta de equipos mineros, overhaul y más</p>
                        <a href="#representaciones" class="bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-bold text-lg transition duration-300">
                            Ver Representaciones
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide relative">
                <img src="{{ asset('img-pag/content8.jpg') }}" alt="Slide 3" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60"></div>
                <div class="absolute inset-0 flex items-center justify-center z-10 text-white text-center px-4">
                    <div>
                        <p class="uppercase tracking-wide text-sm text-yellow-400 font-semibold mb-2">Geomembrana</p>

                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Instalación de Geomembrana HDPE</h1>
                        <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">Precisión, resistencia y eficiencia garantizada</p>
                        <a href="#servicios" class="bg-primary hover:bg-primaryDark text-white px-6 py-3 rounded-lg font-bold text-lg transition duration-300">
                            Ver más
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Flechas -->
    <div class="swiper-button-next text-white"></div>
    <div class="swiper-button-prev text-white"></div>

    <!-- Paginación (opcional) -->
    <div class="swiper-pagination"></div>
</div>

<style>
    
</style>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper(".heroSwiper", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            effect: "fade",
            speed: 1000
        });
    });
    
</script>
@endpush

