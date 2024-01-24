@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
@endphp
@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
 {{ $siteInfo->site_name }}
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
<div class="d-flex justify-content-between">
   <p> © {{ date('Y') }} {{ $siteInfo->site_name }}. @lang('All rights reserved.')</p>
   <p>developed by: Smart Software Ltd.</p>
</div>
@endcomponent
@endslot
@endcomponent
