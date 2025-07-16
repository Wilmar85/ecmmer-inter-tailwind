// resources/js/app.js

import './bootstrap';
import '../sass/main.scss';

// Importar Chart.js y registrar los componentes necesarios
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
window.Chart = Chart; 

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

window.Alpine = Alpine;

Alpine.plugin(collapse);

Alpine.start();

// Importa dashboard-charts.js
import './dashboard-charts.js';