<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>

                <li class="nav-item">
                    <a class="nav-link" href="dashboard" id="topnav-dashboard" role="button">
                        <i class="bx bx-home-circle mr-2"></i>@lang('translation.Dashboard') 
                    </a>
                </li>

                @if(Auth::user()->is_admin==1)
                <li class="nav-item">
                    <a class="nav-link" href="{{Url('admin-users')}}" id="topnav-dashboard" role="button">
                        <i class="bx bx-user-circle mr-2"></i>@lang('translation.Admin_Users') 
                    </a>
                </li>
                @else
                <li class="nav-item">
                <a class="nav-link" href="{{ Url('customers') }}?id={{Auth::user()->id}}" id="topnav-dashboard" role="button">
                        <i class="bx bx-group mr-2"></i>@lang('translation.Customers') 
                    </a>
                </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->