@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
@endphp
@component('mail::message')
# Dear, <span>{{ $user['firstName'] . ' ' . $user['lastName'] }}

You have request for reset your password. If you want to change your password please click the bellow link.


@component('mail::button', ['url' => $user['verifyUrl']])
    Verify Here
@endcomponent

Thanks,<br>
{{ $siteInfo->site_name }}
@endcomponent
