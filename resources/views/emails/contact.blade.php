<x-mail::message>
# Nuevo mensaje de contacto

**Nombre:** {{ $name }}

**Email:** {{ $email }}

**Mensaje:**

{{ $user_message }}

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
