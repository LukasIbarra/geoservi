@extends('layouts_pag.app')

@section('title', 'Inicio')

@section('content')
    @include('layouts_pag.hero')
    @include('layouts_pag.servicios')
    @include('layouts_pag.vision')

<section class="py-16 bg-gradient-to-b from-zinc-900 to-zinc-800">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Nuestro Catálogo Completo</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-orange-500 to-orange-300 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @foreach($productos as $producto)
            <div class="bg-zinc-800 rounded-xl overflow-hidden shadow-lg hover:shadow-orange-500/20 transition-shadow">
                <div class="h-48 overflow-hidden">
                    <img src="{{ asset('storage/' . $producto->image) }}" alt="{{ $producto->name }}" 
                         class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-white mb-2">{{ $producto->name }}</h3>
                    <p class="text-gray-300 text-sm mb-4">{{ $producto->description }}</p>
                    <div class="flex justify-between items-center">
                        <p class="text-orange-400 font-bold text-lg">${{ number_format($producto->price, 0, ',', '.') }}</p>
                        <button class="add-to-cart bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-lg transition-colors"
                                data-product-id="{{ $producto->id }}"
                                data-product-name="{{ $producto->name }}"
                                data-product-price="{{ $producto->price }}">
                            <i class="fas fa-cart-plus mr-2"></i> Cotizar
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
        @include('layouts_pag.representaciones')
    @include('layouts_pag.contactos')
@include('layouts_pag.flotantes')
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const cart = {
        items: [],
        addItem(product) {
            const existingItem = this.items.find(item => item.id === product.id);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                this.items.push({
                    id: product.id,
                    name: product.name,
                    price: product.price,
                    quantity: 1
                });
            }
            this.updateCart();
        },
        updateCart() {
            const cartItemsContainer = document.getElementById('cart-items');
            const cartCount = document.getElementById('cart-count');
            const cartBadge = document.getElementById('cart-badge');
            const cartTotal = document.getElementById('cart-total');
            const whatsappLink = document.getElementById('whatsapp-link');
            
            cartItemsContainer.innerHTML = '';
            
            let total = 0;
            this.items.forEach(item => {
                total += item.price * item.quantity;
                
                const itemElement = document.createElement('div');
                itemElement.className = 'flex justify-between items-center mb-3 pb-3 border-b border-white/10';
                itemElement.innerHTML = `
                    <div>
                        <h4 class="text-white">${item.name}</h4>
                        <p class="text-sm text-gray-300">$${item.price.toLocaleString()} x ${item.quantity}</p>
                    </div>
                    <div class="flex items-center">
                        <button class="decrease-quantity text-orange-400 px-2" data-id="${item.id}">
                            <i class="fas fa-minus"></i>
                        </button>
                        <span class="mx-2 text-white">${item.quantity}</span>
                        <button class="increase-quantity text-orange-400 px-2" data-id="${item.id}">
                            <i class="fas fa-plus"></i>
                        </button>
                        <button class="remove-item text-red-400 ml-2 px-2" data-id="${item.id}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                `;
                cartItemsContainer.appendChild(itemElement);
            });
            
            const itemCount = this.items.reduce((sum, item) => sum + item.quantity, 0);
            cartCount.textContent = itemCount;
            cartBadge.textContent = itemCount;
            cartTotal.textContent = `$${total.toLocaleString()}`;
            
            if (itemCount > 0) {
                cartBadge.classList.remove('hidden');
            } else {
                cartBadge.classList.add('hidden');
            }
            
            // Generar mensaje de WhatsApp
            const message = `Hola, estoy interesado en cotizar los siguientes productos:\n\n${
                this.items.map(item => 
                    `- ${item.name} (${item.quantity} unidades): $${(item.price * item.quantity).toLocaleString()}`
                ).join('\n')
            }\n\nTotal: $${total.toLocaleString()}\n\nPor favor contáctenme para continuar con el proceso.`;
            
            whatsappLink.href = `https://wa.me/569XXXXXXXX?text=${encodeURIComponent(message)}`;
        },
        removeItem(id) {
            this.items = this.items.filter(item => item.id !== id);
            this.updateCart();
        },
        updateQuantity(id, change) {
            const item = this.items.find(item => item.id === id);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    this.removeItem(id);
                } else {
                    this.updateCart();
                }
            }
        }
    };
    
    // Event listeners
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const product = {
                id: this.dataset.productId,
                name: this.dataset.productName,
                price: parseFloat(this.dataset.productPrice)
            };
            cart.addItem(product);
        });
    });
    
    document.getElementById('cart-toggle').addEventListener('click', function() {
        const cartElement = document.getElementById('cart');
        cartElement.classList.toggle('hidden');
    });
    
    // Delegación de eventos para los botones del carrito
    document.addEventListener('click', function(e) {
        if (e.target.closest('.increase-quantity')) {
            const id = e.target.closest('.increase-quantity').dataset.id;
            cart.updateQuantity(id, 1);
        }
        
        if (e.target.closest('.decrease-quantity')) {
            const id = e.target.closest('.decrease-quantity').dataset.id;
            cart.updateQuantity(id, -1);
        }
        
        if (e.target.closest('.remove-item')) {
            const id = e.target.closest('.remove-item').dataset.id;
            cart.removeItem(id);
        }
    });

    // Funciones para el modal de cotización
    function initQuoteModal() {
        const modal = document.getElementById('quote-modal');
        const closeModalBtn = document.getElementById('close-quote-modal');
        const quoteForm = document.getElementById('quote-form');
        
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
        if (quoteForm) {
            quoteForm.addEventListener('submit', function(e) {
                e.preventDefault();
                sendQuoteByEmail();
            });
        }
    }

    // Función para abrir modal de cotización
    window.openQuoteModal = function() {
        const modal = document.getElementById('quote-modal');
        if (modal && cart.items.length > 0) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Carrito vacío',
                text: 'Agrega productos al carrito antes de generar una cotización.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#f97316'
            });
        }
    };

    // Función para descargar PDF
    window.downloadQuote = function() {
        if (cart.items.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Carrito vacío',
                text: 'Agrega productos al carrito antes de descargar la cotización.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#f97316'
            });
            return;
        }

        const formData = new FormData();
        formData.append('items', JSON.stringify(cart.items));

        fetch('{{ route("quote.download") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                return response.blob();
            }
            throw new Error('Error al generar el PDF');
        })
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.style.display = 'none';
            a.href = url;
            a.download = 'cotizacion-geoservi-' + new Date().toISOString().slice(0, 10) + '.pdf';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            
            Swal.fire({
                icon: 'success',
                title: 'PDF Descargado',
                text: 'La cotización se ha descargado correctamente.',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#f97316'
            });
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un error al descargar la cotización.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#f97316'
            });
        });
    };

    // Función para enviar cotización por email
    function sendQuoteByEmail() {
        const formData = new FormData(document.getElementById('quote-form'));
        formData.append('items', JSON.stringify(cart.items));

        const submitButton = document.querySelector('#quote-form button[type="submit"]');
        const originalText = submitButton.innerHTML;
        
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Enviando...';
        submitButton.disabled = true;

        fetch('{{ route("quote.send") }}', {
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

            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.message,
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#f97316'
                });

                // Cerrar modal
                const modal = document.getElementById('quote-modal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            } else {
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
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'Ocurrió un error al enviar la cotización. Por favor, inténtalo de nuevo.',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#f97316'
            });
            console.error('Error:', error);
        });
    }

    // Inicializar modal de cotización
    initQuoteModal();
});
</script>
@endpush
