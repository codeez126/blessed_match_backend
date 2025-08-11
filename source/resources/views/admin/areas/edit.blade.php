@extends('admin.layouts.app')
@section('contents')

    <div class="page-body">
        <div class="container-fluid">
            <div class="row page-title">
                <div class="col-6">
                    <h3>Edit Area</h3>
                </div>
                <div class="col-6">
                    <nav>
                        <ol class="breadcrumb justify-content-sm-end align-items-center">
                            <li class="breadcrumb-item"><a href="{{ route('admin.areas.index') }}">Areas</a></li>
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
                        <form action="{{ route('admin.areas.update', $area->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="country_id">Country</label>
                                <select name="country_id" id="country_id" class="form-control" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}"
                                                @if($country->id == $area->city->province->country_id) selected @endif>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="province_id">Province</label>
                                <select name="province_id" id="province_id" class="form-control" required>
                                    <option value="">Select Province</option>
                                    @foreach($provinces as $province)
                                        <option value="{{ $province->id }}"
                                                data-country="{{ $province->country_id }}"
                                                @if($province->id == $area->city->province_id) selected @endif>
                                            {{ $province->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="city_id">City</label>
                                <select name="city_id" id="city_id" class="form-control" required>
                                    <option value="">Select City</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}"
                                                data-province="{{ $city->province_id }}"
                                                @if($city->id == $area->city_id) selected @endif>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">Area Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                       value="{{ old('name', $area->name) }}" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Area</button>
                            <a href="{{ route('admin.areas.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const countrySelect = document.getElementById('country_id');
                const provinceSelect = document.getElementById('province_id');
                const citySelect = document.getElementById('city_id');

                // Filter provinces based on selected country
                function filterProvinces() {
                    const countryId = countrySelect.value;
                    Array.from(provinceSelect.options).forEach(option => {
                        option.style.display = !countryId || option.value === '' || option.dataset.country === countryId ? '' : 'none';
                    });
                }

                // Filter cities based on selected province
                function filterCities() {
                    const provinceId = provinceSelect.value;
                    Array.from(citySelect.options).forEach(option => {
                        option.style.display = !provinceId || option.value === '' || option.dataset.province === provinceId ? '' : 'none';
                    });
                }

                // Set up event listeners
                countrySelect.addEventListener('change', function() {
                    filterProvinces();
                    filterCities();
                });

                provinceSelect.addEventListener('change', filterCities);

                // Initialize filters
                filterProvinces();
                filterCities();
            });
        </script>
    @endpush

@endsection
