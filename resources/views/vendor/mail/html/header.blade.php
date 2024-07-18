@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Blog Andershopy')
<img src="https://as01.epimg.net/img/arc/logos/as/as.svg" class="logo" alt="Laravel Logo">
{{-- <img src="{{ asset('img/home/1-min.webp') }}" class="logo" alt="Laravel Logo"> --}}
{{-- <img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo"> --}}
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
