@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
# @lang('support.email.ticket_created.greeting', ['name' => $ticket->user->name])

@lang('support.email.ticket_created.line1', ['reference' => $ticket->reference_number])

**@lang('Asunto')**: {{ $ticket->subject }}

> {{ Str::limit($ticket->description, 200) }}

@lang('support.email.ticket_created.line3')

@component('mail::button', ['url' => $url])
@lang('support.email.ticket_created.action')
@endcomponent

@lang('support.email.ticket_created.salutation', ['app_name' => config('app.name')])

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('Todos los derechos reservados.')
@endcomponent
@endslot
@endcomponent
