<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialController extends Controller
{
    /**
     * Redirect the user to the social media authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from the social media.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->stateless()->user();

        // Check if the user exists in the database
        $user = User::where('provider_id', $socialUser->getId())->where('provider', $provider)->first();

        if ($user) {
            // User already exists, log them in
            Auth::login($user);
        } else {
            // Create a new user
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'user_type' => 0, // Set user type to 0
            ]);

            Auth::login($user);
        }

        // Redirect to the intended URL
        return redirect()->intended('/home');
    }
}

