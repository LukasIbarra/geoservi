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

    /* Estilos para el toggle de vista */
    .view-toggle {
        display: flex;
        gap: 0.5rem;
    }

    .view-toggle-btn {
        display: flex;
        align-items: center;
        padding: 0.5rem 1rem;
        background: #27272a;
        border: 1px solid #3f3f46;
        color: #a1a1aa;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .view-toggle-btn:hover {
        background: #3f3f46;
        color: white;
    }

    .view-toggle-btn.active {
        background: linear-gradient(to right, #f97316, #ea580c);
        color: white;
        border-color: #f97316;
    }

    .view-toggle-btn i {
        font-size: 0.875rem;
    }

    /* Estilos para las cards - Diseño Profesional */
    .maquinaria-card {
        background: linear-gradient(135deg, #27272a 0%, #1f1f23 100%);
        border: 1px solid #3f3f46;
        border-radius: 1rem;
        padding: 1.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
    }

    .maquinaria-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #f97316, #ea580c);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .maquinaria-card:hover {
        border-color: #f97316;
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .maquinaria-card:hover::before {
        opacity: 1;
    }

    .maquinaria-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.25rem;
        position: relative;
    }

    .maquinaria-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.375rem;
        letter-spacing: -0.025em;
    }

    .maquinaria-card-subtitle {
        font-size: 0.875rem;
        color: #a1a1aa;
        font-weight: 500;
    }

    .maquinaria-card-status {
        padding: 0.375rem 0.875rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        backdrop-filter: blur(10px);
        border: 1px solid transparent;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }

    .maquinaria-card-status.activo {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.25));
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.3);
        box-shadow: 0 0 0 1px rgba(34, 197, 94, 0.1);
    }

    .maquinaria-card-status.inactivo {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.25));
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
        box-shadow: 0 0 0 1px rgba(239, 68, 68, 0.1);
    }

    .maquinaria-card-status.mantencion {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.25));
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.3);
        box-shadow: 0 0 0 1px rgba(245, 158, 11, 0.1);
    }

    .maquinaria-card-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .maquinaria-card-info-item {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .maquinaria-card-info-label {
        font-size: 0.6875rem;
        color: #a1a1aa;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.05em;
        margin-bottom: 0.375rem;
    }

    .maquinaria-card-info-value {
        font-size: 0.9375rem;
        color: white;
        font-weight: 600;
        line-height: 1.4;
    }

    .maquinaria-card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 1.25rem;
    }

    .maquinaria-card-actions-left {
        display: flex;
        gap: 0.5rem;
    }

    .maquinaria-card-actions-right {
        display: flex;
        gap: 0.5rem;
    }

    .maquinaria-card-action-btn {
        padding: 0.5rem;
        border-radius: 0.5rem;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.875rem;
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .maquinaria-card-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }

    .maquinaria-card-action-btn:hover::before {
        left: 100%;
    }

    .maquinaria-card-action-btn.edit {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.25));
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.3);
    }

    .maquinaria-card-action-btn.edit:hover {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(59, 130, 246, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .maquinaria-card-action-btn.status {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.25));
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .maquinaria-card-action-btn.status:hover {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.25), rgba(245, 158, 11, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .maquinaria-card-action-btn.view {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.25));
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.3);
    }

    .maquinaria-card-action-btn.view:hover {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(34, 197, 94, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .maquinaria-card-action-btn.delete {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.25));
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .maquinaria-card-action-btn.delete:hover {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(239, 68, 68, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .maquinaria-card-horometro {
        font-size: 1.375rem;
        font-weight: 800;
        color: #f97316;
        text-shadow: 0 0 10px rgba(249, 115, 22, 0.3);
        letter-spacing: -0.025em;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .maquinaria-card {
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .maquinaria-card-info {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .maquinaria-card-actions {
            flex-direction: column;
            gap: 0.75rem;
            align-items: stretch;
        }

        .maquinaria-card-actions-left,
        .maquinaria-card-actions-right {
            justify-content: center;
        }
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
                    <input type="text" id="searchInput" placeholder="Buscar maquinarias..."
                           class="pl-10 pr-4 py-2 bg-zinc-900 border border-zinc-700 rounded-lg text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 w-full">
                </div>

                <button id="toggleFilters" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors flex items-center">
                    <i class="fas fa-filter mr-2"></i> Filtros
                    <i class="fas fa-chevron-down ml-2 transition-transform duration-200" id="filterIcon"></i>
                </button>
            </div>
        </div>

        <!-- Filtros Expandidos Mejorados -->
        <div id="filtersPanel" class="border-b border-zinc-700 bg-zinc-900/50" style="display: none;">
            <div class="p-4">
                <!-- Filtros Rápidos -->
                <div class="mb-4">
                    <h4 class="text-sm font-medium text-gray-300 mb-3 flex items-center">
                        <i class="fas fa-bolt mr-2 text-orange-400"></i>Filtros Rápidos
                    </h4>
                    <div class="flex flex-wrap gap-2">
                        <button id="filterAll" class="px-3 py-1 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-full text-xs transition-colors quick-filter-btn active">
                            <i class="fas fa-list mr-1"></i>Todas
                        </button>
                        <button id="filterActivo" class="px-3 py-1 bg-green-500/20 hover:bg-green-500/30 text-green-400 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-check-circle mr-1"></i>Activas
                        </button>
                        <button id="filterInactivo" class="px-3 py-1 bg-red-500/20 hover:bg-red-500/30 text-red-400 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-times-circle mr-1"></i>Inactivas
                        </button>
                        <button id="filterMantencion" class="px-3 py-1 bg-yellow-500/20 hover:bg-yellow-500/30 text-yellow-400 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-tools mr-1"></i>En Mantención
                        </button>
                        <button id="filterRecent" class="px-3 py-1 bg-purple-500/20 hover:bg-purple-500/30 text-purple-400 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-calendar-alt mr-1"></i>Recientes
                        </button>
                    </div>
                </div>

                <!-- Filtros Avanzados -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    <!-- Estado -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-toggle-on mr-2 text-orange-400"></i>Estado
                        </label>
                        <select id="filterEstado" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Todos los estados</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>
                            <option value="mantencion">En Mantención</option>
                        </select>
                    </div>

                    <!-- Tipo de Maquinaria -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-cogs mr-2 text-orange-400"></i>Tipo
                        </label>
                        <select id="filterTipo" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Todos los tipos</option>
                            <option value="camion">Camión</option>
                            <option value="excavadora">Excavadora</option>
                            <option value="cargador">Cargador</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <!-- Horómetro Mínimo -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-clock mr-2 text-orange-400"></i>Horómetro Min
                        </label>
                        <input type="number" id="filterHorometroMin" step="0.01" min="0"
                               class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="0.00">
                    </div>

                    <!-- Horómetro Máximo -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-clock mr-2 text-orange-400"></i>Horómetro Max
                        </label>
                        <input type="number" id="filterHorometroMax" step="0.01" min="0"
                               class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="99999.99">
                    </div>

                    <!-- Fecha Compra Desde -->
                    <div class="space-y-2">
                        <label for="fechaCompraDesde" class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-calendar-alt mr-2 text-orange-400"></i>Compra Desde
                        </label>
                        <div class="relative">
                            <input type="date" id="fechaCompraDesde" class="w-full pl-10 pr-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Fecha Compra Hasta -->
                    <div class="space-y-2">
                        <label for="fechaCompraHasta" class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-calendar-alt mr-2 text-orange-400"></i>Compra Hasta
                        </label>
                        <div class="relative">
                            <input type="date" id="fechaCompraHasta" class="w-full pl-10 pr-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Resumen de Filtros Activos -->
                <div id="activeFiltersSummary" class="mt-4 p-3 bg-zinc-800/50 rounded-lg" style="display: none;">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center text-sm text-gray-300">
                            <i class="fas fa-filter mr-2 text-orange-400"></i>
                            <span>Filtros activos:</span>
                            <span id="activeFiltersCount" class="ml-2 px-2 py-1 bg-orange-500/20 text-orange-400 rounded-full text-xs">0</span>
                        </div>
                        <button id="clearAllFilters" class="text-xs text-red-400 hover:text-red-300 transition-colors">
                            <i class="fas fa-times mr-1"></i>Limpiar todo
                        </button>
                    </div>
                    <div id="activeFiltersList" class="mt-2 flex flex-wrap gap-2"></div>
                </div>

                <!-- Botones de Acción -->
                <div class="flex justify-end space-x-3 mt-6">
                    <button id="resetFilters" class="px-4 py-2 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-lg transition-colors flex items-center">
                        <i class="fas fa-times mr-2"></i> Limpiar Filtros
                    </button>
                    <button id="applyFilters" class="px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white rounded-lg transition-colors flex items-center">
                        <i class="fas fa-search mr-2"></i> Aplicar Filtros
                    </button>
                </div>
            </div>
        </div>

        <!-- Controles superiores -->
        <div class="p-4 border-b border-zinc-700">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0">
                <!-- Toggle Vista -->
                <div class="view-toggle">
                    <button @click="setViewMode('table')" :class="{ 'active': viewMode === 'table' }" class="view-toggle-btn">
                        <i class="fas fa-table mr-2"></i>
                        Tabla
                    </button>
                    <button @click="setViewMode('cards')" :class="{ 'active': viewMode === 'cards' }" class="view-toggle-btn">
                        <i class="fas fa-th mr-2"></i>
                        Cards
                    </button>
                </div>

                <!-- Botón crear -->
                <button @click="openModal('crear')" class="btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Nueva Maquinaria
                </button>
            </div>
        </div>

        <!-- Vista de Tabla -->
        <div class="p-4 mobile-table-view" x-show="viewMode === 'table'" x-transition>
            <div class="table-responsive">
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

        <!-- Vista de Cards -->
        <div class="p-4 mobile-cards-view" x-show="viewMode === 'cards'" x-transition>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="maquinariasCards">
                <!-- Cards se cargarán dinámicamente -->
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
            viewMode: 'table', // Vista por defecto
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
            setViewMode(mode) {
                this.viewMode = mode;
                if (mode === 'cards') {
                    this.loadCards();
                }
            },
            async loadCards() {
                try {
                    // Construir URL con parámetros de consulta
                    const baseUrl = "{{ route('admin.maquinarias.datatable') }}";
                    const params = new URLSearchParams({
                        draw: '1',
                        start: '0',
                        length: '1000', // Cargar muchas para las cards
                        custom_search: $('#searchInput').val() || '',
                        estadoFilter: $('#filterEstado').val() || '',
                        horometroMin: $('#horometroMin').val() || '',
                        horometroMax: $('#horometroMax').val() || '',
                        fechaCompraDesde: $('#fechaCompraDesde').val() || '',
                        fechaCompraHasta: $('#fechaCompraHasta').val() || '',
                        fechaCreacionDesde: $('#fechaCreacionDesde').val() || '',
                        fechaCreacionHasta: $('#fechaCreacionHasta').val() || ''
                    });

                    const response = await fetch(`${baseUrl}?${params}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    });

                    if (!response.ok) throw new Error('Error al cargar datos');

                    const data = await response.json();
                    this.renderCards(data.data);
                } catch (error) {
                    console.error('Error cargando cards:', error);
                    $('#maquinariasCards').html('<div class="col-span-full text-center text-gray-400 py-8">Error al cargar las maquinarias</div>');
                }
            },
            renderCards(maquinarias) {
                const container = document.getElementById('maquinariasCards');
                if (!maquinarias || maquinarias.length === 0) {
                    container.innerHTML = '<div class="col-span-full text-center text-gray-400 py-8">No se encontraron maquinarias</div>';
                    return;
                }

                const cardsHtml = maquinarias.map(maquinaria => this.createCardHtml(maquinaria)).join('');
                container.innerHTML = cardsHtml;
            },
            createCardHtml(maquinaria) {
                const estadoClasses = {
                    activo: 'activo',
                    inactivo: 'inactivo',
                    mantencion: 'mantencion'
                };

                const estadoText = {
                    activo: 'Activo',
                    inactivo: 'Inactivo',
                    mantencion: 'Mantención'
                };

                const tipoIcon = {
                    camion: 'fa-truck',
                    excavadora: 'fa-excavator',
                    cargador: 'fa-truck-loading',
                    otro: 'fa-cogs'
                };

                return `
                    <div class="maquinaria-card">
                        <div class="maquinaria-card-header">
                            <div>
                                <div class="maquinaria-card-title">
                                    <i class="fas ${tipoIcon[maquinaria.tipo] || 'fa-cogs'} mr-2 text-orange-400"></i>
                                    ${maquinaria.nombre}
                                </div>
                                <div class="maquinaria-card-subtitle">${maquinaria.marca} ${maquinaria.modelo}</div>
                            </div>
                            <span class="maquinaria-card-status ${estadoClasses[maquinaria.estado] || 'activo'}">
                                ${estadoText[maquinaria.estado] || 'Activo'}
                            </span>
                        </div>

                        <div class="maquinaria-card-info">
                            <div class="maquinaria-card-info-item">
                                <div class="maquinaria-card-info-label">Tipo</div>
                                <div class="maquinaria-card-info-value">${maquinaria.tipo ? maquinaria.tipo.charAt(0).toUpperCase() + maquinaria.tipo.slice(1) : 'N/A'}</div>
                            </div>
                            <div class="maquinaria-card-info-item">
                                <div class="maquinaria-card-info-label">Serie</div>
                                <div class="maquinaria-card-info-value">${maquinaria.serie || 'N/A'}</div>
                            </div>
                            <div class="maquinaria-card-info-item">
                                <div class="maquinaria-card-info-label">Horómetro</div>
                                <div class="maquinaria-card-info-value maquinaria-card-horometro">${maquinaria.horometro_actual || 0} hrs</div>
                            </div>
                            <div class="maquinaria-card-info-item">
                                <div class="maquinaria-card-info-label">Fecha Compra</div>
                                <div class="maquinaria-card-info-value">${maquinaria.fecha_compra || 'N/A'}</div>
                            </div>
                        </div>

                        <div class="maquinaria-card-actions">
                            <div class="maquinaria-card-actions-left">
                                <button onclick="editMaquinaria(${maquinaria.id})" class="maquinaria-card-action-btn edit" title="Editar">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="changeEstadoById(${maquinaria.id})" class="maquinaria-card-action-btn status" title="Cambiar Estado">
                                    <i class="fas fa-exchange-alt"></i>
                                </button>
                                <button onclick="viewMaquinaria(${maquinaria.id})" class="maquinaria-card-action-btn view" title="Ver Detalles">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="maquinaria-card-actions-right">
                                <button onclick="deleteMaquinaria(${maquinaria.id})" class="maquinaria-card-action-btn delete" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
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

    // Sistema de filtros avanzados para maquinarias
    let activeFilters = {};
    let currentQuickFilter = 'all';

    // Función para actualizar filtros activos
    function updateActiveFilters() {
        const filters = [];
        const filterCount = Object.keys(activeFilters).length;

        // Agregar filtros activos a la lista
        if (activeFilters.search && activeFilters.search.trim()) {
            filters.push({ label: `Búsqueda: "${activeFilters.search}"`, type: 'search' });
        }
        if (activeFilters.estado) {
            const estadoText = {
                activo: 'Activo',
                inactivo: 'Inactivo',
                mantencion: 'En Mantención'
            };
            filters.push({ label: `Estado: ${estadoText[activeFilters.estado]}`, type: 'estado' });
        }
        if (activeFilters.tipo) {
            const tipoText = {
                camion: 'Camión',
                excavadora: 'Excavadora',
                cargador: 'Cargador',
                otro: 'Otro'
            };
            filters.push({ label: `Tipo: ${tipoText[activeFilters.tipo]}`, type: 'tipo' });
        }
        if (activeFilters.horometroMin) {
            filters.push({ label: `Horómetro ≥ ${activeFilters.horometroMin}`, type: 'horometroMin' });
        }
        if (activeFilters.horometroMax) {
            filters.push({ label: `Horómetro ≤ ${activeFilters.horometroMax}`, type: 'horometroMax' });
        }
        if (activeFilters.fechaCompraDesde) {
            filters.push({ label: `Compra desde: ${activeFilters.fechaCompraDesde}`, type: 'fechaCompraDesde' });
        }
        if (activeFilters.fechaCompraHasta) {
            filters.push({ label: `Compra hasta: ${activeFilters.fechaCompraHasta}`, type: 'fechaCompraHasta' });
        }

        // Mostrar/ocultar resumen de filtros
        const summary = $('#activeFiltersSummary');
        const list = $('#activeFiltersList');

        if (filters.length > 0) {
            summary.show();
            $('#activeFiltersCount').text(filters.length);

            const filterTags = filters.map(filter => `
                <span class="inline-flex items-center px-2 py-1 text-xs bg-orange-500/20 text-orange-400 rounded-full">
                    ${filter.label}
                    <button onclick="removeFilter('${filter.type}')" class="ml-1 hover:text-orange-300">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </span>
            `).join('');

            list.html(filterTags);
        } else {
            summary.hide();
        }
    }

    // Función para remover filtro específico
    window.removeFilter = function(type) {
        delete activeFilters[type];

        // Actualizar inputs del formulario
        switch(type) {
            case 'search':
                $('#searchInput').val('');
                break;
            case 'estado':
                $('#filterEstado').val('');
                break;
            case 'tipo':
                $('#filterTipo').val('');
                break;
            case 'horometroMin':
                $('#filterHorometroMin').val('');
                break;
            case 'horometroMax':
                $('#filterHorometroMax').val('');
                break;
            case 'fechaCompraDesde':
                $('#fechaCompraDesde').val('');
                break;
            case 'fechaCompraHasta':
                $('#fechaCompraHasta').val('');
                break;
        }

        updateActiveFilters();
        window.maquinariasDT.draw();
    };

    // Función para aplicar filtros rápidos
    function applyQuickFilter(filterType) {
        currentQuickFilter = filterType;

        // Remover clase active de todos los botones
        $('.quick-filter-btn').removeClass('active');

        // Agregar clase active al botón seleccionado
        $(`#filter${filterType.charAt(0).toUpperCase() + filterType.slice(1)}`).addClass('active');

        // Aplicar filtro según el tipo
        switch(filterType) {
            case 'all':
                delete activeFilters.quickFilter;
                $('#filterEstado').val('');
                break;
            case 'activo':
                activeFilters.quickFilter = 'activo';
                $('#filterEstado').val('activo');
                break;
            case 'inactivo':
                activeFilters.quickFilter = 'inactivo';
                $('#filterEstado').val('inactivo');
                break;
            case 'mantencion':
                activeFilters.quickFilter = 'mantencion';
                $('#filterEstado').val('mantencion');
                break;
            case 'recent':
                // Para "recientes" podríamos filtrar por fecha de creación
                const recentDate = new Date();
                recentDate.setMonth(recentDate.getMonth() - 1); // Último mes
                const formattedDate = recentDate.toISOString().split('T')[0];
                $('#fechaCompraDesde').val(formattedDate);
                activeFilters.fechaCompraDesde = formattedDate;
                $('#filterEstado').val('');
                break;
        }

        updateActiveFilters();
        window.maquinariasDT.draw();
    }

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
                    d.tipoFilter = $('#filterTipo').val();
                    d.horometroMin = $('#filterHorometroMin').val();
                    d.horometroMax = $('#filterHorometroMax').val();
                    d.fechaCompraDesde = $('#fechaCompraDesde').val();
                    d.fechaCompraHasta = $('#fechaCompraHasta').val();
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

        // Event listeners para filtros
        $('#searchInput').on('keyup', function() {
            const value = $(this).val().trim();
            if (value) {
                activeFilters.search = value;
            } else {
                delete activeFilters.search;
            }
            updateActiveFilters();
            table.draw();
        });

        // Filtros select y date
        $('#filterEstado, #filterTipo, #filterHorometroMin, #filterHorometroMax, #fechaCompraDesde, #fechaCompraHasta').on('change', function() {
            const id = $(this).attr('id');
            const value = $(this).val();

            if (value && value.trim()) {
                switch(id) {
                    case 'filterEstado':
                        activeFilters.estado = value;
                        break;
                    case 'filterTipo':
                        activeFilters.tipo = value;
                        break;
                    case 'filterHorometroMin':
                        activeFilters.horometroMin = value;
                        break;
                    case 'filterHorometroMax':
                        activeFilters.horometroMax = value;
                        break;
                    case 'fechaCompraDesde':
                        activeFilters.fechaCompraDesde = value;
                        break;
                    case 'fechaCompraHasta':
                        activeFilters.fechaCompraHasta = value;
                        break;
                }
            } else {
                switch(id) {
                    case 'filterEstado':
                        delete activeFilters.estado;
                        break;
                    case 'filterTipo':
                        delete activeFilters.tipo;
                        break;
                    case 'filterHorometroMin':
                        delete activeFilters.horometroMin;
                        break;
                    case 'filterHorometroMax':
                        delete activeFilters.horometroMax;
                        break;
                    case 'fechaCompraDesde':
                        delete activeFilters.fechaCompraDesde;
                        break;
                    case 'fechaCompraHasta':
                        delete activeFilters.fechaCompraHasta;
                        break;
                }
            }

            updateActiveFilters();
            table.draw();
        });

        // Toggle filtros
        $('#toggleFilters').on('click', function() {
            const panel = $('#filtersPanel');
            const icon = $('#filterIcon');

            panel.slideToggle(300, function() {
                if (panel.is(':visible')) {
                    icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
                } else {
                    icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
                }
            });
        });

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
                    d.tipoFilter = $('#filterTipo').val();
                    d.horometroMin = $('#filterHorometroMin').val();
                    d.horometroMax = $('#filterHorometroMax').val();
                    d.fechaCompraDesde = $('#fechaCompraDesde').val();
                    d.fechaCompraHasta = $('#fechaCompraHasta').val();
                    d.fechaCreacionDesde = $('#fechaCreacionDesde').val();
                    d.fechaCreacionHasta = $('#fechaCreacionHasta').val();
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

        // Función para actualizar filtros activos
        function updateActiveFilters() {
            const activeFilters = [];
            const filterCount = $('#activeFiltersCount');
            const filterList = $('#activeFiltersList');
            const filterSummary = $('#activeFiltersSummary');

            // Verificar búsqueda
            if ($('#searchInput').val()) {
                activeFilters.push({ label: 'Búsqueda', value: $('#searchInput').val(), type: 'search' });
            }

            // Verificar filtros
            if ($('#filterEstado').val()) {
                activeFilters.push({ label: 'Estado', value: $('#filterEstado').val(), type: 'estado' });
            }

            if ($('#filterTipo').val()) {
                activeFilters.push({ label: 'Tipo', value: $('#filterTipo').val(), type: 'tipo' });
            }

            if ($('#filterHorometroMin').val()) {
                activeFilters.push({ label: 'Horómetro Min', value: $('#filterHorometroMin').val(), type: 'horometroMin' });
            }

            if ($('#filterHorometroMax').val()) {
                activeFilters.push({ label: 'Horómetro Max', value: $('#filterHorometroMax').val(), type: 'horometroMax' });
            }

            if ($('#fechaCompraDesde').val()) {
                activeFilters.push({ label: 'Compra Desde', value: $('#fechaCompraDesde').val(), type: 'fechaCompraDesde' });
            }

            if ($('#fechaCompraHasta').val()) {
                activeFilters.push({ label: 'Compra Hasta', value: $('#fechaCompraHasta').val(), type: 'fechaCompraHasta' });
            }

            // Actualizar contador
            filterCount.text(activeFilters.length);

            // Mostrar/ocultar resumen
            if (activeFilters.length > 0) {
                filterSummary.show();
                const filterTags = activeFilters.map(filter => `
                    <span class="inline-flex items-center px-2 py-1 text-xs bg-orange-500/20 text-orange-400 rounded-full">
                        <span class="mr-1">${filter.label}:</span>
                        <span>${filter.value}</span>
                        <button onclick="removeFilter('${filter.type}')" class="ml-1 hover:text-red-400">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </span>
                `).join('');
                filterList.html(filterTags);
            } else {
                filterSummary.hide();
            }
        }

        // Función para remover filtro específico
        window.removeFilter = function(type) {
            switch(type) {
                case 'search':
                    $('#searchInput').val('');
                    break;
                case 'estado':
                    $('#filterEstado').val('');
                    break;
                case 'tipo':
                    $('#filterTipo').val('');
                    break;
                case 'horometroMin':
                    $('#filterHorometroMin').val('');
                    break;
                case 'horometroMax':
                    $('#filterHorometroMax').val('');
                    break;
                case 'fechaCompraDesde':
                    $('#fechaCompraDesde').val('');
                    break;
                case 'fechaCompraHasta':
                    $('#fechaCompraHasta').val('');
                    break;
            }
            table.draw();
        };

        // Toggle filtros
        $('#toggleFilters').on('click', function() {
            const panel = $('#filtersPanel');
            const icon = $('#filterIcon');
            panel.slideToggle(300, function() {
                icon.toggleClass('fa-chevron-down fa-chevron-up');
            });
        });

        // Filtros rápidos
        $('.quick-filter-btn').on('click', function() {
            $('.quick-filter-btn').removeClass('active');
            $(this).addClass('active');

            const filterType = $(this).attr('id');
            let estadoValue = '';

            switch(filterType) {
                case 'filterAll':
                    estadoValue = '';
                    break;
                case 'filterActivo':
                    estadoValue = 'activo';
                    break;
                case 'filterInactivo':
                    estadoValue = 'inactivo';
                    break;
                case 'filterMantencion':
                    estadoValue = 'mantencion';
                    break;
                case 'filterRecent':
                    // Para "recientes" podríamos filtrar por fecha de creación
                    estadoValue = '';
                    break;
            }

            $('#filterEstado').val(estadoValue);
            table.draw();
        });

        // Eventos de cambio en filtros
        $('#searchInput, #filterEstado, #filterTipo, #filterHorometroMin, #filterHorometroMax, #fechaCompraDesde, #fechaCompraHasta').on('keyup change', function() {
            table.draw();
        });

        // Limpiar todos los filtros
        $('#clearAllFilters').on('click', function() {
            $('#searchInput').val('');
            $('#filterEstado').val('');
            $('#filterTipo').val('');
            $('#filterHorometroMin').val('');
            $('#filterHorometroMax').val('');
            $('#fechaCompraDesde').val('');
            $('#fechaCompraHasta').val('');
            $('.quick-filter-btn').removeClass('active');
            $('#filterAll').addClass('active');
            table.draw();
        });

        // Limpiar filtros (botón general)
        $('#resetFilters').on('click', function() {
            $('#searchInput').val('');
            $('#filterEstado').val('');
            $('#filterTipo').val('');
            $('#filterHorometroMin').val('');
            $('#filterHorometroMax').val('');
            $('#fechaCompraDesde').val('');
            $('#fechaCompraHasta').val('');
            $('.quick-filter-btn').removeClass('active');
            $('#filterAll').addClass('active');
            table.draw();
        });

        // Actualizar filtros activos después de cada draw
        table.on('draw', function() {
            updateActiveFilters();
        });
    });

        // Filtros rápidos
        $('.quick-filter-btn').on('click', function() {
            $('.quick-filter-btn').removeClass('active');
            $(this).addClass('active');

            const filterType = $(this).attr('id');
            let estadoValue = '';

            switch(filterType) {
                case 'filterAll':
                    estadoValue = '';
                    break;
                case 'filterActivo':
                    estadoValue = 'activo';
                    break;
                case 'filterInactivo':
                    estadoValue = 'inactivo';
                    break;
                case 'filterMantencion':
                    estadoValue = 'mantencion';
                    break;
                case 'filterRecent':
                    // Para "recientes" podríamos filtrar por fecha de creación
                    estadoValue = '';
                    break;
            }

            $('#filterEstado').val(estadoValue);
            table.draw();
        });
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
                    d.tipoFilter = $('#filterTipo').val();
                    d.horometroMin = $('#filterHorometroMin').val();
                    d.horometroMax = $('#filterHorometroMax').val();
                    d.fechaCompraDesde = $('#fechaCompraDesde').val();
                    d.fechaCompraHasta = $('#fechaCompraHasta').val();
                    d.fechaCreacionDesde = $('#fechaCreacionDesde').val();
                    d.fechaCreacionHasta = $('#fechaCreacionHasta').val();
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

        // Función para actualizar filtros activos
        function updateActiveFilters() {
            const activeFilters = [];
            const filterCount = $('#activeFiltersCount');
            const filterList = $('#activeFiltersList');
            const filterSummary = $('#activeFiltersSummary');

            // Verificar búsqueda
            if ($('#searchInput').val()) {
                activeFilters.push({ label: 'Búsqueda', value: $('#searchInput').val(), type: 'search' });
            }

            // Verificar filtros
            if ($('#filterEstado').val()) {
                activeFilters.push({ label: 'Estado', value: $('#filterEstado').val(), type: 'estado' });
            }

            if ($('#filterTipo').val()) {
                activeFilters.push({ label: 'Tipo', value: $('#filterTipo').val(), type: 'tipo' });
            }

            if ($('#filterHorometroMin').val()) {
                activeFilters.push({ label: 'Horómetro Min', value: $('#filterHorometroMin').val(), type: 'horometroMin' });
            }

            if ($('#filterHorometroMax').val()) {
                activeFilters.push({ label: 'Horómetro Max', value: $('#filterHorometroMax').val(), type: 'horometroMax' });
            }

            if ($('#fechaCompraDesde').val()) {
                activeFilters.push({ label: 'Compra Desde', value: $('#fechaCompraDesde').val(), type: 'fechaCompraDesde' });
            }

            if ($('#fechaCompraHasta').val()) {
                activeFilters.push({ label: 'Compra Hasta', value: $('#fechaCompraHasta').val(), type: 'fechaCompraHasta' });
            }

            // Actualizar contador
            filterCount.text(activeFilters.length);

            // Mostrar/ocultar resumen
            if (activeFilters.length > 0) {
                filterSummary.show();
                const filterTags = activeFilters.map(filter => `
                    <span class="inline-flex items-center px-2 py-1 text-xs bg-orange-500/20 text-orange-400 rounded-full">
                        <span class="mr-1">${filter.label}:</span>
                        <span>${filter.value}</span>
                        <button onclick="removeFilter('${filter.type}')" class="ml-1 hover:text-red-400">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </span>
                `).join('');
                filterList.html(filterTags);
            } else {
                filterSummary.hide();
            }
        }

        // Función para remover filtro específico
        window.removeFilter = function(type) {
            switch(type) {
                case 'search':
                    $('#searchInput').val('');
                    break;
                case 'estado':
                    $('#filterEstado').val('');
                    break;
                case 'tipo':
                    $('#filterTipo').val('');
                    break;
                case 'horometroMin':
                    $('#filterHorometroMin').val('');
                    break;
                case 'horometroMax':
                    $('#filterHorometroMax').val('');
                    break;
                case 'fechaCompraDesde':
                    $('#fechaCompraDesde').val('');
                    break;
                case 'fechaCompraHasta':
                    $('#fechaCompraHasta').val('');
                    break;
            }
            table.draw();
        };

        // Toggle filtros
        $('#toggleFilters').on('click', function() {
            const panel = $('#filtersPanel');
            const icon = $('#filterIcon');
            panel.slideToggle(300, function() {
                icon.toggleClass('fa-chevron-down fa-chevron-up');
            });
        });

        // Filtros rápidos
        $('.quick-filter-btn').on('click', function() {
            $('.quick-filter-btn').removeClass('active');
            $(this).addClass('active');

            const filterType = $(this).attr('id');
            let estadoValue = '';

            switch(filterType) {
                case 'filterAll':
                    estadoValue = '';
                    break;
                case 'filterActivo':
                    estadoValue = 'activo';
                    break;
                case 'filterInactivo':
                    estadoValue = 'inactivo';
                    break;
                case 'filterMantencion':
                    estadoValue = 'mantencion';
                    break;
                case 'filterRecent':
                    // Para "recientes" podríamos filtrar por fecha de creación
                    estadoValue = '';
                    break;
            }

            $('#filterEstado').val(estadoValue);
            table.draw();
        });

        // Eventos de cambio en filtros
        $('#searchInput, #filterEstado, #filterTipo, #filterHorometroMin, #filterHorometroMax, #fechaCompraDesde, #fechaCompraHasta').on('keyup change', function() {
            table.draw();
        });

        // Limpiar todos los filtros
        $('#clearAllFilters').on('click', function() {
            $('#searchInput').val('');
            $('#filterEstado').val('');
            $('#filterTipo').val('');
            $('#filterHorometroMin').val('');
            $('#filterHorometroMax').val('');
            $('#fechaCompraDesde').val('');
            $('#fechaCompraHasta').val('');
            $('.quick-filter-btn').removeClass('active');
            $('#filterAll').addClass('active');
            table.draw();
        });

        // Limpiar filtros (botón general)
        $('#resetFilters').on('click', function() {
            $('#searchInput').val('');
            $('#filterEstado').val('');
            $('#filterTipo').val('');
            $('#filterHorometroMin').val('');
            $('#filterHorometroMax').val('');
            $('#fechaCompraDesde').val('');
            $('#fechaCompraHasta').val('');
            $('.quick-filter-btn').removeClass('active');
            $('#filterAll').addClass('active');
            table.draw();
        });

        // Actualizar filtros activos después de cada draw
        table.on('draw', function() {
            updateActiveFilters();
        });
    });
});
</script>
@endpush