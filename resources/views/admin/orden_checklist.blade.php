@extends('layouts.admin')

@section('title', 'Checklist OT #'.$orden->id.' — '.$orden->maquinaria->nombre)
@section('subtitle', 'Completar checklist de mantención')

@push('styles')
<style>
    .item-row {
        transition: background-color 0.2s ease;
    }
    
    .item-row:hover {
        background-color: #3f3f46;
    }
    
    .badge-estado {
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .progress-bar {
        transition: width 0.5s ease-in-out;
    }
    
    .checkbox-custom {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 0.25rem;
        border: 2px solid #52525b;
        background: #27272a;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }
    
    .checkbox-custom.checked {
        background: #f97316;
        border-color: #f97316;
    }
    
    .checkbox-custom svg {
        opacity: 0;
        transition: opacity 0.2s ease;
    }
    
    .checkbox-custom.checked svg {
        opacity: 1;
    }
    
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i class="fas fa-angle-right text-gray-400 mx-2"></i>
        <a href="{{ route('admin.ordenes.index') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
            Órdenes de Trabajo
        </a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <i class="fas fa-angle-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-orange-400">Checklist</span>
    </div>
</li>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6" x-data="checklistApp()">
    <!-- Header -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white mb-4">
                    <i class="fas fa-clipboard-check mr-2 text-orange-400"></i>
                    Checklist — OT #{{ $orden->id }}
                </h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Maquinaria</p>
                        <p class="text-white font-medium">{{ $orden->maquinaria->nombre ?? '-' }}</p>
                    </div>
                    
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Pauta</p>
                        <p class="text-white font-medium">{{ $orden->pauta->nombre ?? '-' }}</p>
                    </div>
                    
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Horómetro</p>
                        <p class="text-white font-medium">{{ $orden->horometro_en_ejecucion ?? '-' }}</p>
                    </div>
                    
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Estado</p>
                        @if($orden->estado === 'pendiente')
                            <span class="badge-estado bg-yellow-500/20 text-yellow-400">Pendiente</span>
                        @elseif($orden->estado === 'en_progreso')
                            <span class="badge-estado bg-blue-500/20 text-blue-400">En Progreso</span>
                        @elseif($orden->estado === 'completada')
                            <span class="badge-estado bg-green-500/20 text-green-400">Completada</span>
                        @else
                            <span class="badge-estado bg-red-500/20 text-red-400">Cancelada</span>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="flex flex-col space-y-2 mt-4 md:mt-0">
                <a href="{{ route('admin.ordenes.index') }}" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors flex items-center justify-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver
                </a>
                <button @click="finalizarOrden" 
                        class="px-4 py-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white rounded-lg transition-all duration-200 flex items-center justify-center"
                        :disabled="orden.estado === 'completada'"
                        :class="{'opacity-50 cursor-not-allowed': orden.estado === 'completada'}">
                    <i class="fas fa-check-circle mr-2"></i>
                    Finalizar Orden
                </button>
            </div>
        </div>
    </div>

    <!-- Progreso global -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 p-6 mb-6">
        <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-chart-line mr-2 text-orange-400"></i>
            Progreso General
        </h2>
        
        <div class="flex items-center justify-between mb-3">
            <div class="w-full mr-4">
                <div class="flex justify-between text-sm text-gray-400 mb-2">
                    <span>Completado</span>
                    <span x-text="`${totalCompletados} / ${totalItems} ítems`"></span>
                </div>
                <div class="w-full bg-zinc-700 rounded-full h-3">
                    <div class="progress-bar bg-gradient-to-r from-orange-500 to-orange-600 h-3 rounded-full" 
                         :style="`width: ${porcentaje}%`"></div>
                </div>
            </div>
            <div class="text-xl font-bold text-orange-400 ml-4">
                <span x-text="Math.round(porcentaje)"></span>%
            </div>
        </div>
    </div>

    <!-- Áreas e Ítems -->
    <div class="space-y-4">
        @foreach($areasList as $area)
        <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 overflow-hidden" 
             x-data="{ open: true }">
            <!-- Header Área -->
            <button type="button" 
                    class="w-full px-6 py-4 flex items-center justify-between bg-zinc-900 hover:bg-zinc-900/80 transition-colors"
                    @click="open = !open">
                <div class="flex items-center space-x-4">
                    <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                        <i class="fas fa-folder text-orange-400"></i>
                    </div>
                    <div class="text-left">
                        <h3 class="text-lg font-semibold text-white">{{ $area['nombre'] }}</h3>
                        <p class="text-sm text-gray-400">
                            <span x-text="getAreaCompletados({{ $area['id'] }})"></span> de 
                            {{ count($area['items']) }} ítems completados
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <div class="transform transition-transform duration-200" 
                         :class="{'rotate-90': open}">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                    </div>
                </div>
            </button>

            <!-- Cuerpo Área con items -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                 x-transition:enter-end="opacity-100 transform translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 transform translate-y-0"
                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                 x-cloak>
                <div class="px-6 py-4 bg-zinc-900/50">
                    @if(count($area['items']) > 0)
                        <!-- Lista de ítems -->
                        <div class="space-y-2">
                            @foreach($area['items'] as $item)
                            <div class="item-row p-4 bg-zinc-800/50 rounded-lg border border-zinc-700"
                                 x-data="{ itemId: {{ $item['orden_item_id'] }} }">
                                <div class="flex items-start gap-4">
                                    <!-- Checkbox -->
                                    <div class="flex-shrink-0 pt-1">
                                        <div class="checkbox-custom" 
                                             :class="{'checked': isItemChecked({{ $item['orden_item_id'] }})}"
                                             @click="toggleItem({{ $item['orden_item_id'] }})">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <!-- Contenido -->
                                    <div class="flex-1">
                                        <div class="text-white font-medium">{{ $item['descripcion'] }}</div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Tipo: {{ $item['tipo'] ?: 'Sin tipo' }}
                                        </div>
                                        
                                        <!-- Observación -->
                                        <div class="mt-2">
                                            <textarea class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-3 py-2 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                                      rows="2"
                                                      x-model="items[{{ $item['orden_item_id'] }}].comentario"
                                                      @blur="guardarComentario({{ $item['orden_item_id'] }})"
                                                      placeholder="Agregar observación..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <!-- Mensaje cuando no hay items -->
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                            <p>No hay ítems en esta área</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

        @if(count($areasList) === 0)
        <!-- Mensaje cuando no hay áreas -->
        <div class="text-center py-12 text-gray-400 bg-zinc-800 rounded-lg border border-zinc-700">
            <i class="fas fa-clipboard-list text-4xl mb-4 opacity-50"></i>
            <h3 class="text-lg font-medium mb-2">No hay áreas disponibles</h3>
            <p>Esta orden no tiene ítems asociados.</p>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function checklistApp() {
    return {
        orden: @json($orden),
        areas: @json($areasList),
        items: {},
        
        init() {
            console.log('Inicializando checklist...');
            console.log('Áreas:', this.areas);
            
            // Inicializar items
            this.areas.forEach(area => {
                area.items.forEach(item => {
                    this.items[item.orden_item_id] = {
                        cumplido: item.cumplido || false,
                        comentario: item.comentario || ''
                    };
                });
            });
            
            console.log('Items inicializados:', this.items);
        },
        
        get totalItems() {
            return Object.keys(this.items).length;
        },
        
        get totalCompletados() {
            return Object.values(this.items).filter(item => item.cumplido).length;
        },
        
        get porcentaje() {
            return this.totalItems > 0 ? (this.totalCompletados * 100 / this.totalItems) : 0;
        },
        
        getAreaCompletados(areaId) {
            const area = this.areas.find(a => a.id == areaId);
            if (!area) return 0;
            
            return area.items.filter(item => 
                this.items[item.orden_item_id] && this.items[item.orden_item_id].cumplido
            ).length;
        },
        
        isItemChecked(itemId) {
            return this.items[itemId] && this.items[itemId].cumplido;
        },
        
        async toggleItem(itemId) {
            const newValue = !this.items[itemId].cumplido;
            
            try {
                const response = await fetch(`/admin/orden-items/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: new URLSearchParams({
                        '_method': 'PUT',
                        'cumplido': newValue ? 1 : 0
                    })
                });
                
                if (response.ok) {
                    this.items[itemId].cumplido = newValue;
                    this.mostrarNotificacion(
                        newValue ? 'Ítem marcado como completado' : 'Ítem marcado como pendiente',
                        'success'
                    );
                }
            } catch (error) {
                console.error('Error:', error);
                this.mostrarNotificacion('Error al actualizar el ítem', 'error');
            }
        },
        
        async guardarComentario(itemId) {
            try {
                const response = await fetch(`/admin/orden-items/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: new URLSearchParams({
                        '_method': 'PUT',
                        'comentario': this.items[itemId].comentario || ''
                    })
                });
                
                if (response.ok) {
                    this.mostrarNotificacion('Observación guardada', 'success');
                }
            } catch (error) {
                console.error('Error:', error);
                this.mostrarNotificacion('Error al guardar la observación', 'error');
            }
        },
        
        async finalizarOrden() {
            if (this.orden.estado === 'completada') {
                this.mostrarNotificacion('La orden ya está completada', 'info');
                return;
            }
            
            if (typeof Swal !== 'undefined') {
                const confirm = await Swal.fire({
                    title: '¿Finalizar orden?',
                    text: '¿Estás seguro de que deseas marcar esta orden como completada?',
                    icon: 'question',
                    background: '#27272a',
                    color: '#fff',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sí, finalizar',
                    cancelButtonText: 'Cancelar'
                });
                
                if (!confirm.isConfirmed) return;
            } else if (!confirm('¿Estás seguro de que deseas finalizar esta orden?')) {
                return;
            }
            
            try {
                const response = await fetch(`/admin/ordenes/${this.orden.id}/finalizar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    this.orden.estado = 'completada';
                    this.mostrarNotificacion('Orden finalizada correctamente', 'success');
                    
                    // Recargar después de 2 segundos
                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            } catch (error) {
                console.error('Error:', error);
                this.mostrarNotificacion('Error al finalizar la orden', 'error');
            }
        },
        
        mostrarNotificacion(mensaje, tipo = 'success') {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: tipo,
                    title: mensaje,
                    showConfirmButton: false,
                    timer: 3000,
                    background: '#27272a',
                    color: '#fff'
                });
            } else {
                alert(mensaje);
            }
        }
    }
}
</script>
@endpush
