<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use App\Models\Order;

class WompiController extends Controller
{
    // Muestra el widget de pago Wompi embebido
    public function widget(Order $order)
    {
        return view('orders.wompi_widget', compact('order'));
    }

    // Redirige al usuario al checkout de Wompi
    /**
     * Redirige al usuario al checkout de Wompi usando Payment Links.
     * Documentación oficial: https://docs.wompi.co/docs/link-de-pagos
     */
    public function checkout(Order $order)
    {
        $publicKey = config('services.wompi.public_key');
        $environment = config('services.wompi.environment', 'sandbox');
        $redirectUrl = URL::route('wompi.callback', ['order' => $order->id]);
        $currency = 'COP'; // Ajusta según tu moneda

        // Construir el endpoint correcto para Payment Links
        $endpoint = $environment === 'production'
            ? 'https://production.wompi.co/v1/payment_links'
            : 'https://sandbox.wompi.co/v1/payment_links';

        // Crear el Payment Link
        Log::info('Intentando crear Payment Link en Wompi', [
            'endpoint' => $endpoint,
            'order_id' => $order->id,
            'amount_in_cents' => intval($order->total * 100),
            'environment' => $environment
        ]);
        // Validar email y monto antes de enviar a Wompi
        $customerEmail = $order->email;
        $amountInCents = intval($order->total * 100);
        if (empty($customerEmail)) {
            Log::error('No se puede crear Payment Link Wompi: el usuario no tiene email.', [
                'order_id' => $order->id
            ]);
            return back()->with('error', 'No se puede procesar el pago: tu usuario no tiene email registrado. Por favor actualiza tu perfil.');
        }
        if ($amountInCents <= 0) {
            Log::error('No se puede crear Payment Link Wompi: el monto es inválido.', [
                'order_id' => $order->id,
                'total' => $order->total
            ]);
            return back()->with('error', 'No se puede procesar el pago: el monto de la orden es inválido.');
        }
        $response = Http::post($endpoint, [
            'public_key' => $publicKey,
            'currency' => $currency,
            'amount_in_cents' => $amountInCents,
            'reference' => $order->id,
            'redirect_url' => $redirectUrl,
            'single_use' => true,
            'collect_shipping' => false,
            'customer_email' => $customerEmail,
            'description' => 'Pago pedido #' . $order->id,
        ]);

        if ($response->successful() && isset($response['data']['payment_link_url'])) {
            Log::info('Payment Link Wompi creado exitosamente', [
                'order_id' => $order->id,
                'payment_link_url' => $response['data']['payment_link_url']
            ]);
            return redirect()->away($response['data']['payment_link_url']);
        }

        Log::error('Error creando Payment Link Wompi', [
            'order_id' => $order->id,
            'response' => $response->json()
        ]);
        return back()->with('error', 'No se pudo iniciar el pago con Wompi. Por favor intenta nuevamente o contacta soporte.');
    }


    // Callback/retorno de Wompi
    public function callback(Request $request, $order)
    {
        $order = Order::findOrFail($order);
        $transactionId = $request->query('id');

        if ($transactionId) {
            $environment = config('services.wompi.environment', 'sandbox');
            $url = $environment === 'production'
                ? "https://production.wompi.co/v1/transactions/{$transactionId}"
                : "https://sandbox.wompi.co/v1/transactions/{$transactionId}";
            Log::info('Consultando estado de transacción Wompi', [
                'order_id' => $order->id,
                'transaction_id' => $transactionId,
                'url' => $url
            ]);
            $response = Http::get($url);
            if ($response->successful()) {
                Log::info('Respuesta de Wompi recibida', [
                    'order_id' => $order->id,
                    'transaction_id' => $transactionId,
                    'response' => $response->json()
                ]);
                $status = $response['data']['status'] ?? null;
                if ($status) {
                    switch ($status) {
                        case 'APPROVED':
                            $order->status = 'completed';
                            break;
                        case 'DECLINED':
                        case 'VOIDED':
                        case 'ERROR':
                            $order->status = 'failed';
                            break;
                        case 'PENDING':
                        default:
                            $order->status = 'pending';
                            break;
                    }
                    $order->save();
                }
            }
        }
        return view('orders.wompi_callback', compact('order'));
    }

    // Webhook para notificaciones de Wompi
    public function webhook(Request $request)
    {
        Log::info('Wompi Webhook recibido', ['data' => $request->all()]);
        $event = $request->input('event');
        $transaction = $request->input('data.transaction');
        if ($event === 'transaction.updated' && $transaction) {
            $orderId = $transaction['reference'] ?? null;
            $status = $transaction['status'] ?? null;
            if ($orderId && $status) {
                $order = Order::find($orderId);
                if ($order) {
                    switch ($status) {
                        case 'APPROVED':
                            $order->status = 'completed';
                            break;
                        case 'DECLINED':
                        case 'VOIDED':
                        case 'ERROR':
                            $order->status = 'failed';
                            break;
                        case 'PENDING':
                        default:
                            $order->status = 'pending';
                            break;
                    }
                    $order->save();
                }
            }
        }
        return response()->json(['status' => 'ok']);
    }
}
