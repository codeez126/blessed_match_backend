<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\Country;
use App\Models\Education;
use App\Models\EmploymentStatus;
use App\Models\FamilyClass;
use App\Models\Gender;
use App\Models\Hobby;
use App\Models\HouseSize;
use App\Models\HouseStatus;
use App\Models\Language;
use App\Models\MaritalStatus;
use App\Models\Nationality;
use App\Models\Occupation;
use App\Models\OfficeType;
use App\Models\Pages;
use App\Models\Religion;
use App\Models\SkinType;
use App\Models\User;
use App\Models\UserWishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function simpleHome(Request $request)
    {

        $loggedInUser = User::with('deviceToken')->find(auth('api')->id());
        if ($loggedInUser) {
            $deviceToken = optional($loggedInUser->deviceToken)->device_token;
            $is_login = true;
        } else {
            $deviceToken = null;
            $is_login = false;
        }

        $perPage = $request->get('per_page', 50);
        $clients = User::where('type', 0)->orderBy('id', 'desc')->paginate($perPage);
        $cards = $clients->map(function ($client) {
            return $client->clientProfileCard(); // Call the method properly
        });
        return $this->apiResponse([
            'cards' => $cards,
            'pagination' => [
                'per_page' => $clients->perPage(),
                'total_users' => $clients->total(),
                'current_page' => $clients->currentPage(),
                'next_page_url' => $clients->nextPageUrl(),
            ],
             'device_token' => $deviceToken,
             'is_login' => $is_login,
        ], 'Cards get successfully');
    }

    public function startUp()
    {
        $countries = Country::with('provinces.cities.areas')->get();
        $education = Education::all();
        $nationality = Nationality::orderByRaw("id = 118 DESC")
            ->orderBy('name')
            ->get();
        $religion = Religion::with(['sects', 'casts'])->get();
        $occupation = Occupation::all();
        $martial_statuses = MaritalStatus::all();
        $family_classes = FamilyClass::all();
        $houses_statuses = HouseStatus::all();
        $houses_size = HouseSize::all();
        $gender = Gender::all();
        $employment_statuses = EmploymentStatus::all();
        $languages = Language::all();
        $hobbies = Hobby::all();
        $officeTypes = OfficeType::all();
        $skinTypes = SkinType::all();

        return $this->apiResponse([
                'countries'    => $countries,
                'education'    => $education,
                'nationality'  => $nationality,
                'religion'     => $religion,
                'occupation'   => $occupation,
                'hobbies'   => $hobbies,
                'languages'   => $languages,
                'officeTypes'   => $officeTypes,
                'skinTypes'   => $skinTypes,
                'martial_statuses'   => $martial_statuses,
                'family_classes'   => $family_classes,
                'houses_statuses'   => $houses_statuses,
                'gender'   => $gender,
                'houses_size'   => $houses_size,
                'employment_statuses'   => $employment_statuses,
        ], 'Startup data fetched', 200);
    }

    public function getCountries()
    {
     $countries = Country::with('provinces.cities')->get();
        if (!$countries){
            return $this->apiResponse(['countries' => null], 'countries not found', 404);
        }
     return $this->apiResponse(['countries' => $countries], 'Countries get successfully');
    }
    public function getArea($city_id)
    {
        $areas = Area::where('city_id', $city_id)->get();
        if (!$areas){
            return $this->apiResponse(['areas' => null], 'Area not found', 404);
        }
        return $this->apiResponse(['areas' => $areas], 'Areas get successfully');
    }
    public function getEducation()
    {
     $education = Education::all();

     return $this->apiResponse(['education' => $education], 'Education get successfully');
    }
    public function getNationality()
    {
        $nationality = Nationality::orderByRaw("id = 118 DESC") // put ID 118 on top
        ->orderBy('name')              // then order by name
        ->get();
        return $this->apiResponse(['nationality' => $nationality], 'Nationality get successfully');
    }
    public function getReligion()
    {
     $religion = Religion::with(['sects', 'casts'])->get();
     return $this->apiResponse(['religion' => $religion], 'Religion get successfully');
    }
    public function getLanguages()
    {
     $languages = Language::all();
     return $this->apiResponse(['languages' => $languages], 'Languages get successfully');
    }
    public function getOccupations()
    {
     $occupation = Occupation::all();
     return $this->apiResponse(['occupation' => $occupation], 'Occupation get successfully');
    }
    public function getHobbies()
    {
        $hobbies = Hobby::with('subHobbies')
            ->where('type', 0)
            ->get();
        return $this->apiResponse(['hobbies' => $hobbies], 'Hobbies retrieved successfully');
    }
    public function appAboutUs()
    {
        $aboutPage= Pages::query()->where('page_url', 'app-about-us')->first();
        return $this->apiResponse(['aboutPage' => $aboutPage], 'About us get successfully');
    }
    public function appPrivacy()
    {
        $privacyPage= Pages::query()->where('page_url', 'privacy-policy')->first();
        return $this->apiResponse(['privacyPage' => $privacyPage], 'Privacy Policy get successfully');
    }
    public function appterms()
    {
        $termsPage= Pages::query()->where('page_url', 'terms-and-conditions')->first();
        return $this->apiResponse(['termsPage' => $termsPage], 'Terms and Conditions get successfully');
    }
    public function toggleWishlist(Request $request)
    {
        $request->validate([
            'target_user_id' => 'required|exists:users,id|not_in:' . Auth::id(),
        ]);

        $userId = Auth::id();
        $targetUserId = $request->target_user_id;

        $existing = UserWishlist::where('user_id', $userId)
            ->where('target_user_id', $targetUserId)
            ->first();

        if ($existing) {
            $existing->delete();
            return $this->apiResponse([], 'User removed from wishlist');
        }

        UserWishlist::create([
            'user_id' => $userId,
            'target_user_id' => $targetUserId,
        ]);

        return $this->apiResponse([], 'User added to wishlist');
    }
    public function myWishlist(Request $request)
    {
        $wishList = UserWishlist::with('targetUser')->where('user_id', Auth::id())->get();
        $wishListCards = $wishList->map(function ($wishlist) {
            return $wishlist->targetUser ? $wishlist->targetUser->clientProfileCard() : null;
        })->filter();
        return $this->apiResponse(['wish_lists' => $wishListCards->values()], 'User wishlist');
    }



}
