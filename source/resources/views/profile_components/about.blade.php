<h4>Personal Details</h4>

<div class="row">
    <div class="col-md-6 col-12" style="padding: 0 20px">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/location.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Full Name</div>
                <div class="adv-heading">{{$user->clientAbout->full_name ?? 'Name Not Available'}}</div>
            </div>
        </div>
    </div>
</div>
