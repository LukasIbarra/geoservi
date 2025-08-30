@extends('layouts.admin')

@section('title', 'Gestión de Maquinarias')
@section('subtitle', 'Administra el inventario de maquinarias y equipos')

@push('styles')
<style>
    /* Estilos personalizados para DataTables */
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
    
    #maquinariasTable tbody tr {
        background-color: #18181b;
        border-bottom: 1px solid #3f3f46;
    }
    
    #maquinariasTable tbody tr:hover {
        background-color: #27272a;
    }
    
    .table-actions {
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }
    
    tr:hover .table-actions {
        opacity: 1;
    }
</style>
@endpush

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i class="fas fa-angle-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-orange-400">Maquinarias</span>
    </div>
</li>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6" x-data="maquinariasApp()">
    <!-- Header con estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-orange-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Total Maquinarias</p>
                    <p class="text-2xl font-bold text-white">42</p>
                </div>
                <div class="bg-orange-500/20 p-3 rounded-full">
                    <i class="fas fa-truck-monster text-orange-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Activas</p>
                    <p class="text-2xl font-bold text-white">32</p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-full">
                    <i class="fas fa-check-circle text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-yellow-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">En Mantención</p>
                    <p class="text-2xl font-bold text-white">7</p>
                </div>
                <div class="bg-yellow-500/20 p-3 rounded-full">
                    <i class="fas fa-tools text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-red-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Inactivas</p>
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
                <i class="fas fa-list mr-2 text-orange-400"></i>
                Listado de Maquinarias
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
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                    <option value="mantencion">En Mantención</option>
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
                Nueva Maquinaria
            </button>
        </div>

        <!-- Tabla -->
        <div class="p-4">
            <div class="overflow-x-auto rounded-lg">
                <table id="maquinariasTable" class="min-w-full divide-y divide-zinc-700">
                    <thead class="bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Marca/Modelo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Horómetro</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
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
                        <label class="block text-gray-300 mb-1">Nombre</label>
                        <input type="text" name="nombre" x-model="form.nombre" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Tipo</label>
                        <select name="tipo" x-model="form.tipo" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="camion">Camión</option>
                            <option value="excavadora">Excavadora</option>
                            <option value="cargador">Cargador</option>
                            <option value="compactador">Compactador</option>
                            <option value="generador">Generador</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Marca</label>
                        <input type="text" name="marca" x-model="form.marca" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Modelo</label>
                        <input type="text" name="modelo" x-model="form.modelo" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Número de Serie</label>
                        <input type="text" name="serie" x-model="form.serie" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Horómetro Actual</label>
                        <input type="number" step="0.01" name="horometro_actual" x-model="form.horometro_actual" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Estado</label>
                        <select name="estado" x-model="form.estado" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="mantencion">En Mantención</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-gray-300 mb-1">Fecha de Compra</label>
                        <input type="date" name="fecha_compra" x-model="form.fecha_compra" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" @click="closeModal" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition-all duration-200">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Detalles -->
    <div x-show="isDetailOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70" style="display: none;">
        <div class="bg-zinc-800 border border-zinc-700 rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 p-6 max-h-screen overflow-y-auto" @click.away="closeDetailModal">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-white">Detalles de Maquinaria</h2>
                <button @click="closeDetailModal" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Nombre</p>
                    <p class="text-white font-medium" x-text="detail.nombre"></p>
                </div>
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Tipo</p>
                    <p class="text-white font-medium" x-text="detail.tipo"></p>
                </div>
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Marca</p>
                    <p class="text-white font-medium" x-text="detail.marca"></p>
                </div>
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Modelo</p>
                    <p class="text-white font-medium" x-text="detail.modelo"></p>
                </div>
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Número de Serie</p>
                    <p class="text-white font-medium" x-text="detail.serie"></p>
                </div>
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Horómetro Actual</p>
                    <p class="text-white font-medium" x-text="detail.horometro_actual + ' hrs'"></p>
                </div>
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Estado</p>
                    <p class="text-white font-medium capitalize" x-text="detail.estado"></p>
                </div>
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Fecha de Compra</p>
                    <p class="text-white font-medium" x-text="detail.fecha_compra"></p>
                </div>
            </div>
            
            <div class="flex justify-end space-x-2 mt-6">
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
    // Haz la función GLOBAL para Alpine
    window.maquinariasApp = function() {
        return {
            isOpen: false,
            isDetailOpen: false,
            modalTitle: '',
            detail: {},
            form: {
                nombre: '',
                tipo: '',
                marca: '',
                modelo: '',
                serie: '',
                horometro_actual: '',
                estado: 'activo',
                fecha_compra: ''
            },
            currentId: null,

            openModal(mode, data = null) {
                this.isOpen = true;
                this.modalTitle = mode === 'crear' ? 'Crear Maquinaria' : 'Editar Maquinaria';
                this.currentId = data ? data.id : null;

                if (data) {
                    this.form = {
                        nombre: data.nombre || '',
                        tipo: data.tipo || '',
                        marca: data.marca || '',
                        modelo: data.modelo || '',
                        serie: data.serie || '',
                        horometro_actual: data.horometro_actual || '',
                        estado: data.estado || 'activo',
                        fecha_compra: data.fecha_compra || ''
                    };
                } else {
                    this.form = { 
                        nombre: '', 
                        tipo: '', 
                        marca: '', 
                        modelo: '', 
                        serie: '', 
                        horometro_actual: '', 
                        estado: 'activo',
                        fecha_compra: '' 
                    };
                }
            },
            closeModal() {
                this.isOpen = false;
            },
            openDetailModal(data) {
                this.detail = data;
                this.isDetailOpen = true;
            },
            closeDetailModal() {
                this.isDetailOpen = false;
            },
            async submitForm() {
                const url = this.currentId
                    ? `/admin/maquinarias/${this.currentId}`
                    : `{{ route('admin.maquinarias.store') }}`;

                const formData = new FormData();
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                if (this.currentId) {
                    formData.append('_method', 'PUT');
                }
                Object.entries(this.form).forEach(([k,v]) => formData.append(k, v));

                try {
                    const res = await fetch(url, { method: 'POST', body: formData });
                    if (!res.ok) throw new Error('Server error');
                    $('#maquinariasTable').DataTable().ajax.reload();
                    this.closeModal();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: 'Maquinaria guardada correctamente',
                        background: '#27272a',
                        color: '#fff',
                        confirmButtonColor: '#f97316'
                    });
                } catch (e) {
                    console.error(e);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo guardar la maquinaria',
                        background: '#27272a',
                        color: '#fff',
                        confirmButtonColor: '#f97316'
                    });
                }
            }
        }
    }

    // GLOBAL para usarlo desde la tabla
    window.deleteMaquinaria = function(id) {
        Swal.fire({
            title: '¿Eliminar maquinaria?',
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

            const res = await fetch(`/admin/maquinarias/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: '_method=DELETE'
            });
            if (res.ok) {
                $('#maquinariasTable').DataTable().ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: 'La maquinaria ha sido eliminada',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar la maquinaria',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        });
    }

    // Cambiar estado
    window.changeEstado = async function(row) {
        const { value: newEstado } = await Swal.fire({
            title: 'Cambiar estado',
            input: 'select',
            inputOptions: {
                'activo': 'Activo',
                'inactivo': 'Inactivo',
                'mantencion': 'En Mantención'
            },
            inputValue: row.estado || 'activo',
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
            formData.append('nombre', row.nombre || '');
            formData.append('tipo', row.tipo || 'maquina');
            formData.append('marca', row.marca || '');
            formData.append('modelo', row.modelo || '');
            formData.append('serie', row.serie || '');
            formData.append('horometro_actual', row.horometro_actual ?? 0);
            formData.append('estado', newEstado);
            formData.append('fecha_compra', row.fecha_compra || '');

            const res = await fetch(`/admin/maquinarias/${row.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: formData.toString()
            });

            if (!res.ok) throw new Error('No se pudo actualizar el estado');
            $('#maquinariasTable').DataTable().ajax.reload(null, false);
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
    }

    // Helpers globales para acciones con ID (evita JSON embebido y problemas de escape)
    window.getMaquinariaById = function(id) {
        try {
            const table = window.maquinariasDT;
            if (!table) return null;
            const all = table.rows().data();
            for (let i = 0; i < all.length; i++) {
                const r = all[i];
                if (String(r.id) === String(id)) return r;
            }
            return null;
        } catch (e) {
            console.error(e);
            return null;
        }
    };
    window.editMaquinaria = function(id) {
        const row = window.getMaquinariaById(id);
        if (!row) return console.error('Fila no encontrada para editar:', id);
        
        // Esperar un momento para asegurar que Alpine esté listo
        setTimeout(() => {
            const alpineComponent = document.querySelector('[x-data="maquinariasApp()"]');
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
    
    window.viewMaquinaria = function(id) {
        const row = window.getMaquinariaById(id);
        if (!row) return console.error('Fila no encontrada para ver:', id);
        
        // Esperar un momento para asegurar que Alpine esté listo
        setTimeout(() => {
            const alpineComponent = document.querySelector('[x-data="maquinariasApp()"]');
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
    window.changeEstadoById = function(id) {
        const row = window.getMaquinariaById(id);
        if (!row) return console.error('Fila no encontrada para cambiar estado:', id);
        changeEstado(row);
    };

    // DataTable
    document.addEventListener('DOMContentLoaded', function () {
        $.fn.dataTable.ext.errMode = 'none';
        const table = $('#maquinariasTable').DataTable({
            processing: true,
            serverSide: true,
            rowId: 'id',
            ajax: {
                url: "{{ route('admin.maquinarias.datatable') }}",
                data: function(d) {
                    // Usar parámetros personalizados para no interferir con DataTables
                    d.custom_search = $('#searchInput').val();
                    d.estadoFilter = $('#filterEstado').val();
                }
            },
            columns: [
                { data: 'nombre', name: 'nombre' },
                { data: 'tipo', name: 'tipo', render: v => v ? v.charAt(0).toUpperCase() + v.slice(1) : '' },
                { data: null, render: row => `${row.marca} ${row.modelo}` },
                { data: 'horometro_actual', render: v => `${v} hrs` },
                { 
                    data: 'estado', 
                    render: function(v) {
                        const colors = {
                            activo: 'bg-green-500/20 text-green-400 border-green-500/30',
                            inactivo: 'bg-red-500/20 text-red-400 border-red-500/30',
                            mantencion: 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30'
                        };
                        const estadoText = {
                            activo: 'Activo',
                            inactivo: 'Inactivo',
                            mantencion: 'Mantención'
                        };
                        return `<span class="px-2 py-1 text-xs rounded-full border ${colors[v]||'bg-gray-500/20 text-gray-400 border-gray-500/30'}">${estadoText[v] || v}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false, 
                    searchable: false,
                    render: function(row) {
                        return `
                            <div class="flex items-center space-x-2 table-actions">
                                <button type="button" onclick="editMaquinaria(${row.id})" class="p-1 bg-blue-500/20 text-blue-400 rounded hover:bg-blue-500/30 transition-colors" title="Editar">
                                    <i class="fas fa-edit text-xs"></i>
                                </button>
                                <button type="button" onclick="changeEstadoById(${row.id})" class="p-1 bg-yellow-500/20 text-yellow-400 rounded hover:bg-yellow-500/30 transition-colors" title="Cambiar Estado">
                                    <i class="fas fa-exchange-alt text-xs"></i>
                                </button>
                                <button type="button" onclick="viewMaquinaria(${row.id})" class="p-1 bg-green-500/20 text-green-400 rounded hover:bg-green-500/30 transition-colors" title="Ver Detalles">
                                    <i class="fas fa-eye text-xs"></i>
                                </button>
                                <button type="button" class="p-1 bg-red-500/20 text-red-400 rounded hover:bg-red-500/30 transition-colors" title="Eliminar" onclick="deleteMaquinaria(${row.id})">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: { 
                url: "https://cdn.datatables.net/plug-ins/1.13.8/i18n/es-ES.json",
            },
            drawCallback: function(settings) {
                // Actualizar estadísticas después de cargar datos
                const data = this.api().data();
                // Aquí podrías actualizar los contadores si es necesario
            }
        });
        window.maquinariasDT = table;
        $('#maquinariasTable').on('error.dt', function (e, settings, techNote, message) {
            console.error('DataTable error:', message);
        });

        $('#searchInput, #filterEstado').on('keyup change', () => table.draw());
        $('#resetFilters').on('click', function() {
            $('#searchInput').val('');
            $('#filterEstado').val('');
            table.draw();
        });
    });
</script>
@endpush