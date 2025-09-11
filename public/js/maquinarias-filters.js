// Enhanced Filters for Maquinarias Management
class MaquinariasFilters {
    constructor() {
        this.activeFilters = new Map();
        this.init();
    }

    init() {
        this.bindEvents();
        this.initializeFilterStates();
    }

    bindEvents() {
        // Quick filter buttons
        document.querySelectorAll('.quick-filter-btn').forEach(btn => {
            btn.addEventListener('click', (e) => this.handleQuickFilter(e));
        });

        // Advanced filters
        document.getElementById('filterEstado')?.addEventListener('change', (e) => this.handleAdvancedFilter('estado', e.target.value));
        document.getElementById('filterTipo')?.addEventListener('change', (e) => this.handleAdvancedFilter('tipo', e.target.value));
        document.getElementById('filterMarca')?.addEventListener('change', (e) => this.handleAdvancedFilter('marca', e.target.value));
        document.getElementById('filterHorometroMin')?.addEventListener('input', (e) => this.handleAdvancedFilter('horometroMin', e.target.value));
        document.getElementById('filterHorometroMax')?.addEventListener('input', (e) => this.handleAdvancedFilter('horometroMax', e.target.value));
        document.getElementById('fechaCompraDesde')?.addEventListener('change', (e) => this.handleAdvancedFilter('fechaCompraDesde', e.target.value));
        document.getElementById('fechaCompraHasta')?.addEventListener('change', (e) => this.handleAdvancedFilter('fechaCompraHasta', e.target.value));

        // Toggle main filters panel
        document.getElementById('toggleFilters')?.addEventListener('click', () => this.toggleFilters());

        // Apply and reset buttons
        document.getElementById('applyFilters')?.addEventListener('click', () => this.applyFilters());
        document.getElementById('resetFilters')?.addEventListener('click', () => this.resetFilters());
        document.getElementById('clearAllFilters')?.addEventListener('click', () => this.clearAllFilters());

        // Search input
        document.getElementById('searchInput')?.addEventListener('input', (e) => this.handleSearch(e.target.value));
    }

    initializeFilterStates() {
        // Set default active state for "Todas" button
        document.getElementById('filterAll')?.classList.add('active');
    }

    handleQuickFilter(event) {
        const button = event.target.closest('.quick-filter-btn');
        if (!button) return;

        // Remove active class from all quick filter buttons
        document.querySelectorAll('.quick-filter-btn').forEach(btn => btn.classList.remove('active'));

        // Add active class to clicked button
        button.classList.add('active');

        const filterType = button.id.replace('filter', '').toLowerCase();

        // Clear advanced filters when using quick filters
        this.clearAdvancedFilters();

        // Apply quick filter
        this.applyQuickFilter(filterType);
    }

    applyQuickFilter(type) {
        let filterValue = '';

        switch(type) {
            case 'activas':
                filterValue = 'activo';
                break;
            case 'mantencion':
                filterValue = 'mantencion';
                break;
            case 'camiones':
                filterValue = 'camion';
                break;
            case 'maquinas':
                filterValue = 'excavadora';
                break;
            case 'recent':
                // For recent, we can set a date filter for last 90 days
                const ninetyDaysAgo = new Date();
                ninetyDaysAgo.setDate(ninetyDaysAgo.getDate() - 90);
                this.setDateFilter(ninetyDaysAgo.toISOString().split('T')[0], new Date().toISOString().split('T')[0]);
                return;
            case 'all':
            default:
                filterValue = '';
                break;
        }

        if (type === 'activas' || type === 'mantencion') {
            this.activeFilters.set('estado', filterValue);
        } else if (type === 'camiones' || type === 'maquinas') {
            this.activeFilters.set('tipo', filterValue);
        }

        this.updateFiltersDisplay();
        this.applyFiltersToDataTable();
    }

    handleAdvancedFilter(filterName, value) {
        if (value && value.trim() !== '') {
            this.activeFilters.set(filterName, value);
        } else {
            this.activeFilters.delete(filterName);
        }

        // Remove active state from quick filters when using advanced filters
        document.querySelectorAll('.quick-filter-btn').forEach(btn => btn.classList.remove('active'));

        this.updateFiltersDisplay();
    }

    handleSearch(value) {
        if (value && value.trim() !== '') {
            this.activeFilters.set('search', value);
        } else {
            this.activeFilters.delete('search');
        }
        this.updateFiltersDisplay();
        this.applyFiltersToDataTable();
    }

    toggleFilters() {
        const filtersPanel = document.getElementById('filtersPanel');
        const filterIcon = document.getElementById('filterIcon');

        if (filtersPanel.style.display === 'none' || !filtersPanel.style.display) {
            filtersPanel.style.display = 'block';
            if (filterIcon) {
                filterIcon.className = 'fas fa-chevron-up ml-2 transition-transform duration-200';
            }
        } else {
            filtersPanel.style.display = 'none';
            if (filterIcon) {
                filterIcon.className = 'fas fa-chevron-down ml-2 transition-transform duration-200';
            }
        }
    }

    setDateFilter(fechaDesde, fechaHasta) {
        if (fechaDesde) {
            document.getElementById('fechaCompraDesde').value = fechaDesde;
            this.activeFilters.set('fechaCompraDesde', fechaDesde);
        }
        if (fechaHasta) {
            document.getElementById('fechaCompraHasta').value = fechaHasta;
            this.activeFilters.set('fechaCompraHasta', fechaHasta);
        }
        this.updateFiltersDisplay();
    }

    clearAdvancedFilters() {
        // Clear all advanced filter inputs
        const advancedInputs = [
            'filterEstado', 'filterTipo', 'filterMarca', 'filterHorometroMin', 'filterHorometroMax',
            'fechaCompraDesde', 'fechaCompraHasta'
        ];

        advancedInputs.forEach(id => {
            const element = document.getElementById(id);
            if (element) {
                element.value = '';
            }
        });

        // Clear active filters map (except search)
        const searchValue = this.activeFilters.get('search');
        this.activeFilters.clear();
        if (searchValue) {
            this.activeFilters.set('search', searchValue);
        }
    }

    updateFiltersDisplay() {
        const summaryDiv = document.getElementById('activeFiltersSummary');
        const countSpan = document.getElementById('activeFiltersCount');
        const listDiv = document.getElementById('activeFiltersList');

        if (this.activeFilters.size > 0) {
            summaryDiv.style.display = 'block';
            countSpan.textContent = this.activeFilters.size;

            // Generate filter tags
            const filterTags = [];
            this.activeFilters.forEach((value, key) => {
                if (value && value.trim() !== '') {
                    const label = this.getFilterLabel(key, value);
                    filterTags.push(`
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-orange-500/20 text-orange-400">
                            ${label}
                            <button type="button" onclick="maquinariasFilters.removeFilter('${key}')" class="ml-1 hover:text-orange-300">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        </span>
                    `);
                }
            });

            listDiv.innerHTML = filterTags.join('');
        } else {
            summaryDiv.style.display = 'none';
        }
    }

    getFilterLabel(key, value) {
        const labels = {
            estado: {
                activo: '✅ Activo',
                inactivo: '❌ Inactivo',
                mantencion: '🔧 Mantención'
            },
            tipo: {
                camion: '🚛 Camión',
                excavadora: '🏗️ Excavadora',
                cargador: '🚜 Cargador',
                compactador: '🗜️ Compactador',
                generador: '⚡ Generador',
                otro: '🔧 Otro'
            },
            marca: `Marca: ${value}`,
            horometroMin: `Horómetro mín: ${value}`,
            horometroMax: `Horómetro máx: ${value}`,
            fechaCompraDesde: `Compra desde: ${value}`,
            fechaCompraHasta: `Compra hasta: ${value}`,
            search: `Búsqueda: "${value}"`
        };

        return labels[key]?.[value] || `${key}: ${value}`;
    }

    removeFilter(key) {
        this.activeFilters.delete(key);

        // Clear the corresponding input
        const inputMap = {
            estado: 'filterEstado',
            tipo: 'filterTipo',
            marca: 'filterMarca',
            horometroMin: 'filterHorometroMin',
            horometroMax: 'filterHorometroMax',
            fechaCompraDesde: 'fechaCompraDesde',
            fechaCompraHasta: 'fechaCompraHasta',
            search: 'searchInput'
        };

        const inputId = inputMap[key];
        if (inputId) {
            const element = document.getElementById(inputId);
            if (element) {
                element.value = '';
            }
        }

        this.updateFiltersDisplay();
        this.applyFiltersToDataTable();
    }

    clearAllFilters() {
        this.activeFilters.clear();
        this.clearAdvancedFilters();
        document.getElementById('searchInput').value = '';

        // Reset quick filter to "Todas"
        document.querySelectorAll('.quick-filter-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById('filterAll').classList.add('active');

        this.updateFiltersDisplay();
        this.applyFiltersToDataTable();
    }

    resetFilters() {
        this.clearAllFilters();
    }

    applyFilters() {
        this.applyFiltersToDataTable();
    }

    applyFiltersToDataTable() {
        if (window.maquinariasDT) {
            window.maquinariasDT.ajax.reload();
        }

        // Also update cards view if active
        if (window.maquinariasCtx && window.maquinariasCtx.viewMode === 'cards') {
            window.maquinariasCtx.loadCards();
        }
    }

    getFilterData() {
        const data = {};

        // Add active filters to data
        this.activeFilters.forEach((value, key) => {
            switch(key) {
                case 'estado':
                    data.estadoFilter = value;
                    break;
                case 'tipo':
                    data.tipoFilter = value;
                    break;
                case 'marca':
                    data.marcaFilter = value;
                    break;
                case 'horometroMin':
                    data.horometroMin = value;
                    break;
                case 'horometroMax':
                    data.horometroMax = value;
                    break;
                case 'fechaCompraDesde':
                    data.fechaCompraDesde = value;
                    break;
                case 'fechaCompraHasta':
                    data.fechaCompraHasta = value;
                    break;
                case 'search':
                    data.custom_search = value;
                    break;
            }
        });

        return data;
    }
}

// Initialize filters when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.maquinariasFilters = new MaquinariasFilters();
});

// Extend DataTable to use custom filters
$(document).ready(function() {
    if ($.fn.DataTable) {
        // Override the default ajax data function to include our filters
        const originalAjax = $.fn.dataTable.defaults.ajax;
        if (originalAjax && typeof originalAjax === 'object' && originalAjax.data) {
            const originalDataFn = originalAjax.data;
            originalAjax.data = function(d) {
                // Call original data function
                if (typeof originalDataFn === 'function') {
                    originalDataFn(d);
                }

                // Add our custom filters
                if (window.maquinariasFilters) {
                    const filterData = window.maquinariasFilters.getFilterData();
                    Object.assign(d, filterData);
                }
            };
        }
    }
});
