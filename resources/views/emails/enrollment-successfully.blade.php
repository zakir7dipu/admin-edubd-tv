@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
@endphp
@component('mail::message')
# Course Enrollment Successfully

Your Invoice No is #{{ $enrollment['invoiceNo'] }}

Thanks,<br>
{{ $siteInfo->site_name }}
@endcomponent
