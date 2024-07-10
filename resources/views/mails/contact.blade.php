<x-mail::message>

# Hola Seller Andershopy

<x-mail::panel>
{{ $data['message'] }}
</x-mail::panel>

**Correo de contacto:** *{{ $data['email'] }}*

</x-mail::message>
{{-- @component('mail::message')

# Hola Seller Andershopy
{{ $data['name'] }} te ha enviado un mensaje desde la web de AnderShopy.

@component('mail::panel')
{{ $data['message'] }}
@endcomponent

Correo de contacto: `{{ $data['email'] }}`

@endcomponent --}}