@if ((hasAnyPermission(['admin-view'], $slugs) || hasAnyPermission(['permission-create'], $slugs)  ))
<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fas fa-users-cog"></i>
        <span class="menu-text" style="font-size: 11.5px">Admin</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('admin-view', $slugs))
        <li>
            <a href="{{ route('ua.admin.index') }}">
                <i class="menu-icon fa fa-address-book-o"></i>
                View Admin
            </a>
        </li>
        @endif
        @if (hasPermission('permission-create', $slugs))
        <li>
            <a href="{{ route('ua.permission-access.create') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Permission Access
            </a>
            <b class="arrow"></b>
        </li>
        @endif
    </ul>
   
</li>
@endif