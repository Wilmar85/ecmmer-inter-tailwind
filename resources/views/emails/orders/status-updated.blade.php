@component('mail::message')
# Actualización de Estado de Pedido

El estado de su pedido #{{ $order->id }} ha sido actualizado.

**Estado Anterior:** {{ $previousStatus }}
**Nuevo Estado:** {{ $newStatus }}

**Detalles del Pedido:**
- Fecha: {{ $order->created_at->format('d/m/Y') }}
- Método de Pago: {{ $order->payment_method }}
- Total: ${{ number_format($order->total, 2) }}

Si tiene alguna pregunta, no dude en contactarnos.

@component('mail::button', ['url' => route('orders.show', $order->id)])
Ver Detalles del Pedido
@endcomponent

Gracias por su compra,
El Equipo de Soporte
@endcomponent
