// Enhanced Filters for Pautas Management
class PautasFilters {
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
        document.getElementById('filterTipo')?.addEventListener('change', (e) => this.handleAdvancedFilter('tipo', e.target.value));
        document.getElementById('filterEstado')?.addEventListener('change', (e) => this.handleAdvancedFilter('estado', e.target.value));
        document.getElementById('filterHorasMin')?.addEventListener('input', (e) => this.handleAdvancedFilter('horasMin', e.target.value));
        document.getElementById('filterHorasMax')?.addEventListener('input', (e) => this.handleAdvancedFilter('horasMax', e.target.value));
        document.getElementById('filterDiasMin')?.addEventListener('input', (e) => this.handleAdvancedFilter('diasMin', e.target.value));
        document.getElementById('filterDiasMax')?.addEventListener('input', (e) => this.handleAdvancedFilter('diasMax', e.target.value));
        document.getElementById('fechaDesde')?.addEventListener('change', (e) => this.handleAdvancedFilter('fechaDesde', e.target.value));
        document.getElementById('fechaHasta')?.addEventListener('change', (e) => this.handleAdvancedFilter('fechaHasta', e.target.value));

        // Toggle days filters
        document.getElementById('toggleDiasFilters')?.addEventListener('click', () => this.toggleDaysFilters());

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
            case 'camiones':
                filterValue = 'camion';
                break;
            case 'maquinas':
                filterValue = 'maquinaria';
                break;
            case 'ambos':
                filterValue = 'ambos';
                break;
            case 'recent':
                // For recent, we can set a date filter
                const thirtyDaysAgo = new Date();
                thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
                this.setDateFilter(thirtyDaysAgo.toISOString().split('T')[0], new Date().toISOString().split('T')[0]);
                return;
            case 'all':
            default:
                filterValue = '';
                break;
        }

        this.activeFilters.set('tipo', filterValue);
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

    toggleDaysFilters() {
        const daysFilters = document.getElementById('diasFilters');
        const toggleBtn = document.getElementById('toggleDiasFilters');
        const icon = toggleBtn.querySelector('i');

        if (daysFilters.style.display === 'none' || !daysFilters.style.display) {
            daysFilters.style.display = 'grid';
            icon.className = 'fas fa-minus mr-2';
            toggleBtn.innerHTML = '<i class="fas fa-minus mr-2"></i>Ocultar filtros de días';
        } else {
            daysFilters.style.display = 'none';
            icon.className = 'fas fa-plus mr-2';
            toggleBtn.innerHTML = '<i class="fas fa-plus mr-2"></i>Mostrar filtros de días';
        }
    }

    setDateFilter(fechaDesde, fechaHasta) {
        if (fechaDesde) {
            document.getElementById('fechaDesde').value = fechaDesde;
            this.activeFilters.set('fechaDesde', fechaDesde);
        }
        if (fechaHasta) {
            document.getElementById('fechaHasta').value = fechaHasta;
            this.activeFilters.set('fechaHasta', fechaHasta);
        }
        this.updateFiltersDisplay();
    }

    clearAdvancedFilters() {
        // Clear all advanced filter inputs
        const advancedInputs = [
            'filterTipo', 'filterEstado', 'filterHorasMin', 'filterHorasMax',
            'filterDiasMin', 'filterDiasMax', 'fechaDesde', 'fechaHasta'
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
                            <button type="button" onclick="pautasFilters.removeFilter('${key}')" class="ml-1 hover:text-orange-300">
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
            tipo: { camion: '🚛 Camión', maquinaria: '⚙️ Máquina', ambos: '🔄 Ambos' },
            estado: { activa: '✅ Activa', inactiva: '❌ Inactiva' },
            horasMin: `Horas mín: ${value}`,
            horasMax: `Horas máx: ${value}`,
            diasMin: `Días mín: ${value}`,
            diasMax: `Días máx: ${value}`,
            fechaDesde: `Desde: ${value}`,
            fechaHasta: `Hasta: ${value}`,
            search: `Búsqueda: "${value}"`
        };

        return labels[key]?.[value] || `${key}: ${value}`;
    }

    removeFilter(key) {
        this.activeFilters.delete(key);

        // Clear the corresponding input
        const inputMap = {
            tipo: 'filterTipo',
            estado: 'filterEstado',
            horasMin: 'filterHorasMin',
            horasMax: 'filterHorasMax',
            diasMin: 'filterDiasMin',
            diasMax: 'filterDiasMax',
            fechaDesde: 'fechaDesde',
            fechaHasta: 'fechaHasta',
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
        if (window.pautasDT) {
            window.pautasDT.ajax.reload();
        }

        // Also update cards view if active
        if (window.pautasCtx && window.pautasCtx.viewMode === 'cards') {
            window.pautasCtx.loadCards();
        }
    }

    getFilterData() {
        const data = {};

        // Add active filters to data
        this.activeFilters.forEach((value, key) => {
            switch(key) {
                case 'tipo':
                    data.tipoFilter = value;
                    break;
                case 'estado':
                    data.estadoFilter = value;
                    break;
                case 'horasMin':
                    data.horasMin = value;
                    break;
                case 'horasMax':
                    data.horasMax = value;
                    break;
                case 'diasMin':
                    data.diasMin = value;
                    break;
                case 'diasMax':
                    data.diasMax = value;
                    break;
                case 'fechaDesde':
                    data.fechaDesde = value;
                    break;
                case 'fechaHasta':
                    data.fechaHasta = value;
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
    window.pautasFilters = new PautasFilters();
});

// Extend DataTable to use custom filters
$(document).ready(function() {
    if ($.fn.DataTable) {
        // Override the default ajax data function to include our filters
        const originalAjax = $.fn.DataTable.defaults.ajax;
        if (typeof originalAjax === 'object' && originalAjax.data) {
            const originalDataFn = originalAjax.data;
            originalAjax.data = function(d) {
                // Call original data function
                if (typeof originalDataFn === 'function') {
                    originalDataFn(d);
                }

                // Add our custom filters
                if (window.pautasFilters) {
                    const filterData = window.pautasFilters.getFilterData();
                    Object.assign(d, filterData);
                }
            };
        }
    }
});
