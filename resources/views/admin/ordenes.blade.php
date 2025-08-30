@extends('layouts.admin')

@section('title', 'Gestión de Órdenes de Trabajo')
@section('subtitle', 'Administra las órdenes de trabajo de mantención')

@push('styles')
<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border: 1px solid #3f3f46 !important;
        background: #27272a !important;
        color: #a1a1aa !important;
        margin: 0 0.125rem;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(to right, #f97316, #ea580c) !important;
        color: white !important;
        border: none !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #3f3f46 !important;
        color: white !important;
        border-color: #f97316 !important;
    }
    
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #3f3f46;
        border-radius: 0.375rem;
        padding: 0.375rem 0.75rem;
        background: #18181b;
        color: #a1a1aa;
    }
    
    .dataTables_wrapper .dataTables_length label,
    .dataTables_wrapper .dataTables_filter label {
        color: #a1a1aa;
    }
    
    #ordenesTable tbody tr {
        background-color: #18181b;
        border-bottom: 1px solid #3f3f46;
    }
    
    #ordenesTable tbody tr:hover {
        background-color: #27272a;
    }
    
    .table-actions {
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }
    
    tr:hover .table-actions {
        opacity: 1;
    }
    
    .badge-estado {
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
</style>
@endpush

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i class="fas fa-angle-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-orange-400">Órdenes de Trabajo</span>
    </div>
</li>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6" x-data="ordenesApp()">
    <!-- Header con estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-orange-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Total Órdenes</p>
                    <p class="text-2xl font-bold text-white">42</p>
                </div>
                <div class="bg-orange-500/20 p-3 rounded-full">
                    <i class="fas fa-clipboard-list text-orange-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Pendientes</p>
                    <p class="text-2xl font-bold text-white">15</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-full">
                    <i class="fas fa-clock text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Completadas</p>
                    <p class="text-2xl font-bold text-white">24</p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-red-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Canceladas</p>
                    <p class="text-2xl font-bold text-white">3</p>
                </div>
                <div class="bg-red-500/20 p-3 rounded-full">
                    <i class="fas fa-times-circle text-red-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de control -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 mb-6">
        <div class="p-4 border-b border-zinc-700 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-list-check mr-2 text-orange-400"></i>
                Listado de Órdenes de Trabajo
            </h2>
            
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 w-full md:w-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Buscar..." 
                           class="pl-10 pr-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 w-full">
                </div>
                
                <select id="filterEstado" class="px-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="en_progreso">En Progreso</option>
                    <option value="completada">Completada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
                
                <button id="resetFilters" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-times mr-2"></i> Limpiar
                </button>
            </div>
        </div>

        <!-- Botón crear -->
        <div class="p-4 border-b border-zinc-700">
            <button @click="openModal('crear')" class="bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white px-4 py-2 rounded-lg flex items-center transition-all duration-200 shadow-lg hover:shadow-orange-500/20">
                <i class="fas fa-plus-circle mr-2"></i>
                Nueva Orden
            </button>
        </div>

        <!-- Tabla -->
        <div class="p-4">
            <div class="overflow-x-auto rounded-lg">
                <table id="ordenesTable" class="min-w-full divide-y divide-zinc-700">
                    <thead class="bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Maquinaria</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Pauta</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Horómetro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Inicio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Fin</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-zinc-800 divide-y divide-zinc-700"></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Crear/Editar -->
    <div x-show="isOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70" style="display: none;">
        <div class="bg-zinc-800 border border-zinc-700 rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 p-6 max-h-screen overflow-y-auto" @click.away="closeModal">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-white" x-text="modalTitle"></h2>
                <button @click="closeModal" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form @submit.prevent="submitForm">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-300 mb-1">Maquinaria *</label>
                        <select name="maquinaria_id" x-model="form.maquinaria_id" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            <option value="">Seleccione maquinaria</option>
                            @foreach ($maquinarias as $m)
                                <option value="{{ $m->id }}">{{ $m->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Pauta *</label>
                        <select name="pauta_id" x-model="form.pauta_id" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            <option value="">Seleccione pauta</option>
                            @foreach ($pautas as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }} ({{ ucfirst($p->tipo_equipo) }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Horómetro en ejecución</label>
                        <input type="number" step="0.01" min="0" name="horometro_en_ejecucion" x-model="form.horometro_en_ejecucion" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Horas actuales">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Estado</label>
                        <select name="estado" x-model="form.estado" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_progreso">En Progreso</option>
                            <option value="completada">Completada</option>
                            <option value="cancelada">Cancelada</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" x-model="form.fecha_inicio" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Fecha Fin</label>
                        <input type="date" name="fecha_fin" x-model="form.fecha_fin" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-gray-300 mb-1">Observaciones</label>
                        <textarea name="observaciones" x-model="form.observaciones" rows="4" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Notas y observaciones de la orden..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" @click="closeModal" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition-all duration-200">
                        Guardar Orden
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Detalles -->
    <div x-show="isDetailOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70" style="display: none;">
        <div class="bg-zinc-800 border border-zinc-700 rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 p-6 max-h-screen overflow-y-auto" @click.away="closeDetailModal">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-white">Detalles de Orden</h2>
                <button @click="closeDetailModal" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Maquinaria</p>
                    <p class="text-white font-medium" x-text="detail.maquinaria?.nombre || '-'"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Pauta</p>
                    <p class="text-white font-medium" x-text="detail.pauta?.nombre || '-'"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Estado</p>
                    <p class="text-white font-medium capitalize" x-text="detail.estado || '-'"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Horómetro</p>
                    <p class="text-white font-medium" x-text="detail.horometro_en_ejecucion ? detail.horometro_en_ejecucion + ' hrs' : '-'"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Fecha Inicio</p>
                    <p class="text-white font-medium" x-text="detail.fecha_inicio || '-'"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Fecha Fin</p>
                    <p class="text-white font-medium" x-text="detail.fecha_fin || '-'"></p>
                </div>
            </div>
            
            <div class="bg-zinc-900 p-4 rounded-lg mb-4">
                <p class="text-sm text-gray-400 mb-2">Observaciones</p>
                <p class="text-white whitespace-pre-line" x-text="detail.observaciones || 'Sin observaciones'"></p>
            </div>
            
            <div class="flex justify-end space-x-2 mt-6">
                <button type="button" @click="window.location.href = '/admin/ordenes/' + detail.id + '/checklist'" 
                        class="px-4 py-2 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-lg transition-all duration-200 flex items-center">
                    <i class="fas fa-clipboard-check mr-2"></i>
                    Ir al Checklist
                </button>
                <button type="button" @click="closeDetailModal" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
window.ordenesApp = function () {
    return {
        isOpen: false,
        isDetailOpen: false,
        modalTitle: '',
        currentId: null,
        form: {
            maquinaria_id: '',
            pauta_id: '',
            tecnico_id: '',
            fecha_inicio: '',
            fecha_fin: '',
            horometro_en_ejecucion: '',
            estado: 'pendiente',
            observaciones: ''
        },
        detail: {},

        openModal(mode, data = null) {
            this.isOpen = true;
            this.modalTitle = mode === 'crear' ? 'Crear Orden de Trabajo' : 'Editar Orden de Trabajo';
            this.currentId = data ? data.id : null;

            if (data) {
                this.form = {
                    maquinaria_id: data.maquinaria_id ?? data.maquinaria?.id ?? '',
                    pauta_id: data.pauta_id ?? data.pauta?.id ?? '',
                    tecnico_id: data.tecnico_id ?? '',
                    fecha_inicio: data.fecha_inicio ?? '',
                    fecha_fin: data.fecha_fin ?? '',
                    horometro_en_ejecucion: data.horometro_en_ejecucion ?? '',
                    estado: data.estado ?? 'pendiente',
                    observaciones: data.observaciones ?? ''
                };
            } else {
                this.form = { 
                    maquinaria_id: '', 
                    pauta_id: '', 
                    tecnico_id: '', 
                    fecha_inicio: '', 
                    fecha_fin: '', 
                    horometro_en_ejecucion: '', 
                    estado: 'pendiente', 
                    observaciones: '' 
                };
            }
        },
        closeModal() { this.isOpen = false; },

        openDetailModal(data) { 
            this.detail = data; 
            this.isDetailOpen = true; 
        },
        closeDetailModal() { this.isDetailOpen = false; },

        async submitForm() {
            const url = this.currentId
                ? `/admin/ordenes/${this.currentId}`
                : `{{ route('admin.ordenes.store') }}`;

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            if (this.currentId) formData.append('_method', 'PUT');
            Object.entries(this.form).forEach(([k, v]) => formData.append(k, v ?? ''));

            try {
                const res = await fetch(url, { method: 'POST', body: formData });
                if (!res.ok) throw new Error('Server error');
                $('#ordenesTable').DataTable().ajax.reload(null, false);
                this.closeModal();
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Orden guardada correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo guardar la orden',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        }
    }
}

// Helpers globales de acciones
window.getOrdenById = function (id) {
    try {
        const table = window.ordenesDT;
        if (!table) return null;
        const all = table.rows().data();
        for (let i = 0; i < all.length; i++) {
            const r = all[i];
            if (String(r.id) === String(id)) return r;
        }
        return null;
    } catch (e) { console.error(e); return null; }
};

window.editOrden = function (id) {
    const row = window.getOrdenById(id);
    if (!row) return console.error('Fila no encontrada para editar:', id);
    
    // Esperar un momento para asegurar que Alpine esté listo
    setTimeout(() => {
        const alpineComponent = document.querySelector('[x-data="ordenesApp()"]');
        if (alpineComponent && alpineComponent._x_dataStack) {
            // Usar _x_dataStack que es más confiable
            alpineComponent._x_dataStack[0].openModal('editar', row);
        } else if (alpineComponent && alpineComponent.__x) {
            // Fallback al método anterior
            alpineComponent.__x.$data.openModal('editar', row);
        } else {
            // Último intento: usar Alpine global
            if (window.Alpine && window.Alpine.$data) {
                const component = Alpine.$data(alpineComponent);
                if (component) {
                    component.openModal('editar', row);
                }
            } else {
                console.error('No se pudo acceder al componente Alpine');
            }
        }
    }, 100);
};

window.viewOrden = function (id) {
    const row = window.getOrdenById(id);
    if (!row) return console.error('Fila no encontrada para ver:', id);
    
    // Esperar un momento para asegurar que Alpine esté listo
    setTimeout(() => {
        const alpineComponent = document.querySelector('[x-data="ordenesApp()"]');
        if (alpineComponent && alpineComponent._x_dataStack) {
            // Usar _x_dataStack que es más confiable
            alpineComponent._x_dataStack[0].openDetailModal(row);
        } else if (alpineComponent && alpineComponent.__x) {
            // Fallback al método anterior
            alpineComponent.__x.$data.openDetailModal(row);
        } else {
            // Último intento: usar Alpine global
            if (window.Alpine && window.Alpine.$data) {
                const component = Alpine.$data(alpineComponent);
                if (component) {
                    component.openDetailModal(row);
                }
            } else {
                console.error('No se pudo acceder al componente Alpine');
            }
        }
    }, 100);
};

window.openChecklist = function (id) {
    window.location.href = `/admin/ordenes/${id}/checklist`;
};

window.deleteOrden = function (id) {
    Swal.fire({
        title: '¿Eliminar orden?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        background: '#27272a',
        color: '#fff',
        showCancelButton: true,
        confirmButtonColor: '#f97316',
        cancelButtonColor: '#6b7280',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then(async (result) => {
        if (!result.isConfirmed) return;

        try {
            const res = await fetch(`/admin/ordenes/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: '_method=DELETE'
            });
            if (!res.ok) throw new Error('Error en servidor');
            $('#ordenesTable').DataTable().ajax.reload(null, false);
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'La orden ha sido eliminada',
                background: '#27272a',
                color: '#fff',
                confirmButtonColor: '#f97316'
            });
        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar la orden',
                background: '#27272a',
                color: '#fff',
                confirmButtonColor: '#f97316'
            });
        }
    });
};

window.changeEstadoOrden = async function (id) {
    const row = window.getOrdenById(id);
    if (!row) return console.error('Fila no encontrada:', id);

    const { value: newEstado } = await Swal.fire({
        title: 'Cambiar estado',
        input: 'select',
        inputOptions: {
            'pendiente': 'Pendiente',
            'en_progreso': 'En Progreso',
            'completada': 'Completada',
            'cancelada': 'Cancelada'
        },
        inputValue: row.estado || 'pendiente',
        background: '#27272a',
        color: '#fff',
        confirmButtonColor: '#f97316',
        showCancelButton: true,
        confirmButtonText: 'Actualizar',
        cancelButtonText: 'Cancelar'
    });
    if (!newEstado) return;

    try {
        const formData = new URLSearchParams();
        formData.append('_method', 'PUT');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        formData.append('estado', newEstado);

        const res = await fetch(`/admin/ordenes/${row.id}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        });

        if (!res.ok) throw new Error('No se pudo actualizar el estado');
        $('#ordenesTable').DataTable().ajax.reload(null, false);
        Swal.fire({
            icon: 'success',
            title: 'Actualizado',
            text: 'Estado actualizado correctamente',
            background: '#27272a',
            color: '#fff',
            confirmButtonColor: '#f97316'
        });
    } catch (err) {
        console.error(err);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo actualizar el estado',
            background: '#27272a',
            color: '#fff',
            confirmButtonColor: '#f97316'
        });
    }
};

// DataTable
document.addEventListener('DOMContentLoaded', function () {
    $.fn.dataTable.ext.errMode = 'none';
    const table = $('#ordenesTable').DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('admin.ordenes.datatable') }}",
            data: function (d) {
                d.custom_search = $('#searchInput').val();
                d.estadoFilter = $('#filterEstado').val();
            }
        },
        columns: [
            { 
                data: 'maquinaria', 
                name: 'maquinaria', 
                render: r => r?.nombre ? `<span class="text-white">${r.nombre}</span>` : '<span class="text-gray-400">-</span>'
            },
            { 
                data: 'pauta', 
                name: 'pauta', 
                render: r => r?.nombre ? `<span class="text-white">${r.nombre}</span>` : '<span class="text-gray-400">-</span>'
            },
            { 
                data: 'horometro_en_ejecucion', 
                name: 'horometro_en_ejecucion', 
                render: v => v ? `<span class="text-orange-400">${v} hrs</span>` : '<span class="text-gray-400">-</span>'
            },
            { 
                data: 'estado', 
                name: 'estado',
                render: function(v) {
                    const colors = {
                        pendiente: 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                        en_progreso: 'bg-blue-500/20 text-blue-400 border-blue-500/30',
                        completada: 'bg-green-500/20 text-green-400 border-green-500/30',
                        cancelada: 'bg-red-500/20 text-red-400 border-red-500/30'
                    };
                    const label = {
                        pendiente: 'Pendiente',
                        en_progreso: 'En Progreso',
                        completada: 'Completada',
                        cancelada: 'Cancelada'
                    }[v] || v;
                    return `<span class="badge-estado ${colors[v]||'bg-gray-500/20 text-gray-400 border-gray-500/30'}">${label}</span>`;
                }
            },
            { 
                data: 'fecha_inicio', 
                name: 'fecha_inicio', 
                render: v => v ? `<span class="text-gray-300">${v}</span>` : '<span class="text-gray-400">-</span>'
            },
            { 
                data: 'fecha_fin', 
                name: 'fecha_fin', 
                render: v => v ? `<span class="text-gray-300">${v}</span>` : '<span class="text-gray-400">-</span>'
            },
            {
                data: null,
                orderable: false, 
                searchable: false,
                render: function (row) {
                    return `
                        <div class="flex items-center space-x-2 table-actions">
                            <button type="button" onclick="editOrden(${row.id})" class="p-1 bg-blue-500/20 text-blue-400 rounded hover:bg-blue-500/30 transition-colors" title="Editar">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button type="button" onclick="changeEstadoOrden(${row.id})" class="p-1 bg-yellow-500/20 text-yellow-400 rounded hover:bg-yellow-500/30 transition-colors" title="Cambiar Estado">
                                <i class="fas fa-exchange-alt text-xs"></i>
                            </button>
                            <button type="button" onclick="viewOrden(${row.id})" class="p-1 bg-green-500/20 text-green-400 rounded hover:bg-green-500/30 transition-colors" title="Ver Detalles">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                            <button type="button" onclick="openChecklist(${row.id})" class="p-1 bg-purple-500/20 text-purple-400 rounded hover:bg-purple-500/30 transition-colors" title="Checklist">
                                <i class="fas fa-clipboard-check text-xs"></i>
                            </button>
                            <button type="button" class="p-1 bg-red-500/20 text-red-400 rounded hover:bg-red-500/30 transition-colors" title="Eliminar" onclick="deleteOrden(${row.id})">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: { 
            url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json",
        }
    });
    window.ordenesDT = table;

    $('#ordenesTable').on('error.dt', function (e, settings, techNote, message) {
        console.error('DataTable error:', message);
    });

    $('#searchInput, #filterEstado').on('keyup change', () => table.draw());
    $('#resetFilters').on('click', function () {
        $('#searchInput').val('');
        $('#filterEstado').val('');
        table.draw();
    });
});
</script>
@endpush