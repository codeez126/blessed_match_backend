@extends('admin.layouts.app')
@section('contents')
    <div class="page-body">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-sm-6">
                    <h3>Site Information</h3>
                </div>
                <div class="col-sm-6">
                    <nav>
                        <ol class="breadcrumb justify-content-sm-end align-items-center">
                            <li class="breadcrumb-item"><a href="">
                                    <svg class="svg-color">
                                        <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Header Info</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                            <div class="container mt-3">

                                <form id="msform headerInfoForm" method="POST" action="{{ route('headerinfoEdit') }}" enctype="multipart/form-data" novalidate>
                                @csrf
                                @method('PUT')
                                <!-- Step 1 -->
                                    <div class="stepper-one step-form mt-5" style="display: block;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="form-label">Site Logo 1</label>
                                                <input class="form-control" name="logo1" type="file" >
                                                <img src="{{asset($headerData->logo1)}}" alt="Logo" style="width: 100px">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Site Logo 2</label>
                                                <input class="form-control" name="logo2" type="file">
                                                <img src="{{asset($headerData->logo2)}}" alt="Logo" style="width: 100px">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Alt</label>
                                                <input class="form-control" name="logo1alt" type="text" value="{{$headerData->logo1alt}}">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Alt</label>
                                                <input class="form-control" name="logo2alt" type="text" value="{{$headerData->logo2alt}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Site Name</label>
                                                <input class="form-control" name="siteName" type="text" value="{{$headerData->siteName}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Site Url</label>
                                                <input class="form-control" name="siteUrl" type="text"  value="{{$headerData->siteUrl}}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Site Email</label>
                                                <input class="form-control" name="siteEmail" type="text" value="{{$headerData->siteEmail}}" >
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Site Phone</label>
                                                <input class="form-control" name="sitePhone" type="text" value="{{$headerData->sitePhone}}">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="form-label">Address</label>
                                                <textarea class="form-control" name="address">{{$headerData->address}}</textarea>
                                            </div>

                                            <div class="col-md-2">
                                                <label class="form-label">Theme Color 1</label>
                                                <input class="form-control form-control-color" name="themecolor1" type="color"  value="{{$headerData->themecolor1}}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Theme Color 2</label>
                                                <input class="form-control form-control-color" name="themecolor2" type="color"  value="{{$headerData->themecolor2}}">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Theme Color 3</label>
                                                <input class="form-control form-control-color" name="themecolor3" type="color"  value="{{$headerData->themecolor3}}">
                                            </div>
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button class="btn btn-primary me-2 btn-square" type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
