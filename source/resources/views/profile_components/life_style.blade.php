<h4 class="repeating-heading">Life Style</h4>

<div class="row">
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/height.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Height</div>
                <div class="adv-heading">{{$user->clientLifeStyle->height ?? '0.0'}} Feet</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/weight.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Weight</div>
                <div class="adv-heading">{{$user->clientLifeStyle->weight ?? '0'}} KG</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <span class="skin-color-span" style="background:  {{$user->clientLifeStyle->skinType->color_code ?? 'black'}}"></span>
            <div class="flex-grow-1">
                <div class="adv-p">Skin Color</div>
                <div class="adv-heading">
                    {{$user->clientLifeStyle->skinType->label ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/hair.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Is Bold</div>
                <div class="adv-heading">
                    {{ $user->clientLifeStyle->hair === 1 ? 'Yes' : ($user->clientLifeStyle->hair === 0 ? 'No' : 'N/A') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/smoking-(1).webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Smoking Habit</div>
                <div class="adv-heading">
                    {{ $user->clientLifeStyle->is_smoking === 1 ? 'Yes' : ($user->clientLifeStyle->is_smoking === 0 ? 'No' : 'N/A') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/wine-bottle.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Alcohol Habit</div>
                <div class="adv-heading">
                    {{ $user->clientLifeStyle->is_alcoholic === 1 ? 'Yes' : ($user->clientLifeStyle->is_alcoholic === 0 ? 'No' : 'N/A') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/smoking.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Have any Tobacco Habit</div>
                <div class="adv-heading">
                    {{ $user->clientLifeStyle->is_tobaco_habit === 1 ? 'Yes' : ($user->clientLifeStyle->is_tobaco_habit === 0 ? 'No' : 'N/A') }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/wheelchair.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Have any Disability</div>
                <div class="adv-heading">
                    <div class="adv-heading">
                        @if($user->clientLifeStyle->disability == 1)
                            Yes {{'! ' .$user->clientLifeStyle->disability_details}}
                        @elseif($user->clientLifeStyle->disability == 0)
                            No
                        @else
                            N/A
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/alive.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Have any Heath Issues</div>
                <div class="adv-heading">
                    <div class="adv-heading">
                        @if($user->clientLifeStyle->health_issue == 1)
                            Yes {{'! ' .$user->clientLifeStyle->health_issue_details}}
                        @elseif($user->clientLifeStyle->health_issue == 0)
                            No
                        @else
                            N/A
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/alive.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Willing to Relocate</div>
                <div class="adv-heading">
                    <div class="adv-heading">
                        @if($user->clientLifeStyle->willing_to_relocate == 1)
                            Yes! i am willing to relocate after marriage
                        @elseif($user->clientLifeStyle->willing_to_relocate == 0)
                            No ! i am not willing to relocate
                        @else
                            N/A
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>

