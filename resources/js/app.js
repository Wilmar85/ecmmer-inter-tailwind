// resources/js/app.js

import './bootstrap';
import '../sass/main.scss';

// SOLUCIÓN ERROR 1: Importa Chart.js para que se cargue y exponga globalmente.
// No uses "import Chart from 'chart.js';" para evitar el error de default export.
import 'chart.js'; 

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Importa dashboard-charts.js
import './dashboard-charts.js';