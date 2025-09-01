</section>
<!-- Carrito Flotante -->
<div id="cart" class="fixed bottom-6 right-6 z-50 hidden">
    <div class="bg-zinc-800 border border-white/10 rounded-xl shadow-2xl overflow-hidden w-80">
        <div class="bg-orange-500 text-white px-4 py-3 flex justify-between items-center">
            <h3 class="font-bold">Cotización</h3>
            <span id="cart-count" class="bg-white text-orange-500 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold">0</span>
        </div>
        <div id="cart-items" class="max-h-64 overflow-y-auto p-4">
            <!-- Items del carrito se agregarán aquí -->
        </div>
        <div class="p-4 border-t border-white/10">
            <div class="flex justify-between mb-4">
                <span class="font-bold text-white">Total:</span>
                <span id="cart-total" class="text-orange-400 font-bold">$0</span>
            </div>
            <a id="whatsapp-link" href="#" target="_blank" class="block w-full bg-green-500 hover:bg-green-600 text-white text-center py-2 px-4 rounded-lg transition-colors">
                <i class="fab fa-whatsapp mr-2"></i> Enviar por WhatsApp
            </a>
        </div>
    </div>
</div>

<!-- Botón flotante del carrito -->
<button id="cart-toggle" class="fixed bottom-6 right-6 bg-orange-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-orange-600 transition-colors z-40">
    <i class="fas fa-shopping-cart text-xl"></i>
    <span id="cart-badge" class="absolute -top-1 -right-1 bg-white text-orange-500 rounded-full w-5 h-5 flex items-center justify-center text-xs font-bold">0</span>
</button>


    
    <!-- Modal para datos de cotización -->
    <div id="quote-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
            </div>

            <!-- Contenido del modal -->
            <div class="inline-block align-bottom bg-zinc-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-white/10">
                <div class="absolute top-0 right-0 pt-4 pr-4">
                    <button id="close-quote-modal" class="text-gray-400 hover:text-white focus:outline-none">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                </div>
                
                <div class="p-6 sm:p-8">
                    <h3 class="text-2xl font-bold text-white mb-6">Enviar Cotización</h3>
                    <form id="quote-form">
                        @csrf
                        <div class="grid grid-cols-1 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Nombre *</label>
                                <input type="text" name="customer_name" required
                                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400"
                                       placeholder="Tu nombre completo">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Email *</label>
                                <input type="email" name="customer_email" required
                                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400"
                                       placeholder="correo@ejemplo.com">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Teléfono</label>
                                <input type="tel" name="customer_phone"
                                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400"
                                       placeholder="+56 9 1234 5678">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-1">Empresa</label>
                                <input type="text" name="customer_company"
                                       class="w-full px-4 py-3 bg-white/5 border border-white/10 rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent text-white placeholder-gray-400"
                                       placeholder="Nombre de tu empresa">
                            </div>
                        </div>
                        
                        <div class="flex space-x-4">
                            <button type="button" onclick="downloadQuote()" class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-300">
                                <i class="fas fa-download mr-2"></i> Descargar PDF
                            </button>
                            <button type="submit" class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-300">
                                <i class="fas fa-paper-plane mr-2"></i> Enviar por Email
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Botones flotantes -->
    <div class="fixed bottom-6 right-6 z-40 flex flex-col space-y-4">
        <!-- Botón para abrir modal de contacto -->
        <button onclick="openContactModal()" class="bg-orange-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-orange-600 transition-colors">
            <i class="fas fa-comments text-xl"></i>
        </button>
        
        <!-- Botón para abrir modal de cotización -->
        <button onclick="openQuoteModal()" class="bg-green-500 text-white w-14 h-14 rounded-full flex items-center justify-center shadow-lg hover:bg-green-600 transition-colors">
            <i class="fas fa-file-pdf text-xl"></i>
        </button>
    </div>
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