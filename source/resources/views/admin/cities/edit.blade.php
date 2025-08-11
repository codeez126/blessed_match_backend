@extends('admin.layouts.app')
@section('contents')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-6">
                    <h3>Edit City</h3>
                </div>
                <div class="col-6">
                    <nav>
                        <ol class="breadcrumb justify-content-sm-end align-items-center">
                            <li class="breadcrumb-item"><a href="{{ route('admin.cities.index') }}">Cities</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-5">
                        <form action="{{ route('admin.cities.update', $city->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="form-control" required>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $country->id == $city->province->country_id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="province_id">Province</label>
                                <select name="province_id" id="province_id" class="form-control" required>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}" {{ $province->id == $city->province_id ? 'selected' : '' }}>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">City Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $city->name) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update City</button>
                            <a href="{{ route('admin.cities.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
