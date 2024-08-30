@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/img/logo-01.png') }}" class="logo" alt="HRFACTORY LOG">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
