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
    .pauta-card {
        background: linear-gradient(135deg, #27272a 0%, #1f1f23 100%);
        border: 1px solid #3f3f46;
        border-radius: 1rem;
        padding: 1.75rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 2px rgba(0, 0, 0, 0.06);
    }

    .pauta-card::before {
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

    .pauta-card:hover {
        border-color: #f97316;
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .pauta-card:hover::before {
        opacity: 1;
    }

    .pauta-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.25rem;
        position: relative;
    }

    .pauta-card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.375rem;
        letter-spacing: -0.025em;
    }

    .pauta-card-subtitle {
        font-size: 0.875rem;
        color: #a1a1aa;
        font-weight: 500;
        line-height: 1.4;
    }

    .pauta-card-tipo {
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

    .pauta-card-tipo.camion {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.25));
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.3);
    }

    .pauta-card-tipo.maquinaria {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.25));
        color: #10b981;
        border-color: rgba(16, 185, 129, 0.3);
    }

    .pauta-card-tipo.ambos {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(245, 158, 11, 0.25));
        color: #f59e0b;
        border-color: rgba(245, 158, 11, 0.3);
    }

    .pauta-card-info {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    .pauta-card-info-item {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .pauta-card-info-label {
        font-size: 0.6875rem;
        color: #a1a1aa;
        text-transform: uppercase;
        font-weight: 600;
        letter-spacing: 0.05em;
        margin-bottom: 0.375rem;
    }

    .pauta-card-info-value {
        font-size: 0.9375rem;
        color: white;
        font-weight: 600;
        line-height: 1.4;
    }

    .pauta-card-frecuencia {
        font-size: 1.125rem;
        font-weight: 700;
        color: #f97316;
        text-shadow: 0 0 10px rgba(249, 115, 22, 0.3);
        letter-spacing: -0.025em;
    }

    .pauta-card-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1.25rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        margin-top: 1.25rem;
    }

    .pauta-card-actions-left {
        display: flex;
        gap: 0.5rem;
    }

    .pauta-card-actions-right {
        display: flex;
        gap: 0.5rem;
    }

    .pauta-card-action-btn {
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

    .pauta-card-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transition: left 0.5s;
    }

    .pauta-card-action-btn:hover::before {
        left: 100%;
    }

    .pauta-card-action-btn.edit {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(59, 130, 246, 0.25));
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.3);
    }

    .pauta-card-action-btn.edit:hover {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.25), rgba(59, 130, 246, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .pauta-card-action-btn.manage {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.15), rgba(139, 92, 246, 0.25));
        color: #8b5cf6;
        border-color: rgba(139, 92, 246, 0.3);
    }

    .pauta-card-action-btn.manage:hover {
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.25), rgba(139, 92, 246, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(139, 92, 246, 0.3);
    }

    .pauta-card-action-btn.view {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.15), rgba(34, 197, 94, 0.25));
        color: #22c55e;
        border-color: rgba(34, 197, 94, 0.3);
    }

    .pauta-card-action-btn.view:hover {
        background: linear-gradient(135deg, rgba(34, 197, 94, 0.25), rgba(34, 197, 94, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
    }

    .pauta-card-action-btn.delete {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(239, 68, 68, 0.25));
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.3);
    }

    .pauta-card-action-btn.delete:hover {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.25), rgba(239, 68, 68, 0.35));
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .pauta-card {
            padding: 1.25rem;
            margin-bottom: 1rem;
        }

        .pauta-card-info {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .pauta-card-actions {
            flex-direction: column;
            gap: 0.75rem;
            align-items: stretch;
        }

        .pauta-card-actions-left,
        .pauta-card-actions-right {
            justify-content: center;
        }
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
                    <input type="text" id="searchInput" placeholder="Buscar pautas..."
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
                        <button id="filterCamiones" class="px-3 py-1 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-truck mr-1"></i>Camiones
                        </button>
                        <button id="filterMaquinas" class="px-3 py-1 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-tools mr-1"></i>Máquinas
                        </button>
                        <button id="filterAmbos" class="px-3 py-1 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-exchange-alt mr-1"></i>Ambos
                        </button>
                        <button id="filterRecent" class="px-3 py-1 bg-zinc-700 hover:bg-zinc-600 text-gray-300 rounded-full text-xs transition-colors quick-filter-btn">
                            <i class="fas fa-clock mr-1"></i>Recientes
                        </button>
                    </div>
                </div>

                <!-- Filtros Avanzados -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    <!-- Tipo de Equipo -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-cogs mr-2 text-orange-400"></i>Tipo de Equipo
                        </label>
                        <select id="filterTipo" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Todos los tipos</option>
                            <option value="camion">🚛 Camión</option>
                            <option value="maquinaria">⚙️ Máquina</option>
                            <option value="ambos">🔄 Ambos</option>
                        </select>
                    </div>

                    <!-- Estado -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-toggle-on mr-2 text-orange-400"></i>Estado
                        </label>
                        <select id="filterEstado" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <option value="">Todos los estados</option>
                            <option value="activa">✅ Activa</option>
                            <option value="inactiva">❌ Inactiva</option>
                        </select>
                    </div>

                    <!-- Frecuencia Horas Min -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-clock mr-2 text-orange-400"></i>Horas Min
                        </label>
                        <input type="number" id="filterHorasMin" min="0" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="0">
                    </div>

                    <!-- Frecuencia Horas Max -->
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-clock mr-2 text-orange-400"></i>Horas Max
                        </label>
                        <input type="number" id="filterHorasMax" min="0" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="1000">
                    </div>

                    <!-- Fecha Desde -->
                    <div class="space-y-2">
                        <label for="fechaDesde" class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-calendar-alt mr-2 text-orange-400"></i>Fecha Desde
                        </label>
                        <div class="relative">
                            <input type="date" id="fechaDesde" class="w-full pl-10 pr-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Fecha Hasta -->
                    <div class="space-y-2">
                        <label for="fechaHasta" class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-calendar-alt mr-2 text-orange-400"></i>Fecha Hasta
                        </label>
                        <div class="relative">
                            <input type="date" id="fechaHasta" class="w-full pl-10 pr-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500">
                            <i class="fas fa-calendar-alt absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Filtros de Días (Opcional) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4" id="diasFilters" style="display: none;">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-calendar-day mr-2 text-orange-400"></i>Días Min
                        </label>
                        <input type="number" id="filterDiasMin" min="0" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="0">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-gray-300">
                            <i class="fas fa-calendar-day mr-2 text-orange-400"></i>Días Max
                        </label>
                        <input type="number" id="filterDiasMax" min="0" class="w-full px-3 py-2 bg-zinc-800 border border-zinc-600 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500" placeholder="365">
                    </div>
                </div>

                <!-- Toggle Filtros de Días -->
                <div class="mt-3">
                    <button id="toggleDiasFilters" class="text-sm text-orange-400 hover:text-orange-300 transition-colors flex items-center">
                        <i class="fas fa-plus mr-2"></i>Mostrar filtros de días
                    </button>
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
            <div class="overflow-x-auto rounded-lg">
                <table id="pautasTable" class="min-w-full divide-y divide-zinc-700">
                    <thead class="bg-zinc-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nombre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tipo Equipo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Frecuencia (Horas)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Frecuencia (Días)</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Fecha Creación</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-zinc-800 divide-y divide-zinc-700"></tbody>
                </table>
            </div>
        </div>

        <!-- Vista de Cards -->
        <div class="p-4 mobile-cards-view" x-show="viewMode === 'cards'" x-transition>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="pautasCards">
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
<script src="{{ asset('js/pautas-filters.js') }}"></script>
<script>
window.pautasApp = function () {
    return {
        isOpen: false,
        isDetailOpen: false,
        modalTitle: '',
        currentId: null,
        viewMode: 'table',
        form: {
            nombre: '',
            tipo_equipo: '',
            descripcion: '',
            frecuencia_horas: '',
            frecuencia_dias: ''
        },
        detail: {},

        setViewMode(mode) {
            this.viewMode = mode;
            if (mode === 'cards') {
                this.loadCards();
            }
        },

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
                if (this.viewMode === 'cards') {
                    this.loadCards();
                }
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
        },

        toggleView(mode) {
            this.viewMode = mode;
            if (mode === 'cards') {
                this.loadCards();
            }
        },

        async loadCards() {
            try {
                // Build query parameters for GET request
                const params = new URLSearchParams();

                // Use the new filter system if available
                if (window.pautasFilters) {
                    const filterData = window.pautasFilters.getFilterData();
                    Object.keys(filterData).forEach(key => {
                        if (filterData[key] !== null && filterData[key] !== undefined && filterData[key] !== '') {
                            params.append(key, filterData[key]);
                        }
                    });
                } else {
                    // Fallback to old system
                    const searchVal = $('#searchInput').val() || '';
                    const tipoVal = $('#filterTipo').val() || '';
                    const fechaDesdeVal = $('#fechaDesde').val() || '';
                    const fechaHastaVal = $('#fechaHasta').val() || '';

                    if (searchVal) params.append('custom_search', searchVal);
                    if (tipoVal) params.append('tipoFilter', tipoVal);
                    if (fechaDesdeVal) params.append('fechaDesde', fechaDesdeVal);
                    if (fechaHastaVal) params.append('fechaHasta', fechaHastaVal);
                }

                const response = await fetch(`{{ route('admin.pautas.datatable') }}?${params}`, {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                if (!response.ok) throw new Error('Error loading data');

                const data = await response.json();
                this.renderCards(data.data || []);
            } catch (error) {
                console.error('Error loading cards:', error);
                $('#pautasCards').html('<div class="col-span-full text-center text-gray-400 py-8">Error al cargar las pautas</div>');
            }
        },

        renderCards(pautas) {
            const container = document.getElementById('pautasCards');
            if (!container) return;

            if (pautas.length === 0) {
                container.innerHTML = '<div class="col-span-full text-center text-gray-400 py-8">No se encontraron pautas</div>';
                return;
            }

            container.innerHTML = pautas.map(pauta => this.createCardHtml(pauta)).join('');
        },

        createCardHtml(pauta) {
            const tipoClass = {
                'camion': 'camion',
                'maquinaria': 'maquinaria',
                'ambos': 'ambos'
            }[pauta.tipo_equipo] || 'camion';

            const tipoText = {
                'camion': 'Camión',
                'maquinaria': 'Máquina',
                'ambos': 'Ambos'
            }[pauta.tipo_equipo] || 'Camión';

            const frecuenciaText = [];
            if (pauta.frecuencia_horas) frecuenciaText.push(`${pauta.frecuencia_horas} hrs`);
            if (pauta.frecuencia_dias) frecuenciaText.push(`${pauta.frecuencia_dias} días`);
            const frecuenciaDisplay = frecuenciaText.join(' / ') || 'Sin frecuencia';

            // Formatear fecha de creación
            const fechaCreacion = pauta.created_at ? new Date(pauta.created_at).toLocaleDateString('es-ES') : 'Sin fecha';

            return `
                <div class="pauta-card">
                    <div class="pauta-card-header">
                        <div>
                            <h3 class="pauta-card-title">${pauta.nombre}</h3>
                            <p class="pauta-card-subtitle">${pauta.descripcion || 'Sin descripción'}</p>
                        </div>
                        <span class="pauta-card-tipo ${tipoClass}">${tipoText}</span>
                    </div>

                    <div class="pauta-card-info">
                        <div class="pauta-card-info-item">
                            <div class="pauta-card-info-label">FRECUENCIA</div>
                            <div class="pauta-card-info-value pauta-card-frecuencia">${frecuenciaDisplay}</div>
                        </div>
                        <div class="pauta-card-info-item">
                            <div class="pauta-card-info-label">TIPO EQUIPO</div>
                            <div class="pauta-card-info-value">${tipoText}</div>
                        </div>
                        <div class="pauta-card-info-item">
                            <div class="pauta-card-info-label">FECHA CREACIÓN</div>
                            <div class="pauta-card-info-value">${fechaCreacion}</div>
                        </div>
                        <div class="pauta-card-info-item">
                            <div class="pauta-card-info-label">ESTADO</div>
                            <div class="pauta-card-info-value">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Activa
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="pauta-card-actions">
                        <div class="pauta-card-actions-left">
                            <button type="button" onclick="editPauta(${pauta.id})" class="pauta-card-action-btn edit" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" onclick="goGestionar(${pauta.id})" class="pauta-card-action-btn manage" title="Gestionar Áreas">
                                <i class="fas fa-layer-group"></i>
                            </button>
                            <button type="button" onclick="viewPauta(${pauta.id})" class="pauta-card-action-btn view" title="Ver Detalles">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="pauta-card-actions-right">
                            <button type="button" onclick="deletePauta(${pauta.id})" class="pauta-card-action-btn delete" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
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
                // Use the new filter system if available
                if (window.pautasFilters) {
                    const filterData = window.pautasFilters.getFilterData();
                    Object.assign(d, filterData);
                } else {
                    // Fallback to old system
                    d.custom_search = $('#searchInput').val();
                    d.tipoFilter = $('#filterTipo').val();
                    d.fechaDesde = $('#fechaDesde').val();
                    d.fechaHasta = $('#fechaHasta').val();
                }
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
                data: 'created_at',
                name: 'created_at',
                render: function(v) {
                    if (!v) return '<span class="text-gray-400">-</span>';
                    const date = new Date(v);
                    return `<span class="text-purple-400 font-medium">${date.toLocaleDateString('es-ES')}</span>`;
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

    $('#searchInput, #filterTipo, #fechaDesde, #fechaHasta').on('keyup change', () => table.draw());
    $('#resetFilters').on('click', function () {
        $('#searchInput').val('');
        $('#filterTipo').val('');
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        table.draw();
    });

    // Toggle de vista
    $('#viewTable').on('click', function() {
        $('.view-toggle-btn').removeClass('active');
        $(this).addClass('active');
        if (window.pautasCtx && typeof window.pautasCtx.toggleView === 'function') {
            window.pautasCtx.toggleView('table');
        }
    });

    $('#viewCards').on('click', function() {
        $('.view-toggle-btn').removeClass('active');
        $(this).addClass('active');
        if (window.pautasCtx && typeof window.pautasCtx.toggleView === 'function') {
            window.pautasCtx.toggleView('cards');
        }
    });

    // Actualizar cards cuando cambien los filtros
    $('#searchInput, #filterTipo, #fechaDesde, #fechaHasta').on('keyup change', function() {
        if (window.pautasCtx && window.pautasCtx.viewMode === 'cards') {
            window.pautasCtx.loadCards();
        }
    });

    $('#resetFilters').on('click', function() {
        if (window.pautasCtx && window.pautasCtx.viewMode === 'cards') {
            window.pautasCtx.loadCards();
        }
    });
});
</script>
@endpush