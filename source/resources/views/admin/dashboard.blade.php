@extends('admin.layouts.app')
@section('contents')
        <div class="page-body">
            <div class="container-fluid">
                <div class="row page-title">
                    <div class="col-sm-6">
                        <h3>Default dashboard</h3>
                    </div>
                    <div class="col-sm-6">
                        <nav>
                            <ol class="breadcrumb justify-content-sm-end align-items-center">
                                <li class="breadcrumb-item"> <a href="">
                                        <svg class="svg-color">
                                            <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Home') }}"></use>
                                        </svg></a></li>
                                <li class="breadcrumb-item">Dashboard</li>
                                <li class="breadcrumb-item active">Default</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="container-fluid default-dashboard">
               <div class="row">

               </div>
            </div>
        </div>
@endsection
