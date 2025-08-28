<h4 class="repeating-heading">Personal Details</h4>

<div class="row">
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/profile.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Full Name</div>
                <div class="adv-heading">{{$user->clientAbout->full_name ?? 'Name Not Available'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/location.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Date of Birth</div>
                <div class="adv-heading">{{$user->clientAbout->dob ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/18+.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Age</div>
                <div class="adv-heading">
                    {{ $user->clientAbout && $user->clientAbout->dob
                        ? \Carbon\Carbon::parse($user->clientAbout->dob)->age
                        : 'N/A' }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/gender.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Gender</div>
                <div class="adv-heading">{{$user->clientAbout->gender->name ?? 'N/A'}}</div>

            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/martial_status.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Martial Status</div>
                <div class="adv-heading">{{$user->clientAbout->maritalStatus->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/gps.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">About Me</div>
                <div class="adv-heading">{{$user->clientAbout->reason_txt ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
</div>


@if($user->clientFamilyMembers->where('type', '1')->isNotEmpty())
<h4 class="repeating-heading">Children</h4>
<div class="row g-2">
    @foreach($user->clientFamilyMembers->where('type', '1') as $sind=>$sibling)
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
