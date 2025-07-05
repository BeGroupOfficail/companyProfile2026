<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class SocialLoginController extends Controller
{
    public function redirectToGoogle()
    {
        $googleConfig = config('services.google');
        if (!$googleConfig['client_id'] || !$googleConfig['client_secret'] || !$googleConfig['redirect']) {
            return redirect()->route('login')->with('error', 'Google authentication is not properly configured.');
        }
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->first();

            if ($user) {
                Auth::login($user);
            } else {
                $user = User::updateOrCreate(

                    ['email' => $googleUser->email],
                    [
                        'f_name' => $googleUser->user['given_name'],
                        'l_name' => $googleUser->user['family_name'],
                        'google_id' => $googleUser->id,
                        'password' => bcrypt(uniqid()), // Random password
                        'phone' => null,
                        'nationality_id' => null,
                        'ssn' => null,
                        'gender' => 'male',
                        'job_role'=>'student',
                        'status'=>'active',
                        'email_verified_at'=>now(),
                    ]
                );
                Auth::login($user);
            }

            return redirect()->route('website.home')->with('success', trans('home.Login successfully'));
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }



    public function redirectToFacebook()
    {
        $facebookConfig = config('services.facebook');
        if (!$facebookConfig['client_id'] || !$facebookConfig['client_secret'] || !$facebookConfig['redirect']) {
            return redirect()->route('login')->with('error', 'Facebook authentication is not properly configured.');
        }

        return Socialite::driver('facebook')->with(['redirect_uri' => $facebookConfig['redirect']])->scopes(['email'])->redirect();
    }


    public function handleFacebookCallback()
    {
        try {
            $facebookUser = Socialite::driver('facebook')->user();

            $user = User::where('facebook_id', $facebookUser->id)->first();

            if ($user) {
                Auth::login($user);
            } else {
                $user = User::where('email', $facebookUser->email)->first();
                if ($user) {
                    $user->update(['facebook_id' => $facebookUser->id]);
                } else {
                    $nameParts = $this->splitFacebookName($facebookUser->name);
                    // Create new user
                    $user = User::create([
                        'f_name' => $nameParts['first_name'],
                        'l_name' => $nameParts['last_name'],
                        'email' => $facebookUser->email,
                        'phone' => null,
                        'nationality_id' => null,
                        'ssn' => null,
                        'gender' => 'male',
                        'facebook_id' => $facebookUser->id,
                        'password' => bcrypt(uniqid()),
                        'job_role'=>'student',
                        'status'=>'active',
                        'email_verified_at'=>now(),
                    ]);
                }
                Auth::login($user);
            }

            return redirect()->route('website.home')->with('success', trans('home.Login successfully'));
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    protected function splitFacebookName($fullName) {
        $parts = explode(' ', trim($fullName), 2);

        return [
            'first_name' => $parts[0] ?? '',
            'last_name' => $parts[1] ?? ''
        ];
    }
}
