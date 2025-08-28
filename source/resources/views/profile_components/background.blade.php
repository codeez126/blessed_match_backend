
{{--background--}}
<h4 class="repeating-heading">Location Information</h4>

<div class="row">
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/province.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Province</div>
                <div class="adv-heading">{{$user->clientBackground->provinceRelation->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/city.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">City</div>
                <div class="adv-heading">{{$user->clientBackground->cityRelation->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/area.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Area</div>
                <div class="adv-heading">{{$user->clientBackground->areaRelation->name ?? 'N/A'}}</div>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/house_status.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">House Status</div>
                <div class="adv-heading">{{$user->clientBackground->houseStatus->name ?? 'N/A'}}</div>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/house_size.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">House Status</div>
                <div class="adv-heading">{{$user->clientBackground->house_size.' Marla' ?? 'N/A'}}</div>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/nationality.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Nationalities</div>
                <div class="adv-heading">
                    @foreach($user->nationalities as $key => $nationality)
                        {{ $nationality->name }}@if(!$loop->last), @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


<h4 class="repeating-heading">Family Information</h4>

<div class="row">
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/occupation.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Father's Occupation</div>
                <div class="adv-heading">{{$user->clientFamilyInfo->father_occupation ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/occupation.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Mother's Occupation</div>
                <div class="adv-heading">{{$user->clientFamilyInfo->mother_occupation ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/cast.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Family Class</div>
                <div class="adv-heading">{{$user->clientFamilyInfo->familyClass->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/alive.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Father Alive</div>
                <div class="adv-heading">
                    @if(isset($user->clientFamilyInfo->is_father_alive))
                        {{ $user->clientFamilyInfo->is_father_alive == 1 ? 'Yes' : 'No' }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/alive.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Mother Alive</div>
                <div class="adv-heading">
                    @if(isset($user->clientFamilyInfo->is_mother_alive))
                        {{ $user->clientFamilyInfo->is_mother_alive == 1 ? 'Yes' : 'No' }}
                    @else
                        N/A
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@if($user->clientFamilyMembers->where('type', '2')->isNotEmpty())
    <h4 class="repeating-heading">Siblings</h4>
    <div class="row g-2">
        @foreach($user->clientFamilyMembers->where('type', '2') as $sind=>$sibling)
            <div class="col-md-4">
                <div style="
                border:1px solid #8C37F8;
                border-radius:5px;
                overflow:hidden;
            ">
                    <table class="table mb-0" style="width:100%; border-collapse:collapse;">
                        <tbody>
                        @if(!empty($sibling->full_name))
                            <tr>
                                <td style="background:#fde9fb; width:40%;"><strong>Name</strong></td>
                                <td>{{ $sibling->full_name }}</td>
                            </tr>
                        @endif

                        @if(!empty($sibling->age))
                            <tr>
                                <td style="background:#fde9fb;"><strong>Age</strong></td>
                                <td>{{ $sibling->age }}</td>
                            </tr>
                        @endif

                        @if(!empty($sibling->gender_id))
                            <tr>
                                <td style="background:#fde9fb;"><strong>Gender</strong></td>
                                <td>{{ $sibling->gender_id == 1 ? 'Male' : ($sibling->gender_id == 2 ? 'Female' : 'N/A') }}</td>
                            </tr>
                        @endif

                        @if(!empty($sibling->maritalStatus?->name))
                            <tr>
                                <td style="background:#fde9fb;"><strong>Marital Status</strong></td>
                                <td>{{ $sibling->maritalStatus->name }}</td>
                            </tr>
                        @endif

                        @if(!empty($sibling->designation))
                            <tr>
                                <td style="background:#fde9fb;"><strong>Designation</strong></td>
                                <td>{{ $sibling->designation }}</td>
                            </tr>
                        @endif

                        @if(!empty($sibling->description))
                            <tr>
                                <td style="background:#fde9fb;"><strong>Description</strong></td>
                                <td>{{ $sibling->description }}</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endif
