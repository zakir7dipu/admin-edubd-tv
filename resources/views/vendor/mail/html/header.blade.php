@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
@endphp
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === $siteInfo->site_name)
<img src="{{ asset($siteInfo->logo) }}" class="logo" style="width: 100%" alt="{{  $siteInfo->site_name }}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
