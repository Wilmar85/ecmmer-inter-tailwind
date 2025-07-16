// dashboard-charts.js
// Inicialización de gráficos Chart.js para el dashboard

document.addEventListener('DOMContentLoaded', function () {
    // --- Placeholder: datos históricos para tendencias (simulados, reemplazar por AJAX) ---
    const trendDates = ['Día 1', 'Día 2', 'Día 3', 'Día 4', 'Día 5', 'Día 6', 'Hoy'];
    // Asegúrate de que estos elementos existan antes de intentar acceder a .dataset
    const pageLoadElement = document.querySelector('[data-chart-pageload]');
    const bounceRateElement = document.querySelector('[data-chart-bouncerate]');

    const trendPageLoad = [2.1, 2.0, 1.9, 2.2, 2.0, 1.8, pageLoadElement ? parseFloat(pageLoadElement.dataset.chartPageload) : 0];
    const trendBounceRate = [45, 42, 44, 48, 47, 43, bounceRateElement ? parseFloat(bounceRateElement.dataset.chartBouncerate) : 0];
    // --- END Placeholder ---

    // Configuración global de Chart.js para soporte de modo oscuro
    function applyChartTheme() {
        const chartTextColor = getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b';
        Chart.defaults.set('color', chartTextColor);
        Chart.defaults.set('plugins.legend.labels.color', chartTextColor);
        Chart.defaults.set('plugins.tooltip.titleColor', chartTextColor);
        Chart.defaults.set('plugins.tooltip.bodyColor', chartTextColor);
    }
    applyChartTheme(); // Aplicar al cargar
    // Escuchar cambios en el tema (si tienes un observador de mutaciones o un evento de tema)
    // Esto se maneja en el script inline en dashboard.blade.php con el toggleDarkMode

    // Chart de Velocidad de Carga (placeholder: solo valor actual)
    let chartPageLoadInstance = null;
    if (document.getElementById('chartPageLoad')) {
        chartPageLoadInstance = new Chart(document.getElementById('chartPageLoad').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Actual'],
                datasets: [{
                    label: 'Segundos',
                    data: [pageLoadElement ? parseFloat(pageLoadElement.dataset.chartPageload) : 0],
                    backgroundColor: '#2563eb',
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                    x: { ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } }
                }
            }
        });
    }

    // Chart de Tasa de Rebote (placeholder: solo valor actual)
    let chartBounceRateInstance = null;
    if (document.getElementById('chartBounceRate')) {
        chartBounceRateInstance = new Chart(document.getElementById('chartBounceRate').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Actual'],
                datasets: [{
                    label: '%',
                    data: [bounceRateElement ? parseFloat(bounceRateElement.dataset.chartBouncerate) : 0],
                    backgroundColor: '#dc2626',
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                    x: { ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } }
                }
            }
        });
    }

    // Gráfico de barras apiladas: Ventas por Región y Producto (dinámico)
    let salesStackedChart = null;
    function renderSalesStackedChart(data) {
        const ctx = document.getElementById('chartSalesStacked').getContext('2d');
        if (salesStackedChart) salesStackedChart.destroy();
        // Colores para datasets (max 10)
        const colors = ['#2563eb','#f59e42','#10b981','#dc2626','#a21caf','#eab308','#0ea5e9','#64748b','#f43f5e','#14b8a6'];
        data.datasets.forEach((ds,i)=>ds.backgroundColor=colors[i%colors.length]);
        salesStackedChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top', labels: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                    tooltip: { mode: 'index', intersect: false }
                },
                interaction: { mode: 'nearest', axis: 'x', intersect: false },
                scales: {
                    x: { stacked: true, ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                    y: { stacked: true, beginAtZero: true, ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } }
                },
                animation: { duration: 1200, easing: 'easeOutQuart' }
            }
        });
    }

    // Gráfico de barras: Ventas por Producto (top 10)
    let salesByProductChart = null;
    function renderSalesByProductChart(data) {
        const ctx = document.getElementById('chartSalesByProduct').getContext('2d');
        if (salesByProductChart) salesByProductChart.destroy();
        const colors = ['#2563eb','#f59e42','#10b981','#dc2626','#a21caf','#eab308','#0ea5e9','#64748b','#f43f5e','#14b8a6'];
        salesByProductChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Ventas',
                    data: data.data,
                    backgroundColor: colors.slice(0, data.labels.length),
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => ` Ventas: ${ctx.parsed.y}` } }
                },
                scales: {
                    x: { ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                    y: { beginAtZero: true, ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } }
                },
                animation: { duration: 1200, easing: 'easeOutQuart' }
            }
        });
    }

    function fetchAndRenderSalesByProduct(filters = {}) {
        const params = new URLSearchParams(filters).toString();
        fetch('/admin/dashboard/data' + (params ? '?' + params : ''))
            .then(r => r.json())
            .then(data => {
                if (data.sales_by_product && document.getElementById('chartSalesByProduct')) {
                    renderSalesByProductChart(data.sales_by_product);
                }
            });
    }
    if (document.getElementById('chartSalesByProduct')) {
        fetchAndRenderSalesByProduct();
    }

    // Inicialización y actualización con AJAX
    function fetchAndRenderSalesStacked(filters = {}) {
        const params = new URLSearchParams(filters).toString();
        fetch('/admin/dashboard/data' + (params ? '?' + params : ''))
            .then(r => r.json())
            .then(data => {
                if (data.sales_stacked_data && document.getElementById('chartSalesStacked')) {
                    renderSalesStackedChart(data.sales_stacked_data);
                }
            });
    }
    if (document.getElementById('chartSalesStacked')) {
        fetchAndRenderSalesStacked();
    }

    // Gráfico de tendencia de velocidad de carga (línea)
    let trendPageLoadInstance = null;
    if (document.getElementById('trendPageLoad')) {
        trendPageLoadInstance = new Chart(document.getElementById('trendPageLoad').getContext('2d'), {
            type: 'line',
            data: {
                labels: trendDates,
                datasets: [{
                    label: 'Velocidad de carga (s)',
                    data: trendPageLoad,
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37,99,235,0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                    x: { ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } }
                }
            }
        });
    }

    // Gráfico de tendencia de tasa de rebote (línea)
    let trendBounceRateInstance = null;
    if (document.getElementById('trendBounceRate')) {
        trendBounceRateInstance = new Chart(document.getElementById('trendBounceRate').getContext('2d'), {
            type: 'line',
            data: {
                labels: trendDates,
                datasets: [{
                    label: 'Tasa de rebote (%)',
                    data: trendBounceRate,
                    borderColor: '#dc2626',
                    backgroundColor: 'rgba(220,38,38,0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                    x: { ticks: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } }
                },
                animation: { duration: 1200, easing: 'easeOutQuart' },
                interaction: { intersect: false },
                hover: { intersect: false },
                tooltips: { enabled: false }, // Considerar habilitar tooltips si se desea interactividad
                hoverOffset: 4
            }
        });
    }

    // Pie chart de dispositivos
    let devicesPieChart = null; // Variable para la instancia del gráfico
    if (document.getElementById('pieDevices')) { // CORREGIDO: Usar 'pieDevices'
        // Obtener los datos de dispositivos desde el DOM (window.devicesData ya está en dashboard.blade.php)
        const deviceLabels = [];
        const deviceCounts = [];

        if (window.devicesData) {
            Object.entries(window.devicesData).forEach(([label, count]) => {
                deviceLabels.push(label.charAt(0).toUpperCase() + label.slice(1));
                deviceCounts.push(parseInt(count));
            });
        }
        if (deviceLabels.length > 0) {
            devicesPieChart = new Chart(document.getElementById('pieDevices').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: deviceLabels,
                    datasets: [{
                        data: deviceCounts,
                        backgroundColor: ['#2563eb','#16a34a','#f59e42','#dc2626'], // Colores sólidos para los segmentos
                        borderColor: getComputedStyle(document.documentElement).getPropertyValue('--chart-bg') || '#ffffff', // Borde para separación, considerar un color que contraste
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom', labels: { color: getComputedStyle(document.documentElement).getPropertyValue('--chart-text') || '#1e293b' } },
                        tooltip: { callbacks: { label: (context) => `${context.label}: ${context.raw}` } }
                    }
                }
            });
        }
    }

    // --- AJAX para actualización en tiempo real ---
    // Exponer las instancias de los gráficos para poder actualizarlas
    window.dashboardCharts = {
        pageLoadBar: chartPageLoadInstance,
        bounceBar: chartBounceRateInstance,
        pageLoadTrend: trendPageLoadInstance,
        bounceTrend: trendBounceRateInstance,
        devicesPie: devicesPieChart,
        salesByProduct: salesByProductChart,
        salesStacked: salesStackedChart
    };

    // Hacer esta función global para que el script inline en dashboard.blade.php pueda llamarla
    window.updateDashboardData = function(filters = {}) {
        const params = new URLSearchParams(filters).toString();
        fetch('/admin/dashboard/data?' + params)
            .then(res => res.json())
            .then(data => {
                // Actualizar métricas de texto
                if (data.totalRevenue !== undefined) {
                    document.getElementById('totalRevenueDisplay').innerText = `$${data.totalRevenue.toFixed(2)}`;
                }
                if (data.averageOrderValue !== undefined) {
                    document.getElementById('averageOrderValueDisplay').innerText = `$${data.averageOrderValue.toFixed(2)}`;
                }
                if (data.conversionRate !== undefined) {
                    document.getElementById('conversionRateDisplay').innerText = `${data.conversionRate}%`;
                }
                if (data.cartAbandonmentRate !== undefined) {
                    document.getElementById('cartAbandonmentRateDisplay').innerText = `${data.cartAbandonmentRate}%`;
                }
                 // Actualizar listas (ej. Ventas por Producto, Ventas por Región)
                if (data.sales_by_product_list) {
                    const salesByProductList = document.getElementById('salesByProductList');
                    if (salesByProductList) {
                        salesByProductList.innerHTML = ''; // Limpiar lista actual
                        if (data.sales_by_product_list.length > 0) {
                            data.sales_by_product_list.forEach(item => {
                                const li = document.createElement('li');
                                li.className = 'flex justify-between border-b py-1';
                                li.innerHTML = `<span>${item.product_name || 'Producto #' + item.product_id}</span><span class="font-semibold bg-blue-50 text-blue-700 px-2 rounded">${item.total}</span>`;
                                salesByProductList.appendChild(li);
                            });
                        } else {
                            salesByProductList.innerHTML = '<li>No hay datos.</li>';
                        }
                }}
                if (data.sales_by_region_list) {
                    const salesByRegionList = document.getElementById('salesByRegionList');
                    if (salesByRegionList) {
                        salesByRegionList.innerHTML = ''; // Limpiar lista actual
                        if (data.sales_by_region_list.length > 0) {
                            data.sales_by_region_list.forEach(region => {
                                const li = document.createElement('li');
                                li.className = 'flex justify-between border-b py-1';
                                li.innerHTML = `<span>${region.region || 'Sin región'}</span><span class="font-semibold bg-purple-50 text-purple-700 px-2 rounded">${region.total}</span>`;
                                salesByRegionList.appendChild(li);
                            });
                        } else {
                            salesByRegionList.innerHTML = '<li>No hay datos.</li>';
                        }
                    }
                }
                // Actualizar gráficos principales
                if (window.dashboardCharts.pageLoadBar && data.averagePageLoadTime !== undefined) {
                    window.dashboardCharts.pageLoadBar.data.datasets[0].data = [data.averagePageLoadTime];
                    window.dashboardCharts.pageLoadBar.update();
                }
                if (window.dashboardCharts.bounceBar && data.bounceRate !== undefined) {
                    window.dashboardCharts.bounceBar.data.datasets[0].data = [data.bounceRate];
                    window.dashboardCharts.bounceBar.update();
                }
                // Tendencias
                if (window.dashboardCharts.pageLoadTrend && data.trendPageLoad) {
                    window.dashboardCharts.pageLoadTrend.data.labels = Array.from({length: data.trendPageLoad.length}, (_,i)=>'Día '+(i+1));
                    window.dashboardCharts.pageLoadTrend.data.datasets[0].data = data.trendPageLoad;
                    window.dashboardCharts.pageLoadTrend.update();
                }
                if (window.dashboardCharts.bounceTrend && data.trendBounceRate) {
                    window.dashboardCharts.bounceTrend.data.labels = Array.from({length: data.trendBounceRate.length}, (_,i)=>'Día '+(i+1));
                    window.dashboardCharts.bounceTrend.data.datasets[0].data = data.trendBounceRate;
                    window.dashboardCharts.bounceTrend.update();
                }
                // Dispositivos
                if (window.dashboardCharts.devicesPie && data.devices) {
                    window.dashboardCharts.devicesPie.data.labels = Object.keys(data.devices).map(l=>l.charAt(0).toUpperCase()+l.slice(1));
                    window.dashboardCharts.devicesPie.data.datasets[0].data = Object.values(data.devices);
                    window.dashboardCharts.devicesPie.update();
                }
                // Ventas por producto (gráfico)
                if (window.dashboardCharts.salesByProduct && data.sales_by_product) {
                    renderSalesByProductChart(data.sales_by_product);
                }
                // Ventas apiladas (gráfico)
                if (window.dashboardCharts.salesStacked && data.sales_stacked_data) {
                    renderSalesStackedChart(data.sales_stacked_data);
                }
            })
            .catch(error => console.error('Error fetching dashboard data:', error));
    };

    // Actualización periódica (mantener o ajustar según necesidad)
    // setInterval(()=>{
    //     const filters = {
    //         dateRange: document.getElementById('dateRange').value,
    //         deviceFilter: document.getElementById('deviceFilter').value
    //     };
    //     window.updateDashboardData(filters);
    // }, 60000); // Cada 1 minuto

    // --- Guardar preferencias de usuario (localStorage) ---
    function saveDashboardPreferences(prefs) {
        localStorage.setItem('dashboardPrefs', JSON.stringify(prefs));
    }
    function loadDashboardPreferences() {
        try {
            return JSON.parse(localStorage.getItem('dashboardPrefs')) || {};
        } catch { return {}; }
    }
    window.applyDashboardPreferences = function() { // Exponer para Alpine.js o scripts externos
        const prefs = loadDashboardPreferences();
        document.querySelectorAll('[data-metric-section]').forEach(section => {
            const key = section.getAttribute('data-metric-section');
            if (prefs[key] === false) {
                // Si la preferencia es false, colapsa la sección
                const alpineData = section.__alpine_get_listeners && section.__alpine_get_listeners().length > 0 ? Alpine.raw(section.__alpine_get_listeners()[0].node) : null;
                if (alpineData && alpineData.open !== undefined) {
                    alpineData.open = false; // Intenta usar la propiedad 'open' de Alpine
                } else {
                    section.style.display = 'none'; // Fallback si no hay Alpine o 'open'
                }
            } else {
                const alpineData = section.__alpine_get_listeners && section.__alpine_get_listeners().length > 0 ? Alpine.raw(section.__alpine_get_listeners()[0].node) : null;
                if (alpineData && alpineData.open !== undefined) {
                    alpineData.open = true; // Intenta usar la propiedad 'open' de Alpine
                } else {
                    section.style.display = ''; // Fallback si no hay Alpine o 'open'
                }
            }
        });
    }
    // UI de personalización (si la quieres visible/configurable)
    let prefsPanel = null;
    function openPrefsPanel() {
        if (prefsPanel) { prefsPanel.remove(); prefsPanel = null; return; }
        prefsPanel = document.createElement('div');
        prefsPanel.className = 'absolute z-50 bg-white border rounded shadow p-4 right-4 top-24';
        prefsPanel.innerHTML = `<div class='font-bold mb-2'>Personaliza tu Dashboard</div>
            <label class='block'><input type='checkbox' data-pref-metric='marketing' checked> Métricas de Marketing</label>
            <label class='block'><input type='checkbox' data-pref-metric='performance' checked> Métricas de Rendimiento</label>
            <label class='block'><input type='checkbox' data-pref-metric='inventory' checked> Inventario</label>
            <label class='block'><input type='checkbox' data-pref-metric='clients' checked> Clientes</label>
            <button class='mt-2 px-3 py-1 bg-blue-600 text-white rounded' id='savePrefsBtn'>Guardar</button>`;
        document.body.appendChild(prefsPanel);
        // Cargar estado
        const prefs = loadDashboardPreferences();
        prefsPanel.querySelectorAll('[data-pref-metric]').forEach(cb => {
            const key = cb.getAttribute('data-pref-metric');
            cb.checked = prefs[key] !== false; // Por defecto es true si no está guardado
        });
        // Guardar
        prefsPanel.querySelector('#savePrefsBtn').onclick = function() {
            const newPrefs = {};
            prefsPanel.querySelectorAll('[data-pref-metric]').forEach(cb => {
                newPrefs[cb.getAttribute('data-pref-metric')] = cb.checked;
            });
            saveDashboardPreferences(newPrefs);
            window.applyDashboardPreferences(); // Re-apply all preferences after saving
            prefsPanel.remove();
            prefsPanel = null;
        };
    }
    // Botón principal de personalización (asegúrate de que exista este botón en tu HTML)
    const customizeBtn = document.querySelector('button[title^="Personalizar"]');
    if (customizeBtn) {
        customizeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openPrefsPanel();
        });
    }
    // Botón en el menú de usuario (si tienes uno)
    const customizeNavBtn = document.getElementById('dashboardCustomizeNavBtn');
    if (customizeNavBtn) {
        customizeNavBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openPrefsPanel();
        });
    }

    // Aplicar preferencias al cargar
    window.applyDashboardPreferences();
});