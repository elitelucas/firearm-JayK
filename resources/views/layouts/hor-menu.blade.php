<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ Url('dashboard') }}" id="topnav-dashboard" role="button">
                            <i class="bx bx-home-circle mr-2"></i>@lang('translation.Dashboard') 
                        </a>
                    </li>

                    @if(Auth::user()->is_admin==1)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ Url('admin-users') }}" id="topnav-dashboard" role="button">
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
        </nav>
    </div>
</div>
