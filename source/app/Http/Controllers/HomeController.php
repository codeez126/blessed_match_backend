<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){

//        $homepage = Pages::query()->where('page_url', 'index')->first();

        $headerInfo=\App\Models\HeaderInfo::select('*')->first();
        $site_phone =$headerInfo->sitePhone ?? '';
        $site_mail =$headerInfo->siteEmail ?? '';
        $site_address =$headerInfo->address ?? '';


        return view('index',[

            'site_phone'=>$site_phone,
            'site_mail'=>$site_mail,
            'site_address'=>$site_address,

            'is_index' => '0',
            'meta_title' => 'Blessed Match',
            'meta_keywords' => 'Blessed Match',
            'meta_description' => 'Blessed Match',
        ]);
    }

    public function clientProfile($share_code)
    {
        $user = User::with([
            'clientAbout',
            'clientFamilyMembers',
            'clientBackground',
            'clientBackground.province',
            'clientBackground.city',
            'clientBackground.area',
            'clientFamilyInfo',
            'clientProfession',
            'clientProfession.education',
            'clientProfession.occupationRelation',
            'userBusinesses',
            'clientIslamicValue',
            'clientIslamicValue.religion',
            'clientIslamicValue.sect',
            'clientIslamicValue.cast',
            'clientLifeStyle.skinType',
            'nationalities',
            'clientLanguages.language',
            'clientImages',
        ])->where('share_code', $share_code)->first();

//        dd($user->clientProfession);exit();
        return view('clientProfile',[
            'user' => $user,
        ]);
    }
    public function signup()
    {
        $headerInfo=\App\Models\HeaderInfo::select('*')->first();
        return view('auth.register', compact('headerInfo'));
    }public function login()
    {
        $headerInfo=\App\Models\HeaderInfo::select('*')->first();
        return view('auth.login', compact('headerInfo'));
    }public function onboarding1()
    {
        $headerInfo=\App\Models\HeaderInfo::select('*')->first();
        return view('auth.onboarding.1', compact('headerInfo'));
    }
}
