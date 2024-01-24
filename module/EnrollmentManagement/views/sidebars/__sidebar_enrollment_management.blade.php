@if ((hasAnyPermission(['enrollment-list-vew'], $slugs) || hasAnyPermission(['coupon-vew'], $slugs)  ))
<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon far fa-tags"></i>
        <span class="menu-text" style="font-size: 11.5px">Enroll Management</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('enrollment-list-vew', $slugs))
        <li>
            <a href="{{ route('em.enrollment.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
            Enrollment List
            </a>
        </li>
        @endif
        @if (hasPermission('coupon-vew', $slugs))
        <li>
            <a href="{{ route('em.coupon.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Coupon
            </a>
        </li>
        @endif
    </ul>
</li>
@endif
@if ((hasAnyPermission(['todat-sales'], $slugs) || hasAnyPermission(['sales-report'], $slugs)  ))
<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-calendar-minus-o"></i>
        <span class="menu-text">Report</span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>

    <ul class="submenu">
        @if (hasPermission('todat-sales', $slugs))
        <li>
            <a href="{{ route('em.report.index') }}">
                <i class="menu-icon fal fa-globe-americas"></i>
                <span class="menu-text"> Today Sales </span>
            </a>
        </li>
        @endif
        @if (hasPermission('sales-report', $slugs))
        <li>
            <a href="{{ route('em.report-all.index') }}">
                <i class="menu-icon fal fa-globe-americas"></i>
                <span class="menu-text">Sales Report</span>
            </a>
        </li>
       @endif
    </ul>
</li>
@endif