@extends('admin.layouts.app')
@section('contents')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-6">
                    <h3>Countries</h3>
                </div>
                <div class="col-6">
                    <nav>
                        <ol class="breadcrumb justify-content-sm-end align-items-center">
                            <li class="breadcrumb-item"><a href="">
                                    <svg class="svg-color">
                                        <use href="{{ asset('assets/admin/theme/svg/iconly-sprite.svg#Home') }}"></use>
                                    </svg></a></li>
                            <li class="breadcrumb-item">Countries</li>
                            <li class="breadcrumb-item active">List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="p-5">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2 class="mb-0">Countries List</h2>
                                <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">Add Country</a>
                            </div>
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap custom-table" style="width:100%">
                                <thead>
                                <tr class="text-center" style="background-color: transparent !important;">
                                    <th>No.</th>
                                    <th>Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($countries as $index => $country)
                                    <tr class="text-center">
                                        <th>{{ $index+1 }}</th>
                                        <td>{{ $country->name }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-sm btn-success">
                                                <i class="fa fa-pencil-alt"></i> Edit
                                            </a>
{{--                                            <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST" style="display: inline-block;">--}}
{{--                                                @csrf--}}
{{--                                                @method('DELETE')--}}
{{--                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">--}}
{{--                                                    <i class="fa fa-trash"></i> Delete--}}
{{--                                                </button>--}}
{{--                                            </form>--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
