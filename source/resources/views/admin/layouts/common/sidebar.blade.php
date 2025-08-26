<!-- Page sidebar start-->
<div class="overlay"></div>
<aside class="page-sidebar" data-sidebar-layout="stroke-svg">
    <div class="left-arrow" id="left-arrow">
        <svg class="feather">
            <use href="{{ asset('assets/admin/theme/svg/feather-icons/dist/feather-sprite.svg#arrow-left') }}"></use>
        </svg>
    </div>
    <div id="sidebar-menu">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="pin-title sidebar-list p-0">
                <h5 class="sidebar-main-title">Pinned</h5>
            </li>
            <li class="line pin-line"></li>
            <li class="sidebar-main-title">General</li>
            <li class="sidebar-list">
                <a class="sidebar-link" href="{{route('superAdminDashboardShow')}}">
                    <svg class="stroke-icon">
                        <use href="{{asset('assets/admin/theme/svg/iconly-sprite.svg#Home')}}"></use>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="line"></li>
            <li class="sidebar-main-title">Components</li>

{{--            site info--}}
            @if(auth()->user()->type === 2)

                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Document') }}"></use>
                        </svg>
                        <span>Payments</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('admin.payment.pending')}}">Pending</a></li>
                        <li><a href="{{route('admin.provinces.index')}}">Approved</a></li>
                        <li><a href="{{route('admin.cities.index')}}">Rejected</a></li>
                    </ul>
                </li>
                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Document') }}"></use>
                        </svg>
                       <span>Locations</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('admin.countries.index')}}">Countries</a></li>
                        <li><a href="{{route('admin.provinces.index')}}">Provinces</a></li>
                        <li><a href="{{route('admin.cities.index')}}">Cities</a></li>
                        <li><a href="{{route('admin.areas.index')}}">Areas</a></li>
                    </ul>
                </li>

                <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="#">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Document') }}"></use>
                        </svg>
                        <span>Religious Info</span></a>
                    <ul class="sidebar-submenu">
                        <li><a href="{{route('admin.religions.index')}}">Religions</a></li>
                    </ul>
                </li>





                <li class="sidebar-list">
                    <a class="sidebar-link" href="{{ route('headerinfo') }}">
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Document') }}"></use>
                        </svg>
                        <span>Site Info</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div class="right-arrow" id="right-arrow">
        <svg class="feather">
            <use href="{{ asset('assets/svg/feather-icons/dist/feather-sprite.svg#arrow-right') }}"></use>
        </svg>
    </div>
</aside>
