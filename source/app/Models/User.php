<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
        return $this->hasMany(User::class, 'match_maker_id')->latest();
    }
    public function mmProfile()
    {
        return $this->hasOne(MmProfile::class, 'user_id', 'id')->with('gender');

    }
    public function mmProfiledetails()
    {
        return $this->hasOne(MmProfile::class, 'user_id', 'match_maker_id');
    }
    public function matchMakerProfile()
    {
        return $this->belongsTo(MmProfile::class, 'match_maker_id', 'user_id');
    }

    public function profileAvg()
    {
        return $this->hasOne(UserProfileAvg::class);
    }
    public function getProfileAvgTotalAttribute()
    {
        return $this->profileAvg?->total_avg;
    }
    public function clientProfileCard($matchPercentage = null, $requestingUserId = null)
    {
        $matchRequestData = null;

        if ($requestingUserId) {
            // Check if there's an existing match request between these users
            $matchRequest = MatchRequest::where(function ($query) use ($requestingUserId) {
                $query->where('requesting_user_id', $requestingUserId)
                    ->where('receiving_user_id', $this->id);
            })->orWhere(function ($query) use ($requestingUserId) {
                $query->where('requesting_user_id', $this->id)
                    ->where('receiving_user_id', $requestingUserId);
            })->first();

            if ($matchRequest) {
                $matchRequestData = $matchRequest;
            }
        }
        return [
            'id' => $this->id,
            'status' => $this->status,
            'is_wish_listed' => $this->isWishListedBy(auth('api')->id()),
            'profile_image' => optional($this->clientAbout)->profile_image,
            'full_name' => optional($this->clientAbout)->full_name,
            'gender' => optional($this->clientAbout)->gender ??'',
            'martial_status' => optional($this->clientAbout->maritalStatus)->name,
            'age' => optional($this->clientAbout)->dob ? \Carbon\Carbon::parse($this->clientAbout->dob)->age : null,

            'education' => optional(optional($this->clientProfession)->education)->name,
            'occupation' => optional($this->clientProfession->occupationRelation ?? null)->name,

            'cast' => optional(optional($this->clientIslamicValue)->cast)->name,
            'city' => optional($this->clientBackground->cityRelation ?? null)->name,
            'profile_completed' => optional($this->profileAvg)->total_avg,
            'match_percentage' => $matchPercentage,

            'match_request_send' => $this->sentMatchRequests()->count(),
            'match_request_received' => $this->receivedMatchRequests()->count(),
            'match_request' => $matchRequestData, // New field

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
    // First, let's add some debugging to your isWishListedBy method:
    public function isWishListedBy($userId)
    {
        if (!$userId) {
            return false;
        }
        $exists = UserWishlist::where('user_id', $userId)
            ->where('target_user_id', $this->id)
            ->exists();
        return $exists;
    }
    public function wishlistedBy()
    {
        return $this->hasMany(UserWishlist::class, 'target_user_id');
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
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
    public function sentMatchRequests()
    {
        return $this->hasMany(MatchRequest::class, 'requesting_user_id');
    }

    public function receivedMatchRequests()
    {
        return $this->hasMany(MatchRequest::class, 'receiving_user_id');
    }

    public function sentMmRequests()
    {
        return $this->hasMany(MatchRequest::class, 'requesting_mm_id');
    }

    public function receivedMmRequests()
    {
        return $this->hasMany(MatchRequest::class, 'receiving_mm_id');
    }

    public function activePlan()
    {
        return $this->userPlans()
            ->where('status', UserPlan::STATUS_ACTIVE)
            ->where('expired_at', '>', now())
            ->latest()
            ->first();
    }
    public function activePlans()
    {
        return $this->userPlans()
            ->where('status', UserPlan::STATUS_ACTIVE)
            ->where('expired_at', '>', now())
            ->get();
    }
    public function points()
    {
        return $this->hasMany(UserPoint::class, 'user_id');
    }


}
