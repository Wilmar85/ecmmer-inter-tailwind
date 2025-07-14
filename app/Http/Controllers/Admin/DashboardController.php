<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ingresos totales
        $totalRevenue = \App\Models\Order::where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)->sum('total');

        // Ventas por producto (top 10)
        $salesByProduct = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total')
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // Ventas por región/país (usando shipping_state como región y shipping_country si existe)
        $salesByRegion = \App\Models\Order::selectRaw('shipping_state as region, COUNT(*) as total')
            ->where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)
            ->groupBy('shipping_state')
            ->orderByDesc('total')
            ->get();
        // Si tienes shipping_country, puedes agrupar también por ese campo

        // Valor promedio del pedido (AOV)
        $averageOrderValue = \App\Models\Order::where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)->avg('total');

        // Tasa de conversión = pedidos pagados / carritos únicos (usuarios o sesiones)
        $paidOrdersCount = \App\Models\Order::where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)->count();
        $uniqueCartsCount = \App\Models\Cart::distinct('session_id')->count('session_id');
        $conversionRate = $uniqueCartsCount > 0 ? round($paidOrdersCount / $uniqueCartsCount * 100, 2) : null;

        // Tasa de abandono del carrito = (carritos con al menos un ítem y sin pedido pagado) / carritos con al menos un ítem
        $cartsWithItems = \App\Models\Cart::has('items')->count();
        $cartsWithOrder = \App\Models\Order::where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)
            ->distinct('user_id')->count('user_id');
        $cartAbandonmentRate = $cartsWithItems > 0 ? round((($cartsWithItems - $cartsWithOrder) / $cartsWithItems) * 100, 2) : null;

        // Número total de clientes
        $totalCustomers = \App\Models\User::where('role', \App\Models\User::ROLE_CUSTOMER)->count();

        // Nuevos clientes (últimos 30 días)
        $newCustomers = \App\Models\User::where('role', \App\Models\User::ROLE_CUSTOMER)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
        // Clientes recurrentes: han realizado más de un pedido pagado
        $recurrentCustomers = \App\Models\User::where('role', \App\Models\User::ROLE_CUSTOMER)
            ->whereHas('orders', function($q) {
                $q->where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID);
            }, '>', 1)
            ->count();

        // Datos demográficos (por ciudad y estado, top 5)
        $demographicsByCity = \App\Models\User::where('role', \App\Models\User::ROLE_CUSTOMER)
            ->selectRaw('city, COUNT(*) as total')
            ->groupBy('city')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $demographicsByState = \App\Models\User::where('role', \App\Models\User::ROLE_CUSTOMER)
            ->selectRaw('state, COUNT(*) as total')
            ->groupBy('state')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // CLTV (Customer Lifetime Value): promedio de ingresos por cliente
        $cltv = \App\Models\Order::where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)
            ->selectRaw('AVG(total) as avg_order, COUNT(DISTINCT user_id) as user_count, SUM(total) as total_revenue')
            ->first();
        $customerLifetimeValue = ($cltv->user_count ?? 0) > 0 ? round($cltv->total_revenue / $cltv->user_count, 2) : 0;

        // Tasa de retención: clientes con más de un pedido pagado / total clientes con al menos un pedido pagado
        $customersWithOrders = \App\Models\User::where('role', \App\Models\User::ROLE_CUSTOMER)
            ->whereHas('orders', function($q) {
                $q->where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID);
            })
            ->count();
        $retainedCustomers = \App\Models\User::where('role', \App\Models\User::ROLE_CUSTOMER)
            ->whereHas('orders', function($q) {
                $q->where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID);
            }, '>', 1)
            ->count();
        $retentionRate = $customersWithOrders > 0 ? round($retainedCustomers / $customersWithOrders * 100, 2) : null;

        // Tasa de adquisición: nuevos clientes / total clientes (últimos 30 días)
        $acquisitionRate = $totalCustomers > 0 ? round($newCustomers / $totalCustomers * 100, 2) : null;

        // Google Analytics: tráfico y fuentes
        $trafficSummary = null;
        $trafficSources = null;
        try {
            $ga = app(\App\Services\GoogleAnalyticsService::class);
            if ($ga->isConfigured()) {
                $trafficSummary = $ga->getTrafficSummary(30);
                $trafficSources = $ga->getTrafficSources(30);
                $ctr = $ga->getClickThroughRate(30);
                $averagePageLoadTime = $ga->getAveragePageLoadTime(30);
                $bounceRate = $ga->getBounceRate(30);
                $averageSessionDuration = $ga->getAverageSessionDuration(30);
                $devices = $ga->getDevices(30);
            } else {
                $ctr = null;
                $averagePageLoadTime = null;
                $bounceRate = null;
                $averageSessionDuration = null;
                $devices = null;
            }
        } catch (\Throwable $e) {
            $trafficSummary = null;
            $trafficSources = null;
            $ctr = null;
            $averagePageLoadTime = null;
            $bounceRate = null;
            $averageSessionDuration = null;
            $devices = null;
        }

        // INVENTARIO
        // Niveles de stock (todos los productos)
        $stockLevels = \App\Models\Product::select('id', 'name', 'stock')->orderBy('name')->get();

        // Unidades vendidas (por producto)
        $unitsSold = \App\Models\OrderItem::select('product_id')
            ->selectRaw('SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->with('product')
            ->orderByDesc('total_sold')
            ->get();

        // Productos más vendidos (top 10)
        $topSellingProducts = $unitsSold->take(10);

        // Productos de bajo stock (stock <= 5)
        $lowStockProducts = \App\Models\Product::where('stock', '<=', 5)->orderBy('stock')->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'salesByProduct',
            'salesByRegion',
            'averageOrderValue',
            'conversionRate',
            'cartAbandonmentRate',
            'totalCustomers',
            'newCustomers',
            'recurrentCustomers',
            'demographicsByCity',
            'demographicsByState',
            'customerLifetimeValue',
            'retentionRate',
            'acquisitionRate',
            'trafficSummary',
            'trafficSources',
            'ctr',
            'stockLevels',
            'unitsSold',
            'topSellingProducts',
            'lowStockProducts',
            'averagePageLoadTime',
            'bounceRate',
            'averageSessionDuration',
            'devices'
        ));
    }

    /**
     * Devuelve los datos del dashboard para AJAX (filtros: dateRange, deviceFilter)
     */
    public function dashboardData(Request $request)
    {
        $days = (int) $request->input('dateRange', 30);
        $device = $request->input('deviceFilter', 'all');
        $ga = app(\App\Services\GoogleAnalyticsService::class);
        $metrics = [
            'averagePageLoadTime' => null,
            'bounceRate' => null,
            'averageSessionDuration' => null,
            'devices' => [],
            'trendPageLoad' => [],
            'trendBounceRate' => [],
            'sales_stacked_data' => [],
            'sales_by_product' => [],
        ];
        if ($ga->isConfigured()) {
            $metrics['averagePageLoadTime'] = $ga->getAveragePageLoadTime($days);
            $metrics['bounceRate'] = $ga->getBounceRate($days);
            $metrics['averageSessionDuration'] = $ga->getAverageSessionDuration($days);
            $metrics['devices'] = $ga->getDevices($days);
            // Simulación de tendencias (reemplazar por reales)
            $metrics['trendPageLoad'] = array_fill(0, $days-1, rand(15,25)/10);
            $metrics['trendPageLoad'][] = $metrics['averagePageLoadTime'];
            $metrics['trendBounceRate'] = array_fill(0, $days-1, rand(40,50));
            $metrics['trendBounceRate'][] = $metrics['bounceRate'];
            // Filtro por dispositivo (si aplica)
            if ($device !== 'all' && isset($metrics['devices'][$device])) {
                // Aquí podrías filtrar las métricas por dispositivo si tu backend lo soporta
            }
        }
        // --- Ventas apiladas por región y producto (top 5 productos y regiones) ---
        $topProducts = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('product_id');
        $topRegions = \App\Models\Order::selectRaw('shipping_state as region, COUNT(*) as total')
            ->where('payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)
            ->groupBy('shipping_state')
            ->orderByDesc('total')
            ->limit(5)
            ->pluck('region');
        $regionLabels = $topRegions->toArray();
        $datasets = [];
        foreach ($topProducts as $productId) {
            $product = \App\Models\Product::find($productId);
            $data = [];
            foreach ($regionLabels as $region) {
                $qty = \App\Models\OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.payment_status', \App\Models\Order::PAYMENT_STATUS_PAID)
                    ->where('order_items.product_id', $productId)
                    ->where('orders.shipping_state', $region)
                    ->sum('order_items.quantity');
                $data[] = $qty;
            }
            $datasets[] = [
                'label' => $product ? $product->name : 'Producto ' . $productId,
                'data' => $data,
            ];
        }
        $metrics['sales_stacked_data'] = [
            'labels' => $regionLabels,
            'datasets' => $datasets
        ];
        // --- Ventas por producto (top 10) para gráfico ---
        $topSales = \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
        $labels = [];
        $data = [];
        foreach ($topSales as $item) {
            $product = \App\Models\Product::find($item->product_id);
            $labels[] = $product ? $product->name : 'Producto #' . $item->product_id;
            $data[] = (int) $item->total;
        }
        $metrics['sales_by_product'] = [
            'labels' => $labels,
            'data' => $data
        ];
        return response()->json($metrics);
    }
}
