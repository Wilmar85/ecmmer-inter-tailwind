@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
# @lang('support.email.ticket_updated.greeting', ['name' => $ticket->user->name])

@lang('support.email.ticket_updated.line1', ['reference' => $ticket->reference_number])

**@lang('Estado actual')**: {{ __('support.status.' . $ticket->status) }}

@if($response)
**@lang('Comentario del soporte')**:

> {{ $response->content }}
@endif

@component('mail::button', ['url' => $url])
@lang('support.email.ticket_updated.action')
@endcomponent

@lang('support.email.ticket_updated.salutation', ['app_name' => config('app.name')])

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('Todos los derechos reservados.')
@endcomponent
@endslot
@endcomponent
