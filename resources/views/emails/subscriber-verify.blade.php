@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
@endphp

@component('mail::message')
# Dear, <span>{{ $subscriber['email'] }}

We are requesting you to verify your subscription. Please click the bellow link to verify your subscription.


@component('mail::button', ['url' => $subscriber['verifyUrl']])
    Verify Here
@endcomponent

Thanks,<br>
{{ $siteInfo->site_name }}
@endcomponent
