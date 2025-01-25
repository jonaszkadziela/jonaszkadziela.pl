@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ Vite::asset('resources/images/brand/logo-circle.png') }}" alt="Logo" style="width: 64px; margin-bottom: 16px;">
<div>{{ $slot }}</div>
</a>
</td>
</tr>
