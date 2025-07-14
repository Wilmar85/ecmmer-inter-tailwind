<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function handleMercadoPago(Request $request)
    {
        try {
            Log::info('MercadoPago Webhook received', ['data' => $request->all()]);

            if ($request->type === 'payment') {
                $paymentId = $request->data['id'];
                $response = Http::get("https://api.mercadopago.com/v1/payments/{$paymentId}", [
                    'headers' => [
                        'Authorization' => 'Bearer ' . config('services.mercadopago.access_token'),
                    ],
                ]);

                $paymentData = $response->json();
                $orderId = $paymentData['external_reference'] ?? null;

                if ($orderId) {
                    $order = Order::find($orderId);
                    if ($order) {
                        switch ($paymentData['status']) {
                            case 'approved':
                                $order->status = 'completed';
                                break;
                            case 'pending':
                                $order->status = 'pending_payment';
                                break;
                            case 'rejected':
                                $order->status = 'failed';
                                break;
                        }
                        $order->save();
                    }
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Error processing MercadoPago webhook', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}