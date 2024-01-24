@php
    $siteInfo = optional(\Module\WebsiteCMS\Models\SiteInfo::find(1));

@endphp

<!doctype html>
<html lang="en">

<head>
    @include('layouts.meta')
    @include('layouts.head-links')

    <title>@yield('title') | {{ $siteInfo->site_title }}</title>
    @if (file_exists($siteInfo->fav_icon))
        <link rel="icon" type="image/x-icon" href={{ asset($siteInfo->fav_icon) }}>
    @endif

</head>

<body class="no-skin" style="font-family: monospace;" id="pageContent">
    @include('layouts.header')

    <div class="main-container ace-save-state" id="main-container">

        @if (auth()->check() && auth()->user()->role_id == 1)
        @include('layouts.sidebar')
        @elseif (auth()->check() && auth()->user()->role_id == 2)
        @include('layouts.instructor-sidebar')
        @endif




        <div class="main-content">
            <div class="main-content-inner">
                <div class="page-content">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('layouts.footer')
    </div>

    <form action="" id="deleteItemForm" method="POST">
        @csrf @method('DELETE')
    </form>

    @include('layouts.scripts')
</body>

</html>
