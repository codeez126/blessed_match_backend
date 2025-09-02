<h4 class="repeating-heading">Religious, Sect & Cast</h4>

<div class="row">
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/moon.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Religion</div>
                <div class="adv-heading">{{$user->clientIslamicValue->religion->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/pray.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Sect</div>
                <div class="adv-heading">{{$user->clientIslamicValue->sect->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/cast.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Cast</div>
                <div class="adv-heading">{{$user->clientIslamicValue->cast->name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/cast.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Sub Cast</div>
                <div class="adv-heading">{{$user->clientIslamicValue->sub_cast_name ?? 'N/A'}}</div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/quran.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Quran Memorization</div>
                <div class="adv-heading">
                    {{ $user->clientProfession->quran_memorization === 1 ? 'Yes' : 'No' }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/prayer.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Prayer Frequency</div>
                <div class="adv-heading">
                    {{ $user->clientProfession->prayer_frequency == 1 ? 'Always' : ($user->clientProfession->prayer_frequency == 2 ? 'Sometimes' : ($user->clientProfession->prayer_frequency == 3 ? 'Rarely' : 'N/A')) }}
                </div>
            </div>
        </div>
    </div>
    @if($user->clientAbout->gender_id == 1)
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/beard.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                    <div class="adv-p">Have Beard</div>
                    <div class="adv-heading">
                        {{ $user->clientProfession->is_have_beared == 1 ? 'Yes' : 'No' }}
                    </div>
            </div>
        </div>
    </div>
    @endif
    @if($user->clientAbout->gender_id == 2)
    <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/hijab.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Were Niqab</div>
                <div class="adv-heading">
                    {{ $user->clientProfession->is_where_nikab == 1 ? 'Yes' : 'No' }}
                </div>
            </div>
        </div>
    </div>
        <div class="col-md-6 col-12 theme-card-points">
        <div class="advanced-info-section d-flex align-items-center">
            <img src="{{asset('assets/front/icons/hijab.webp')}}" alt="" width="30" height="30" class="me-3">
            <div class="flex-grow-1">
                <div class="adv-p">Were Hijab</div>
                <div class="adv-heading">
                    {{ $user->clientProfession->is_where_hijab == 1 ? 'Yes' : 'No' }}
                </div>
            </div>
        </div>
    </div>
    @endif

</div>

