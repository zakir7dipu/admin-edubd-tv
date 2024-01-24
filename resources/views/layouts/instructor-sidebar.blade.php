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

        <li>
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon far fa-book-alt"></i>
                <span class="menu-text" style="font-size: 11.5px">Course Management</span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            <ul class="submenu">
                <li>
                    <a href="{{ route('cm.courses.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Course
                    </a>
                </li>
                <li>
                    <a href="{{ route('cm.course-categories.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Category
                    </a>
                </li>

            </ul>
        </li>

    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
