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
<div class="container mx-auto px-4 py-6" x-data="ordenChecklistApp()" x-init="init()">
    <!-- Header -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white mb-4">
                    <i class="fas fa-clipboard-check mr-2 text-orange-400"></i>
                    Checklist — OT #<span x-text="orden.id"></span>
                </h1>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Maquinaria</p>
                        <p class="text-white font-medium" x-text="orden.maquinaria?.nombre || '-'"></p>
                    </div>
                    
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Pauta</p>
                        <p class="text-white font-medium" x-text="orden.pauta?.nombre || '-'"></p>
                    </div>
                    
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Horómetro</p>
                        <p class="text-white font-medium" x-text="orden.horometro_en_ejecucion || '-'"></p>
                    </div>
                    
                    <div class="bg-zinc-900 p-3 rounded-lg border border-zinc-700">
                        <p class="text-sm text-gray-400">Estado</p>
                        <template x-if="orden.estado === 'pendiente'">
                            <span class="badge-estado bg-yellow-500/20 text-yellow-400">Pendiente</span>
                        </template>
                        <template x-if="orden.estado === 'en_progreso'">
                            <span class="badge-estado bg-blue-500/20 text-blue-400">En Progreso</span>
                        </template>
                        <template x-if="orden.estado === 'completada'">
                            <span class="badge-estado bg-green-500/20 text-green-400">Completada</span>
                        </template>
                        <template x-if="orden.estado === 'cancelada'">
                            <span class="badge-estado bg-red-500/20 text-red-400">Cancelada</span>
                        </template>
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
                        x-bind:disabled="orden.estado === 'completada'"
                        x-bind:class="{'opacity-50 cursor-not-allowed': orden.estado === 'completada'}">
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
                <span x-text="porcentaje.toFixed(0)"></span>%
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 p-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center space-y-2 md:space-y-0 md:space-x-4">
            <div class="flex space-x-2">
                <button @click="marcarTodosAreas(true)" 
                        class="px-3 py-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    Marcar Todo OK
                </button>
                <button @click="marcarTodosAreas(false)" 
                        class="px-3 py-2 bg-gray-500/20 text-gray-400 rounded-lg hover:bg-gray-500/30 transition-colors flex items-center">
                    <i class="fas fa-times-circle mr-2"></i>
                    Marcar Todo Pendiente
                </button>
            </div>
        </div>
    </div>

    <!-- Áreas e Ítems -->
    <div class="space-y-4">
        <template x-for="(area, idx) in areas" :key="area.id">
            <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 overflow-hidden">
                <!-- Header Área -->
                <button type="button" 
                        class="w-full px-6 py-4 flex items-center justify-between bg-zinc-900 hover:bg-zinc-900/80 transition-colors"
                        @click="toggleArea(area.id)">
                    <div class="flex items-center space-x-4">
                        <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-folder text-orange-400"></i>
                        </div>
                        <div class="text-left">
                            <h3 class="text-lg font-semibold text-white" x-text="area.nombre"></h3>
                            <p class="text-sm text-gray-400">
                                <span x-text="areaProgress(area).completados"></span> de 
                                <span x-text="area.items.length"></span> ítems completados
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="hidden md:flex space-x-2">
                            <button type="button" 
                                    class="px-3 py-1 text-xs rounded bg-green-500/20 text-green-400 hover:bg-green-500/30 transition-colors"
                                    @click.stop="marcarTodos(area, true)">
                                Marcar OK
                            </button>
                            <button type="button" 
                                    class="px-3 py-1 text-xs rounded bg-gray-500/20 text-gray-400 hover:bg-gray-500/30 transition-colors"
                                    @click.stop="marcarTodos(area, false)">
                                Marcar Pend.
                            </button>
                        </div>
                        
                        <div class="transform transition-transform duration-200" 
                             :class="{'rotate-90': isAreaOpen(area.id)}">
                            <i class="fas fa-chevron-right text-gray-400"></i>
                        </div>
                    </div>
                </button>

                <!-- Cuerpo Área con items -->
                <div x-show="isAreaOpen(area.id)" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0">
                    <div class="px-6 py-4 bg-zinc-900/50">
                        <!-- Lista de ítems -->
                        <div class="space-y-2">
                            <template x-for="(item, itemIdx) in area.items" :key="item.orden_item_id">
                                <div class="item-row grid grid-cols-1 md:grid-cols-12 gap-4 p-4 bg-zinc-800/50 rounded-lg border border-zinc-700">
                                    <!-- Checkbox -->
                                    <div class="md:col-span-1 flex items-center justify-center">
                                        <div class="checkbox-custom" 
                                             :class="{'checked': item.cumplido}"
                                             @click="toggleCumplido(item, !item.cumplido)">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <!-- Descripción -->
                                    <div class="md:col-span-6">
                                        <div class="text-white font-medium" x-text="item.descripcion"></div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Tipo: <span x-text="item.tipo || 'Sin tipo'"></span>
                                        </div>
                                    </div>
                                    
                                    <!-- Observación -->
                                    <div class="md:col-span-4">
                                        <textarea class="w-full bg-zinc-700 border border-zinc-600 rounded-lg px-3 py-2 text-white text-sm placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent resize-none"
                                                  rows="2"
                                                  x-model="item.comentario"
                                                  @blur="guardarComentario(item)"
                                                  placeholder="Agregar observación..."></textarea>
                                    </div>
                                    
                                    <!-- Acciones -->
                                    <div class="md:col-span-1 flex items-center justify-center">
                                        <button class="p-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors"
                                                @click="guardarComentario(item)"
                                                title="Guardar observación">
                                            <i class="fas fa-save text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </template>
                            
                            <!-- Mensaje cuando no hay items -->
                            <div x-show="!area.items || area.items.length === 0" class="text-center py-8 text-gray-400">
                                <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                                <p>No hay ítems en esta área</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Mensaje cuando no hay áreas -->
        <div x-show="areas.length === 0" class="text-center py-12 text-gray-400 bg-zinc-800 rounded-lg border border-zinc-700">
            <i class="fas fa-clipboard-list text-4xl mb-4 opacity-50"></i>
            <h3 class="text-lg font-medium mb-2">No hay áreas disponibles</h3>
            <p>Esta orden no tiene ítems asociados.</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function ordenChecklistApp() {
    return {
        orden: @json($orden),
        areas: @json($areasList),
        areasOpen: {},

        init() {
            console.log('Checklist inicializado');
            console.log('Datos de orden:', this.orden);
            console.log('Áreas recibidas:', this.areas);
            
            // Inicializar todas las áreas como abiertas
            this.areas.forEach((area) => {
                this.areasOpen[area.id] = true;
                console.log(`Área ${area.id}: ${area.nombre} con ${area.items?.length || 0} items`);
            });
        },

        // Toggle acordeón por área
        toggleArea(areaId) {
            this.areasOpen[areaId] = !this.areasOpen[areaId];
        },
        
        // Helper para verificar si un área está abierta
        isAreaOpen(areaId) {
            return this.areasOpen[areaId] === true;
        },

        get totalItems() {
            return this.areas.reduce((acc, a) => acc + (a.items?.length || 0), 0);
        },
        
        get totalCompletados() {
            return this.areas.reduce((acc, a) => {
                const items = a.items || [];
                return acc + items.filter(x => x.cumplido).length;
            }, 0);
        },
        
        get porcentaje() {
            return this.totalItems ? (this.totalCompletados * 100 / this.totalItems) : 0;
        },

        areaProgress(area) {
            const items = area.items || [];
            const completados = items.filter(x => x.cumplido).length;
            return { completados, total: items.length };
        },

        async toggleCumplido(item, checked) {
            try {
                console.log('Cambiando estado del ítem:', item.orden_item_id, 'a:', checked);
                await this._postUpdateItem(item.orden_item_id, { cumplido: checked ? 1 : 0 });
                item.cumplido = checked;
                this.mostrarNotificacion(checked ? 'Ítem marcado como completado' : 'Ítem marcado como pendiente', 'success');
            } catch (e) {
                console.error('Error al actualizar ítem:', e);
                this.mostrarNotificacion('Error al actualizar el ítem', 'error');
            }
        },
        
        async guardarComentario(item) {
            try {
                if (!item.orden_item_id) {
                    console.error('ID de ítem no válido:', item);
                    return;
                }
                
                await this._postUpdateItem(item.orden_item_id, { comentario: item.comentario || '' });
                this.mostrarNotificacion('Observación guardada', 'success');
            } catch (e) {
                console.error('Error al guardar comentario:', e);
                this.mostrarNotificacion('Error al guardar la observación', 'error');
            }
        },
        
        async marcarTodos(area, valor) {
            const items = area.items || [];
            if (items.length === 0) return;
            
            try {
                const promises = items.map(item => 
                    this._postUpdateItem(item.orden_item_id, { cumplido: valor ? 1 : 0 })
                        .then(() => { item.cumplido = valor; })
                );
                
                await Promise.all(promises);
                this.mostrarNotificacion(
                    valor ? 'Todos los ítems marcados como OK' : 'Todos los ítems marcados como pendientes', 
                    'success'
                );
            } catch (e) {
                console.error('Error al marcar todos:', e);
                this.mostrarNotificacion('Error al actualizar los ítems', 'error');
            }
        },
        
        async marcarTodosAreas(valor) {
            try {
                const allPromises = this.areas.flatMap(area => 
                    (area.items || []).map(item =>
                        this._postUpdateItem(item.orden_item_id, { cumplido: valor ? 1 : 0 })
                            .then(() => { item.cumplido = valor; })
                    )
                );
                
                await Promise.all(allPromises);
                this.mostrarNotificacion(
                    valor ? 'Todos los ítems marcados como OK' : 'Todos los ítems marcados como pendientes', 
                    'success'
                );
            } catch (e) {
                console.error('Error al marcar todos los ítems:', e);
                this.mostrarNotificacion('Error al actualizar los ítems', 'error');
            }
        },
        
        async finalizarOrden() {
            if (this.orden.estado === 'completada') {
                this.mostrarNotificacion('La orden ya está completada', 'info');
                return;
            }
            
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
            
            try {
                const res = await fetch(`/admin/ordenes/${this.orden.id}/finalizar`, {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: new URLSearchParams().toString()
                });
                
                if (!res.ok) throw new Error('Error del servidor');
                
                const data = await res.json();
                this.orden.estado = data.data?.estado || 'completada';
                
                this.mostrarNotificacion('Orden finalizada correctamente', 'success');
            } catch (e) {
                console.error('Error al finalizar orden:', e);
                this.mostrarNotificacion('Error al finalizar la orden', 'error');
            }
        },

        async _postUpdateItem(ordenItemId, payload) {
            if (!ordenItemId) {
                throw new Error('ID de ítem no válido');
            }
            
            const params = new URLSearchParams();
            params.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            params.append('_method', 'PUT');
            
            if (payload.cumplido !== undefined) params.append('cumplido', payload.cumplido);
            if (payload.comentario !== undefined) params.append('comentario', payload.comentario);
            
            const res = await fetch(`/admin/orden-items/${ordenItemId}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: params.toString()
            });
            
            if (!res.ok) {
                const errorText = await res.text();
                throw new Error(`Error ${res.status}: ${errorText}`);
            }
            
            return res.json();
        },
        
        mostrarNotificacion(mensaje, tipo = 'success') {
            // Si existe SweetAlert2, usarlo
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
                // Fallback a console.log si no está disponible
                console.log(`[${tipo.toUpperCase()}] ${mensaje}`);
            }
        }
    }
}
</script>
@endpush
