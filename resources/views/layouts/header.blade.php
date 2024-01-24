<div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
    <div class="navbar-container ace-save-state" id="navbar-container">
        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <div class="navbar-header pull-left">
            <a href="{{ url('home') }}" class="navbar-brand" style="display: flex; align-items: center; gap: 5px;">
                @if (file_exists($siteInfo->logo))
                    <img src="{{ asset($siteInfo->logo) }}" alt="" height="25">
                @else
                    <small style="font-weight: 600; color: #1265D7">
                       Site Logo
                    </small>
                @endif


            </a>
        </div>

        <div class="navbar-buttons navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-10 dropdown-modal">
                    <a data-toggle="dropdown" href="javascript:void(0)" class="dropdown-toggle dark">
                        @if (auth()->user()->image != '' && file_exists(auth()->user()->image))
                            <img src="{{ asset(auth()->user()->image) }}" class="img-circle" width="40px" height="40px" alt="{{ auth()->user()->username }}">
                        @else
                        <img class="nav-user-photo" src="{{ asset('assets/img/default.png') }}" alt="User Photo"
                            style="margin-top: 0px;" />
                         @endif
                        
                        <span class="user-info">
                            <small>Welcome,</small>
                            {{ optional(auth()->user())->username }}
                        </span>
                        <i class="ace-icon dark fa fa-caret-down"></i>
                    </a>
                    <ul
                        class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="{{route('ua.user.change_password')}}">
                                <i class="ace-icon fa fa-user"></i>
                                Change Password
                            </a>
                        </li>

                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                style="display: flex; align-items: center;">
                                <i class="ace-icon far fa-sign-out"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
