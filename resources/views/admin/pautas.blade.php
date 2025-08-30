@extends('layouts.admin')

@section('title', 'Gestión de Pautas de Mantención')
@section('subtitle', 'Administra las pautas de mantención preventiva')

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
    
    #pautasTable tbody tr {
        background-color: #18181b;
        border-bottom: 1px solid #3f3f46;
    }
    
    #pautasTable tbody tr:hover {
        background-color: #27272a;
    }
    
    .table-actions {
        opacity: 0.7;
        transition: opacity 0.2s ease;
    }
    
    tr:hover .table-actions {
        opacity: 1;
    }
    
    .badge-tipo {
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-camion {
        background-color: #3b82f620;
        color: #60a5fa;
        border: 1px solid #3b82f630;
    }
    
    .badge-maquina {
        background-color: #10b98120;
        color: #34d399;
        border: 1px solid #10b98130;
    }
    
    .badge-ambos {
        background-color: #f59e0b20;
        color: #fbbf24;
        border: 1px solid #f59e0b30;
    }
</style>
@endpush

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i class="fas fa-angle-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-orange-400">Pautas de Mantención</span>
    </div>
</li>
@endsection

@section('content')
<div id="pautasRoot" class="container mx-auto px-4 py-6" x-data="pautasApp()" x-init="window.pautasCtx = $data">
    <!-- Header con estadísticas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-orange-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Total Pautas</p>
                    <p class="text-2xl font-bold text-white">24</p>
                </div>
                <div class="bg-orange-500/20 p-3 rounded-full">
                    <i class="fas fa-clipboard-list text-orange-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Para Camiones</p>
                    <p class="text-2xl font-bold text-white">12</p>
                </div>
                <div class="bg-blue-500/20 p-3 rounded-full">
                    <i class="fas fa-truck text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Para Máquinas</p>
                    <p class="text-2xl font-bold text-white">8</p>
                </div>
                <div class="bg-green-500/20 p-3 rounded-full">
                    <i class="fas fa-tools text-green-400 text-xl"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-zinc-800 rounded-lg p-4 border-l-4 border-purple-500">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-sm text-gray-400">Para Ambos</p>
                    <p class="text-2xl font-bold text-white">4</p>
                </div>
                <div class="bg-purple-500/20 p-3 rounded-full">
                    <i class="fas fa-exchange-alt text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Panel de control -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 mb-6">
        <div class="p-4 border-b border-zinc-700 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
            <h2 class="text-xl font-bold text-white flex items-center">
                <i class="fas fa-list-check mr-2 text-orange-400"></i>
                Listado de Pautas
            </h2>
            
            <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-4 w-full md:w-auto">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-gray-400"></i>
                    </div>
                    <input type="text" id="searchInput" placeholder="Buscar..." 
                           class="pl-10 pr-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 w-full">
                </div>
                
                <select id="filterTipo" class="px-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                    <option value="">Todos los tipos</option>
                    <option value="camion">Camión</option>
                    <option value="maquinaria">Máquina</option>
                    <option value="ambos">Ambos</option>
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
                Nueva Pauta
            </button>
        </div>

        <!-- Tabla -->
        <div class="p-4">
            <div class="overflow-x-auto rounded-lg">
                <table id="pautasTable" class="min-w-full divide-y divide-zinc-700">
                    <thead class="bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tipo Equipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Frecuencia (Horas)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Frecuencia (Días)</th>
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
                    <div class="md:col-span-2">
                        <label class="block text-gray-300 mb-1">Nombre de la Pauta *</label>
                        <input type="text" name="nombre" x-model="form.nombre" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required placeholder="Ej: Mantención Preventiva 250h">
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 mb-1">Tipo de Equipo *</label>
                        <select name="tipo_equipo" x-model="form.tipo_equipo" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            <option value="">Seleccione un tipo</option>
                            <option value="camion">Camión</option>
                            <option value="maquinaria">Máquina</option>
                            <option value="ambos">Ambos</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 mb-1">Frecuencia en Horas</label>
                        <input type="number" step="1" min="0" name="frecuencia_horas" x-model="form.frecuencia_horas" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Ej: 250">
                    </div>
                    
                    <div>
                        <label class="block text-gray-300 mb-1">Frecuencia en Días</label>
                        <input type="number" step="1" min="0" name="frecuencia_dias" x-model="form.frecuencia_dias" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Ej: 90">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label class="block text-gray-300 mb-1">Descripción</label>
                        <textarea name="descripcion" x-model="form.descripcion" rows="4" class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Descripción detallada de la pauta de mantención..."></textarea>
                    </div>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg mb-4">
                    <p class="text-sm text-gray-400 mb-2"><i class="fas fa-info-circle mr-2 text-orange-400"></i> Nota: Complete al menos una frecuencia (horas o días) para que la pauta sea efectiva.</p>
                </div>
                
                <div class="flex justify-end space-x-2 mt-6">
                    <button type="button" @click="closeModal" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition-all duration-200">
                        Guardar Pauta
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ver Detalles -->
    <div x-show="isDetailOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70" style="display: none;">
        <div class="bg-zinc-800 border border-zinc-700 rounded-lg shadow-xl w-11/12 md:w-3/4 lg:w-1/2 p-6 max-h-screen overflow-y-auto" @click.away="closeDetailModal">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-white">Detalles de Pauta</h2>
                <button @click="closeDetailModal" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Nombre</p>
                    <p class="text-white font-medium" x-text="detail.nombre"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Tipo de Equipo</p>
                    <p class="text-white font-medium capitalize" x-text="detail.tipo_equipo"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Frecuencia en Horas</p>
                    <p class="text-white font-medium" x-text="detail.frecuencia_horas ? detail.frecuencia_horas + ' horas' : '-'"></p>
                </div>
                
                <div class="bg-zinc-900 p-4 rounded-lg">
                    <p class="text-sm text-gray-400">Frecuencia en Días</p>
                    <p class="text-white font-medium" x-text="detail.frecuencia_dias ? detail.frecuencia_dias + ' días' : '-'"></p>
                </div>
            </div>
            
            <div class="bg-zinc-900 p-4 rounded-lg mb-4">
                <p class="text-sm text-gray-400 mb-2">Descripción</p>
                <p class="text-white whitespace-pre-line" x-text="detail.descripcion || 'Sin descripción'"></p>
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
window.pautasApp = function () {
    return {
        isOpen: false,
        isDetailOpen: false,
        modalTitle: '',
        currentId: null,
        form: {
            nombre: '',
            tipo_equipo: '',
            descripcion: '',
            frecuencia_horas: '',
            frecuencia_dias: ''
        },
        detail: {},

        openModal(mode, data = null) {
            this.isOpen = true;
            this.modalTitle = mode === 'crear' ? 'Crear Pauta' : 'Editar Pauta';
            this.currentId = data ? data.id : null;

            if (data) {
                this.form = {
                    nombre: data.nombre || '',
                    tipo_equipo: data.tipo_equipo || '',
                    descripcion: data.descripcion || '',
                    frecuencia_horas: data.frecuencia_horas ?? '',
                    frecuencia_dias: data.frecuencia_dias ?? ''
                };
            } else {
                this.form = { 
                    nombre: '', 
                    tipo_equipo: '', 
                    descripcion: '', 
                    frecuencia_horas: '', 
                    frecuencia_dias: '' 
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
                ? `/admin/pautas/${this.currentId}`
                : `{{ route('admin.pautas.store') }}`;

            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            if (this.currentId) formData.append('_method', 'PUT');
            Object.entries(this.form).forEach(([k, v]) => formData.append(k, v ?? ''));

            try {
                const res = await fetch(url, { method: 'POST', body: formData });
                if (!res.ok) throw new Error('Server error');
                $('#pautasTable').DataTable().ajax.reload(null, false);
                this.closeModal();
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Pauta guardada correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo guardar la pauta',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        }
    }
}

// Helpers globales de acciones
window.getPautaById = function (id) {
    try {
        const table = window.pautasDT;
        if (!table) return null;
        // Preferir selección por rowId
        const rowData = table.row('#' + id).data();
        if (rowData) return rowData;
        // Fallback: iterar sobre los datos
        const all = table.rows().data();
        for (let i = 0; i < all.length; i++) {
            const r = all[i];
            if (String(r.id) === String(id)) return r;
        }
        return null;
    } catch (e) { console.error(e); return null; }
};

window.editPauta = function (id) {
    const row = window.getPautaById(id);
    if (!row) return console.error('Fila no encontrada para editar:', id);
    if (window.pautasCtx && typeof window.pautasCtx.openModal === 'function') {
        window.pautasCtx.openModal('editar', row);
    } else {
        console.error('Contexto Alpine no disponible (pautasCtx).');
    }
};

window.viewPauta = function (id) {
    const row = window.getPautaById(id);
    if (!row) return console.error('Fila no encontrada para ver:', id);
    if (window.pautasCtx && typeof window.pautasCtx.openDetailModal === 'function') {
        window.pautasCtx.openDetailModal(row);
    } else {
        console.error('Contexto Alpine no disponible (pautasCtx).');
    }
};

window.deletePauta = function (id) {
    Swal.fire({
        title: '¿Eliminar pauta?',
        text: 'Esta acción no se puede deshacer. También se eliminarán todas las áreas e ítems asociados.',
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
            const res = await fetch(`/admin/pautas/${id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: '_method=DELETE'
            });
            if (!res.ok) throw new Error('Error en servidor');
            $('#pautasTable').DataTable().ajax.reload(null, false);
            Swal.fire({
                icon: 'success',
                title: 'Eliminado',
                text: 'La pauta ha sido eliminada',
                background: '#27272a',
                color: '#fff',
                confirmButtonColor: '#f97316'
            });
        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo eliminar la pauta',
                background: '#27272a',
                color: '#fff',
                confirmButtonColor: '#f97316'
            });
        }
    });
};

 // Navegar a la vista de gestión de áreas/ítems
window.goGestionar = function (id) {
    // Usar la ruta correcta del recurso (admin.pautas.show)
    window.location.href = "{{ url('/admin/pautas') }}/" + id;
};

// DataTable
document.addEventListener('DOMContentLoaded', function () {
    $.fn.dataTable.ext.errMode = 'none';
    const table = $('#pautasTable').DataTable({
        processing: true,
        serverSide: true,
        rowId: 'id',
        ajax: {
            url: "{{ route('admin.pautas.datatable') }}",
            data: function (d) {
                d.custom_search = $('#searchInput').val();
                d.tipoFilter = $('#filterTipo').val();
            }
        },
        columns: [
            { 
                data: 'nombre', 
                name: 'nombre',
                render: function(data, type, row) {
                    return `<span class="font-medium text-white">${data}</span>`;
                }
            },
            { 
                data: 'tipo_equipo', 
                name: 'tipo_equipo', 
                render: function(v) {
                    if (!v) return '-';
                    const normalized = (v === 'maquina') ? 'maquinaria' : v;
                    const badgeClassMap = {
                        camion: 'badge-camion',
                        maquinaria: 'badge-maquina',
                        ambos: 'badge-ambos'
                    };
                    const displayMap = {
                        camion: 'Camión',
                        maquinaria: 'Máquina',
                        ambos: 'Ambos'
                    };
                    const klass = badgeClassMap[normalized] || 'badge-camion';
                    const text = displayMap[normalized] || normalized;
                    return `<span class="badge-tipo ${klass}">${text}</span>`;
                }
            },
            { 
                data: 'frecuencia_horas', 
                name: 'frecuencia_horas', 
                render: function(v) {
                    return v ? `<span class="text-orange-400 font-medium">${v} hrs</span>` : '<span class="text-gray-400">-</span>';
                }
            },
            { 
                data: 'frecuencia_dias', 
                name: 'frecuencia_dias', 
                render: function(v) {
                    return v ? `<span class="text-blue-400 font-medium">${v} días</span>` : '<span class="text-gray-400">-</span>';
                }
            },
            {
                data: null,
                orderable: false, 
                searchable: false,
                render: function (row) {
                    return `
                        <div class="flex items-center space-x-2 table-actions">
                            <button type="button" onclick="editPauta(${row.id})" class="p-1 bg-blue-500/20 text-blue-400 rounded hover:bg-blue-500/30 transition-colors" title="Editar">
                                <i class="fas fa-edit text-xs"></i>
                            </button>
                            <button type="button" onclick="goGestionar(${row.id})" class="p-1 bg-indigo-500/20 text-indigo-400 rounded hover:bg-indigo-500/30 transition-colors" title="Gestionar Áreas">
                                <i class="fas fa-layer-group text-xs"></i>
                            </button>
                            <button type="button" onclick="viewPauta(${row.id})" class="p-1 bg-green-500/20 text-green-400 rounded hover:bg-green-500/30 transition-colors" title="Ver Detalles">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                            <button type="button" class="p-1 bg-red-500/20 text-red-400 rounded hover:bg-red-500/30 transition-colors" title="Eliminar" onclick="deletePauta(${row.id})">
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
    window.pautasDT = table;

    $('#pautasTable').on('error.dt', function (e, settings, techNote, message) {
        console.error('DataTable error:', message);
    });

    $('#searchInput, #filterTipo').on('keyup change', () => table.draw());
    $('#resetFilters').on('click', function () {
        $('#searchInput').val('');
        $('#filterTipo').val('');
        table.draw();
    });
});
</script>
@endpush