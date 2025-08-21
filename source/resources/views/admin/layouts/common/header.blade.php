<?php
$headerInfo=\App\Models\HeaderInfo::select('*')->first();
?>
<!-- Page header start -->
<header class="page-header row">
    <div class="logo-wrapper d-flex align-items-center col-auto">
        <a href="{{ url('admin/dashboard') }}">
            <img class="for-light" src="{{ asset($headerInfo->logo1) }}" alt="logo" style="width: 118px">
            <img class="for-dark" src="{{ asset($headerInfo->logo1) }}" alt="logo" style="width: 118px">
        </a>
        <a class="close-btn" href="javascript:void(0)">
            <div class="toggle-sidebar">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
        </a>
    </div>
    <div class="page-main-header col">
        <div class="header-left d-lg-block d-none">
            <form class="search-form mb-0">
                <div class="input-group">
                    <span class="input-group-text pe-0">
                        <svg class="search-bg svg-color">
                            <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Search') }}"></use>
                        </svg>
                    </span>
                    <input class="form-control" type="text" placeholder="Search anything...">
                </div>
            </form>
        </div>
        <div class="nav-right">
            <ul class="header-right">
                <!-- Profile menu-->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{asset('assets/admin/theme/images/profile.png')}}" alt="Admin" class="me-2">
                        <div class="flex-grow-1">
                            @if(auth()->user()->type === 2)
                            <h5>Super Admin</h5>
                            <span>{{auth()->user()->name}}</span>
                            @else
                                <h5>{{auth()->user()->name}}</h5>
                                <span>Admin</span>
                            @endif
                        </div>
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="profileDropdown">

                        <li class="dropdown-item d-flex align-items-center">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <svg class="svg-color me-2">
                                    <use href="{{asset('assets/admin/theme/assets/svg/iconly-sprite.svg')}}"></use>
                                </svg>
                                <button type="submit" class="btn btn-link p-0 text-decoration-none">Logout</button>
                            </form>
                        </li>
                    </ul>

                </li>

            </ul>
        </div>
    </div>
</header>
