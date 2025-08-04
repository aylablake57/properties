@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Properties DHA 360')
<img src="http://110.93.206.163:3000/assets/images/logo-transparent.png" class="logo" alt="Properties DHA 360">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
