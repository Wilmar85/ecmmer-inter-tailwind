// dashboard-charts.js
// Inicialización de gráficos Chart.js para el dashboard

document.addEventListener('DOMContentLoaded', function () {
    // --- Placeholder: datos históricos para tendencias (simulados, reemplazar por AJAX) ---
    const trendDates = ['Día 1', 'Día 2', 'Día 3', 'Día 4', 'Día 5', 'Día 6', 'Hoy'];
    const trendPageLoad = [2.1, 2.0, 1.9, 2.2, 2.0, 1.8, parseFloat(document.querySelector('[data-chart-pageload]').dataset.chartPageload)];
    const trendBounceRate = [45, 42, 44, 48, 47, 43, parseFloat(document.querySelector('[data-chart-bouncerate]').dataset.chartBouncerate)];
    // --- END Placeholder ---
    // Chart de Velocidad de Carga (placeholder: solo valor actual)
    if (document.getElementById('chartPageLoad')) {
        new Chart(document.getElementById('chartPageLoad').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Actual'],
                datasets: [{
                    label: 'Segundos',
                    data: [parseFloat(document.querySelector('[data-chart-pageload]').dataset.chartPageload)],
                    backgroundColor: '#2563eb',
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Chart de Tasa de Rebote (placeholder: solo valor actual)
    if (document.getElementById('chartBounceRate')) {
        new Chart(document.getElementById('chartBounceRate').getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Actual'],
                datasets: [{
                    label: '%',
                    data: [parseFloat(document.querySelector('[data-chart-bouncerate]').dataset.chartBouncerate)],
                    backgroundColor: '#dc2626',
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: { y: { beginAtZero: true, max: 100 } }
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
    if (document.getElementById('trendPageLoad')) {
        new Chart(document.getElementById('trendPageLoad').getContext('2d'), {
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
                scales: { y: { beginAtZero: true } }
            }
        });
    }

    // Gráfico de tendencia de tasa de rebote (línea)
    if (document.getElementById('trendBounceRate')) {
        new Chart(document.getElementById('trendBounceRate').getContext('2d'), {
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
                scales: { y: { beginAtZero: true, max: 100 } },
                animation: { duration: 1200, easing: 'easeOutQuart' },
                interaction: { intersect: false },
                hover: { intersect: false },
                tooltips: { enabled: false },
                hoverOffset: 4
            }
        });
    }

    // Pie chart de dispositivos
    if (document.getElementById('chartDevices')) {
        // Soporte dark mode para todos los charts
        const darkMode = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (darkMode) {
            Chart.defaults.color = '#f3f4f6';
            document.documentElement.style.setProperty('--chart-text', '#f3f4f6');
        } else {
            Chart.defaults.color = '#1e293b';
            document.documentElement.style.setProperty('--chart-text', '#1e293b');
        }
    
        // Obtener los datos de dispositivos desde el DOM (puedes mejorarlo con AJAX)
        const deviceLabels = [];
        const deviceCounts = [];
        document.querySelectorAll('#pieDevices').forEach(function(canvas) {
            // Solo uno por ahora
            if (window.devicesData) {
                Object.entries(window.devicesData).forEach(([label, count]) => {
                    deviceLabels.push(label.charAt(0).toUpperCase() + label.slice(1));
                    deviceCounts.push(parseInt(count));
                });
            }
        });
        if (deviceLabels.length > 0) {
            new Chart(document.getElementById('pieDevices').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: deviceLabels,
                    datasets: [{
                        data: deviceCounts,
                        backgroundColor: ['#2563eb','#16a34a','#f59e42','#dc2626'],
                    }]
                },
                options: {
                    plugins: { legend: { position: 'bottom' } }
                }
            });
        }
    }

    // --- AJAX para actualización en tiempo real ---
    let dashboardCharts = {};
    function updateDashboardData(filters = {}) {
        const params = new URLSearchParams(filters).toString();
        fetch('/admin/dashboard/data?' + params)
            .then(res => res.json())
            .then(data => {
                // Actualizar gráficos principales
                if (dashboardCharts.pageLoadBar && data.averagePageLoadTime !== undefined) {
                    dashboardCharts.pageLoadBar.data.datasets[0].data = [data.averagePageLoadTime];
                    dashboardCharts.pageLoadBar.update();
                }
                if (dashboardCharts.bounceBar && data.bounceRate !== undefined) {
                    dashboardCharts.bounceBar.data.datasets[0].data = [data.bounceRate];
                    dashboardCharts.bounceBar.update();
                }
                // Tendencias
                if (dashboardCharts.pageLoadTrend && data.trendPageLoad) {
                    dashboardCharts.pageLoadTrend.data.labels = Array.from({length: data.trendPageLoad.length}, (_,i)=>'Día '+(i+1));
                    dashboardCharts.pageLoadTrend.data.datasets[0].data = data.trendPageLoad;
                    dashboardCharts.pageLoadTrend.update();
                }
                if (dashboardCharts.bounceTrend && data.trendBounceRate) {
                    dashboardCharts.bounceTrend.data.labels = Array.from({length: data.trendBounceRate.length}, (_,i)=>'Día '+(i+1));
                    dashboardCharts.bounceTrend.data.datasets[0].data = data.trendBounceRate;
                    dashboardCharts.bounceTrend.update();
                }
                // Dispositivos
                if (dashboardCharts.devicesPie && data.devices) {
                    dashboardCharts.devicesPie.data.labels = Object.keys(data.devices).map(l=>l.charAt(0).toUpperCase()+l.slice(1));
                    dashboardCharts.devicesPie.data.datasets[0].data = Object.values(data.devices);
                    dashboardCharts.devicesPie.update();
                }
            });
    }
    // Filtros
    document.querySelectorAll('select[name=dateRange], select[name=deviceFilter]').forEach(el=>{
        el.addEventListener('change', function() {
            const filters = {
                dateRange: document.getElementById('dateRange').value,
                deviceFilter: document.getElementById('deviceFilter').value
            };
            updateDashboardData(filters);
        });
    });
    // Actualización periódica
    setInterval(()=>{
        const filters = {
            dateRange: document.getElementById('dateRange').value,
            deviceFilter: document.getElementById('deviceFilter').value
        };
        updateDashboardData(filters);
    }, 60000);

    // --- Guardar preferencias de usuario (localStorage) ---
    function saveDashboardPreferences(prefs) {
        localStorage.setItem('dashboardPrefs', JSON.stringify(prefs));
    }
    function loadDashboardPreferences() {
        try {
            return JSON.parse(localStorage.getItem('dashboardPrefs')) || {};
        } catch { return {}; }
    }
    function applyDashboardPreferences() {
        const prefs = loadDashboardPreferences();
        document.querySelectorAll('[data-metric-section]').forEach(section => {
            const key = section.getAttribute('data-metric-section');
            if (prefs[key] === false) {
                section.style.display = 'none';
            } else {
                section.style.display = '';
            }
        });
    }
    // UI de personalización
    let prefsPanel = null;
    function openPrefsPanel() {
        if (prefsPanel) { prefsPanel.remove(); prefsPanel = null; return; }
        prefsPanel = document.createElement('div');
        prefsPanel.className = 'absolute z-50 bg-white border rounded shadow p-4 right-4 top-24';
        prefsPanel.innerHTML = `<div class='font-bold mb-2'>Personaliza tu Dashboard</div>
            <label class='block'><input type='checkbox' data-pref-metric='performance' checked> Métricas de Rendimiento</label>
            <label class='block'><input type='checkbox' data-pref-metric='inventory' checked> Inventario</label>
            <label class='block'><input type='checkbox' data-pref-metric='clients' checked> Clientes</label>
            <button class='mt-2 px-3 py-1 bg-blue-600 text-white rounded' id='savePrefsBtn'>Guardar</button>`;
        document.body.appendChild(prefsPanel);
        // Cargar estado
        const prefs = loadDashboardPreferences();
        prefsPanel.querySelectorAll('[data-pref-metric]').forEach(cb => {
            const key = cb.getAttribute('data-pref-metric');
            cb.checked = prefs[key] !== false;
        });
        // Guardar
        prefsPanel.querySelector('#savePrefsBtn').onclick = function() {
            const newPrefs = {};
            prefsPanel.querySelectorAll('[data-pref-metric]').forEach(cb => {
                newPrefs[cb.getAttribute('data-pref-metric')] = cb.checked;
            });
            saveDashboardPreferences(newPrefs);
            applyDashboardPreferences();
            prefsPanel.remove();
            prefsPanel = null;
        };
    }
    // Botón principal
    const customizeBtn = document.querySelector('button[title^="Personalizar"]');
    if (customizeBtn) {
        customizeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openPrefsPanel();
        });
    }
    // Botón en el menú de usuario
    const customizeNavBtn = document.getElementById('dashboardCustomizeNavBtn');
    if (customizeNavBtn) {
        customizeNavBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openPrefsPanel();
        });
    }
    applyDashboardPreferences();

});
