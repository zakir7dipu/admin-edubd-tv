<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed sidebar-scroll">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {}
    </script>

    <ul class="nav nav-list">
        <li class="{{ request()->is('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}">
                <i class="menu-icon far fa-home-lg-alt"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
            <b class="arrow"></b>
        </li>

        @foreach (session()->get('menuModules') ?? [] as $menu)
            @php $sidebar_path = getSidebarName($menu) @endphp

            @if ($sidebar_path != '' && view()->exists($sidebar_path))
                @include($sidebar_path)
            @endif
        @endforeach
        @if ((hasAnyPermission(['country-view'], $slugs) || hasAnyPermission(['sate-view'], $slugs) || hasAnyPermission(['city-view'], $slugs)|| hasAnyPermission(['vat-setting-edit'], $slugs) ))
        <li>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-cog"></i>
                <span class="menu-text">Setup</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                @if (hasPermission('country-view', $slugs))
                <li>
                    <a href="{{ route('country.index') }}">
                        <i class="menu-icon fal fa-globe-americas"></i>
                        <span class="menu-text"> Country </span>
                    </a>
                </li>
                @endif
                @if (hasPermission('sate-view', $slugs))
                <li>
                    <a href="{{ route('state.index') }}">
                        <i class="menu-icon far fa-building"></i>
                        <span class="menu-text"> State </span>
                    </a>
                </li>
                @endif
                @if (hasPermission('city-view', $slugs))
                <li>
                    <a href="{{ route('city.index') }}">
                        <i class="menu-icon far fa-city"></i>
                        <span class="menu-text"> City </span>
                    </a>
                </li>
                @endif
                @if (hasPermission('vat-setting-edit', $slugs))
                <li>
                    <a href="{{ route('vat-settings') }}">
                        <i class="menu-icon far fa-percentage"></i>
                        <span class="menu-text"> VAT Setting</span>
                    </a>
                </li>
                @endif
            </ul>
        </li>
        @endif
    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
