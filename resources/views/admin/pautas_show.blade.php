@extends('layouts.admin')

@section('title', 'Pauta: ' . $pauta->nombre)
@section('subtitle', 'Gestión de áreas e ítems de la pauta')

@section('breadcrumb')
<li>
    <div class="flex items-center">
        <i class="fas fa-angle-right text-gray-400 mx-2"></i>
        <a href="{{ route('admin.pautas.index') }}" class="text-sm font-medium text-gray-300 hover:text-white transition-colors">
            Pautas
        </a>
    </div>
</li>
<li>
    <div class="flex items-center">
        <i class="fas fa-angle-right text-gray-400 mx-2"></i>
        <span class="text-sm font-medium text-orange-400">Gestión</span>
    </div>
</li>
@endsection

@section('content')
<div class="container mx-auto px-4 py-6" x-data='pautaShowApp({{ $pauta->id }}, @json($pauta))'>
    <!-- Encabezado de la pauta -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 p-6 mb-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between">
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-white mb-2">{{ $pauta->nombre }}</h1>
                
                <div class="flex flex-wrap items-center gap-4 mb-3">
                    <div class="flex items-center">
                        <span class="text-sm text-gray-400 mr-2">Tipo:</span>
                        <span class="text-sm font-medium text-orange-400 capitalize">{{ $pauta->tipo_equipo }}</span>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-sm text-gray-400 mr-2">Frecuencia horas:</span>
                        <span class="text-sm font-medium text-white">{{ $pauta->frecuencia_horas ?? 'N/A' }}</span>
                    </div>
                    
                    <div class="flex items-center">
                        <span class="text-sm text-gray-400 mr-2">Frecuencia días:</span>
                        <span class="text-sm font-medium text-white">{{ $pauta->frecuencia_dias ?? 'N/A' }}</span>
                    </div>
                </div>
                
                @if($pauta->descripcion)
                    <div class="bg-zinc-900 p-4 rounded-lg border border-zinc-700">
                        <p class="text-gray-300 whitespace-pre-line">{{ $pauta->descripcion }}</p>
                    </div>
                @endif
            </div>
            
            <div class="mt-4 md:mt-0 md:ml-6">
                <a href="{{ route('admin.pautas.index') }}" class="flex items-center px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Volver al listado
                </a>
            </div>
        </div>
    </div>

    <!-- Crear Área -->
    <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 p-6 mb-6">
        <h2 class="text-lg font-semibold text-white mb-4 flex items-center">
            <i class="fas fa-plus-circle mr-2 text-orange-400"></i>
            Agregar Nueva Área
        </h2>
        
        <form @submit.prevent="createArea" class="flex flex-col md:flex-row gap-4 items-start md:items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-gray-300 mb-2">Nombre del área</label>
                <input type="text" x-model="newAreaName" placeholder="Ej: Motor, Sistema Hidráulico, Frenos..." 
                       class="w-full bg-zinc-900 border border-zinc-700 rounded px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>
            <button type="submit" class="px-6 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition-all duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Agregar Área
            </button>
        </form>
    </div>

    <!-- Listado de Áreas e Ítems -->
    <template x-for="(area, aIdx) in pauta.areas" :key="area.id">
        <div class="bg-zinc-800 rounded-lg shadow-lg border border-zinc-700 mb-6" 
             x-init="if (!area._newItem) area._newItem = { descripcion: '', tipo: '' }">
            
            <!-- Encabezado del Área -->
            <div class="border-b border-zinc-700 px-6 py-4 flex flex-col md:flex-row md:items-center justify-between">
                <div class="flex items-center space-x-3 mb-3 md:mb-0">
                    <div class="w-2 h-6 bg-orange-500 rounded-full"></div>
                    <input x-show="area._editing" x-model="area._nombre" type="text" 
                           class="bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" 
                           :value="area.nombre" x-cloak>
                    <h3 x-show="!area._editing" class="text-lg font-semibold text-white" x-text="area.nombre"></h3>
                    <span class="text-sm text-gray-400" x-text="`(${area.items?.length || 0} ítems)`"></span>
                </div>
                
                <div class="flex items-center space-x-2">
                    <button x-show="!area._editing" @click="startEditArea(area)" 
                            class="px-3 py-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors flex items-center">
                        <i class="fas fa-edit text-xs mr-1"></i>
                        Editar
                    </button>
                    
                    <button x-show="area._editing" @click="saveEditArea(area)" 
                            class="px-3 py-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors flex items-center" x-cloak>
                        <i class="fas fa-check text-xs mr-1"></i>
                        Guardar
                    </button>
                    
                    <button x-show="area._editing" @click="cancelEditArea(area)" 
                            class="px-3 py-2 bg-gray-500/20 text-gray-400 rounded-lg hover:bg-gray-500/30 transition-colors flex items-center" x-cloak>
                        <i class="fas fa-times text-xs mr-1"></i>
                        Cancelar
                    </button>
                    
                    <button @click="deleteArea(area)" 
                            class="px-3 py-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors flex items-center">
                        <i class="fas fa-trash text-xs mr-1"></i>
                        Eliminar
                    </button>
                </div>
            </div>

            <!-- Agregar Ítem -->
            <div class="px-6 py-4 border-b border-zinc-700 bg-zinc-900/50">
                <h4 class="text-md font-medium text-white mb-3 flex items-center">
                    <i class="fas fa-plus-square mr-2 text-orange-400"></i>
                    Agregar Nuevo Ítem
                </h4>
                
                <form @submit.prevent="createItem(area)" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                    <div>
                        <label class="block text-sm text-gray-300 mb-2">Descripción del ítem</label>
                        <input type="text" x-model="area._newItem.descripcion" 
                               class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500" 
                               placeholder="Ej: Revisar nivel de aceite, Inspeccionar frenos..." required>
                    </div>
                    
                    <div>
                        <label class="block text-sm text-gray-300 mb-2">Tipo de actividad</label>
                        <select x-model="area._newItem.tipo" 
                                class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            <option value="">Seleccione tipo</option>
                            <option value="chequeo">Chequeo</option>
                            <option value="lubricacion">Lubricación</option>
                            <option value="ajuste">Ajuste</option>
                            <option value="cambio">Cambio</option>
                            <option value="limpieza">Limpieza</option>
                            <option value="inspeccion">Inspección</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                    
                    <div class="flex space-x-2">
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition-all duration-200 flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Agregar
                        </button>
                        <button type="button" @click="resetNewItem(area)" 
                                class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors flex items-center">
                            <i class="fas fa-eraser mr-2"></i>
                            Limpiar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Lista de Ítems -->
            <div class="px-6 py-4">
                <h4 class="text-md font-medium text-white mb-3 flex items-center">
                    <i class="fas fa-list-check mr-2 text-orange-400"></i>
                    Ítems de esta área
                </h4>
                
                <div class="overflow-x-auto rounded-lg">
                    <table class="min-w-full">
                        <thead class="bg-zinc-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Descripción</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tipo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider w-40">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-700">
                            <template x-for="(item, iIdx) in (area.items || [])" :key="item.id">
                                <tr class="hover:bg-zinc-900/50 transition-colors">
                                    <td class="px-4 py-3">
                                        <div x-show="!item._editing" class="text-white" x-text="item.descripcion"></div>
                                        <input x-show="item._editing" type="text" 
                                               class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                               x-model="item._descripcion" x-cloak>
                                    </td>
                                    
                                    <td class="px-4 py-3">
                                        <div x-show="!item._editing" class="text-gray-300 capitalize" x-text="item.tipo"></div>
                                        <select x-show="item._editing" 
                                                class="w-full bg-zinc-900 border border-zinc-700 rounded px-3 py-2 text-white focus:outline-none focus:ring-2 focus:ring-orange-500" 
                                                x-model="item._tipo" x-cloak>
                                            <option value="chequeo">Chequeo</option>
                                            <option value="lubricacion">Lubricación</option>
                                            <option value="ajuste">Ajuste</option>
                                            <option value="cambio">Cambio</option>
                                            <option value="limpieza">Limpieza</option>
                                            <option value="inspeccion">Inspección</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </td>
                                    
                                    <td class="px-4 py-3">
                                        <div class="flex items-center space-x-2">
                                            <button x-show="!item._editing" @click="startEditItem(item)" 
                                                    class="p-2 bg-blue-500/20 text-blue-400 rounded-lg hover:bg-blue-500/30 transition-colors" title="Editar">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>
                                            
                                            <button x-show="item._editing" @click="saveEditItem(item)" 
                                                    class="p-2 bg-green-500/20 text-green-400 rounded-lg hover:bg-green-500/30 transition-colors" title="Guardar" x-cloak>
                                                <i class="fas fa-check text-xs"></i>
                                            </button>
                                            
                                            <button x-show="item._editing" @click="cancelEditItem(item)" 
                                                    class="p-2 bg-gray-500/20 text-gray-400 rounded-lg hover:bg-gray-500/30 transition-colors" title="Cancelar" x-cloak>
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                            
                                            <button @click="deleteItem(item, area)" 
                                                    class="p-2 bg-red-500/20 text-red-400 rounded-lg hover:bg-red-500/30 transition-colors" title="Eliminar">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            
                            <tr x-show="!area.items || area.items.length === 0">
                                <td colspan="3" class="px-4 py-4 text-center text-gray-400">
                                    <i class="fas fa-inbox text-2xl mb-2 opacity-50"></i>
                                    <p>No hay ítems en esta área</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </template>

    <!-- Estado vacío -->
    <div x-show="!pauta.areas || pauta.areas.length === 0" class="text-center py-12 text-gray-400">
        <i class="fas fa-layer-group text-4xl mb-4 opacity-50"></i>
        <h3 class="text-lg font-medium mb-2">No hay áreas configuradas</h3>
        <p class="max-w-md mx-auto">Comienza agregando áreas para organizar los ítems de mantención de esta pauta.</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
window.pautaShowApp = function (pautaId, pauta) {
    return {
        pauta: pauta,
        newAreaName: '',

        // Área - Crear
        async createArea() {
            if (!this.newAreaName) return;
            
            const url = `/admin/pautas/${pautaId}/areas`;
            const body = new URLSearchParams();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            body.append('nombre', this.newAreaName);
            
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: body.toString()
                });
                
                if (!res.ok) throw new Error('Server error');
                const data = await res.json();
                
                if (!this.pauta.areas) this.pauta.areas = [];
                const newArea = { 
                    ...data.data, 
                    items: [], 
                    _editing: false, 
                    _newItem: { descripcion: '', tipo: '' } 
                };
                
                this.pauta.areas.push(newArea);
                this.newAreaName = '';
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Área creada correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo crear el área',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        },

        // Área - Editar ciclo
        startEditArea(area) {
            area._editing = true;
            area._nombre = area.nombre;
        },
        
        cancelEditArea(area) {
            area._editing = false;
            delete area._nombre;
        },
        
        async saveEditArea(area) {
            const url = `/admin/pauta-areas/${area.id}`;
            const body = new URLSearchParams();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            body.append('_method', 'PUT');
            body.append('nombre', area._nombre || area.nombre);
            
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: body.toString()
                });
                
                if (!res.ok) throw new Error('Server error');
                const data = await res.json();
                
                area.nombre = data.data.nombre;
                area._editing = false;
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Área actualizada correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el área',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        },
        
        async deleteArea(area) {
            const confirm = await Swal.fire({
                title: '¿Eliminar área?',
                text: 'Se eliminarán también todos sus ítems. Esta acción no se puede deshacer.',
                icon: 'warning',
                background: '#27272a',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!confirm.isConfirmed) return;
            
            const url = `/admin/pauta-areas/${area.id}`;
            const body = new URLSearchParams();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            body.append('_method', 'DELETE');
            
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: body.toString()
                });
                
                if (!res.ok) throw new Error('Server error');
                this.pauta.areas = (this.pauta.areas || []).filter(a => a.id !== area.id);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: 'Área eliminada correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar el área',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        },

        // Ítem - Helpers
        resetNewItem(area) {
            area._newItem = { descripcion: '', tipo: '' };
        },

        // Ítem - Crear
        async createItem(area) {
            if (!area._newItem || !area._newItem.descripcion || !area._newItem.tipo) return;
            
            const url = `/admin/pauta-areas/${area.id}/items`;
            const body = new URLSearchParams();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            body.append('descripcion', area._newItem.descripcion);
            body.append('tipo', area._newItem.tipo);
            
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: body.toString()
                });
                
                if (!res.ok) throw new Error('Server error');
                const data = await res.json();
                
                if (!area.items) area.items = [];
                area.items.push({ ...data.data, _editing: false });
                this.resetNewItem(area);
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Ítem creado correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo crear el ítem',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        },

        // Ítem - Editar ciclo
        startEditItem(item) {
            item._editing = true;
            item._descripcion = item.descripcion;
            item._tipo = item.tipo;
        },
        
        cancelEditItem(item) {
            item._editing = false;
            delete item._descripcion;
            delete item._tipo;
        },
        
        async saveEditItem(item) {
            const url = `/admin/pauta-items/${item.id}`;
            const body = new URLSearchParams();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            body.append('_method', 'PUT');
            body.append('descripcion', item._descripcion || item.descripcion);
            body.append('tipo', item._tipo || item.tipo);
            
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: body.toString()
                });
                
                if (!res.ok) throw new Error('Server error');
                const data = await res.json();
                
                item.descripcion = data.data.descripcion;
                item.tipo = data.data.tipo;
                item._editing = false;
                
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Ítem actualizado correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el ítem',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        },
        
        async deleteItem(item, area) {
            const confirm = await Swal.fire({
                title: '¿Eliminar ítem?',
                icon: 'warning',
                background: '#27272a',
                color: '#fff',
                showCancelButton: true,
                confirmButtonColor: '#f97316',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });
            
            if (!confirm.isConfirmed) return;
            
            const url = `/admin/pauta-items/${item.id}`;
            const body = new URLSearchParams();
            body.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
            body.append('_method', 'DELETE');
            
            try {
                const res = await fetch(url, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: body.toString()
                });
                
                if (!res.ok) throw new Error('Server error');
                area.items = (area.items || []).filter(i => i.id !== item.id);
                
                Swal.fire({
                    icon: 'success',
                    title: 'Eliminado',
                    text: 'Ítem eliminado correctamente',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            } catch (e) {
                console.error(e);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo eliminar el ítem',
                    background: '#27272a',
                    color: '#fff',
                    confirmButtonColor: '#f97316'
                });
            }
        },

        // Init
        init() {
            // preparar flags internos
            if (!this.pauta.areas) this.pauta.areas = [];
            this.pauta.areas.forEach(a => {
                a._editing = false;
                a._newItem = { descripcion: '', tipo: '' };
                (a.items || []).forEach(i => i._editing = false);
            });
        }
    }
}
</script>
@endpush