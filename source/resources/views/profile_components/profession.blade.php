<h4 class="repeating-heading">Profession & Education</h4>

<div class="row">
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/occupation.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Occupation</div>
                <div class="adv-heading">{{$user->clientProfession->occupationRelation->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/occupation.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Occupation Grade</div>
                <div class="adv-heading">{{$user->clientProfession->occupation_grade ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/profession.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Employment Status</div>
                <div class="adv-heading">{{$user->clientProfession->employmentStatus->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/education.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Education</div>
                <div class="adv-heading">{{$user->clientProfession->education->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/profession.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">AVG Income</div>
                <div class="adv-heading">{{$user->clientProfession->avg_income ?? 'N/A'}} <span style="font-weight: normal">RS (Monthly)</span></div>
            </div>
        </div>
    </div>

</div>

