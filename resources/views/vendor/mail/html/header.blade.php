@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('images/logo.png') }}" class="logo" alt="Logo Stuntcare">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
