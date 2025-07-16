@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
# @lang('support.email.ticket_response.greeting', ['name' => $ticket->user->name])

@lang('support.email.ticket_response.line1', ['reference' => $ticket->reference_number])

**@lang('Asunto')**: {{ $ticket->subject }}

@lang('support.email.ticket_response.line2')

> {{ $response->content }}

@component('mail::button', ['url' => $url])
@lang('support.email.ticket_response.action')
@endcomponent

@lang('support.email.ticket_response.salutation', ['app_name' => config('app.name')])

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('Todos los derechos reservados.')
@endcomponent
@endslot
@endcomponent
