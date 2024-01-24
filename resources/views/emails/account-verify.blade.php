@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));
@endphp

@component('mail::message')
# Dear, <span>{{ $user['firstName'] . ' ' . $user['lastName'] }}

We are requesting you to verify your account. Please click the bellow link or submit OTP to verify your account.
your OTP code : <span>{{ $user['code'] }}

@component('mail::button', ['url' => $user['verifyUrl']])
    Verify Here
@endcomponent

Thanks,<br>
{{ $siteInfo->site_name }}
@endcomponent
