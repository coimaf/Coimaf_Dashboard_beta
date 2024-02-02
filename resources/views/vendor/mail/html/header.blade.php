@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="{{ asset('assets/coimaf_logo.png') }}" width="20%" alt="logo" alt="Logo-Coimaf">
@endif
</a>
</td>
</tr>
