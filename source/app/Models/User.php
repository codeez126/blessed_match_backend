<?php

namespace App\Models;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'email',
        'phone',
        'password',
        'otp',
        'type',
        'auth_type',
        'auth_id',
        'match_maker_id',
        'app_version',
        'status',
        'onboarding_status',
        'referal_code',
        'platform',
        'region',
    ];


    protected $hidden = [
        'password',
        'otp',
    ];

    public function deviceToken()
    {
        return $this->hasOne(DeviceToken::class);
    }

    public function matchMaker()
    {
        return $this->belongsTo(User::class, 'match_maker_id');
    }

    public function associatedUsers()
    {
        return $this->hasMany(User::class, 'match_maker_id');
    }
    public function mmProfile()
    {
        return $this->hasOne(MmProfile::class);
    }
    public function mmProfiledetails()
    {
        return $this->hasOne(MmProfile::class, 'user_id', 'match_maker_id');
    }

    public function profileAvg()
    {
        return $this->hasOne(UserProfileAvg::class);
    }
    public function clientProfileCard($matchPercentage = null)
    {
        return [
            'id' => $this->id,
            'is_wish_listed' => true,
            'profile_image' => optional($this->clientAbout)->profile_image,
            'full_name' => optional($this->clientAbout)->full_name,
            'gender' => optional($this->clientAbout)->gender,
            'martial_status' => optional($this->clientAbout)->martial_status,
            'age' => optional($this->clientAbout)->dob ? \Carbon\Carbon::parse($this->clientAbout->dob)->age : null,

            'education' => optional(optional($this->clientProfession)->education)->name,
            'occupation' => optional($this->clientProfession->occupationRelation ?? null)->name,

            'cast' => optional(optional($this->clientIslamicValue)->cast)->name,
            'city' => optional($this->clientBackground->cityRelation ?? null)->name,
            'profile_completed' => optional($this->profileAvg)->total_avg,
            'match_percentage' => $matchPercentage,

            'mm_id' => $this->match_maker_id,
            'mm_bussiness_name' => optional($this->mmProfiledetails)->business_name,
            'mm_business_card' => optional($this->mmProfiledetails)->business_card,
            'mm_is_registered' => optional($this->mmProfiledetails)->is_registered,
        ];
    }
    public function clientAbout()
    {
        return $this->hasOne(ClientAbout::class);
    }
    public function wishlists()
    {
        return $this->hasMany(UserWishlist::class, 'user_id');
    }
    public function clientFamilyMembers()
    {
        return $this->hasMany(ClientFamilyMember::class);
    }
    public function clientBackground()
    {
        return $this->hasOne(ClientBackground::class);
    }

    public function clientFamilyInfo()
    {
        return $this->hasOne(ClientFamilyInfo::class);
    }
    public function clientProfession()
    {
        return $this->hasOne(ClientProfession::class);
    }

    public function userBusinesses()
    {
        return $this->hasMany(UserBusiness::class);
    }

    public function clientIslamicValue()
    {
        return $this->hasOne(ClientIslamicValue::class);
    }
    public function clientLifeStyle()
    {
        return $this->hasOne(ClientLifeStyle::class);
    }
    public function nationalities()
    {
        return $this->belongsToMany(Nationality::class, 'client_nationalities');
    }
    public function clientLanguages()
    {
        return $this->hasMany(ClientLanguage::class);
    }
    public function clientHobbies()
    {
        return $this->belongsToMany(Hobby::class, 'client_hobbies');
    }
    public function groupedHobbies()
    {
        $userHobbyIds = $this->clientHobbies()->pluck('hobby_id');

        return Hobby::with(['subHobbies' => function ($query) use ($userHobbyIds) {
            $query->whereIn('id', $userHobbyIds);
        }])
            ->where('type', 0)
            ->whereHas('subHobbies', function ($query) use ($userHobbyIds) {
                $query->whereIn('id', $userHobbyIds);
            })
            ->get();
    }
    public function clientAudioInfo()
    {
        return $this->hasOne(ClientAudioInfo::class);
    }

    public function setting()
    {
        return $this->hasOne(UserSetting::class);
    }
    public function clientImages()
    {
        return $this->hasMany(ClientImage::class);
    }

}
