<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Social;
use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Config;
use Socialite;

class SocialAuthController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    public function redirectToProvider($provider)
    {
        if (empty(Config::get('services.' . $provider))) {
            return view('pages.status')->with('error', 'No such provider');
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $socialUser = null;

        //Check is this email present
        $userCheck = User::where('email', $user->email)->first();

        if( ! empty($userCheck)) {
            $socialUser = $userCheck;
        } else {
            $sameSocialId = Social::where('social_id', $user->id)->where('provider', $provider )->first();

            if(empty($sameSocialId)) {
                //There is no combination of this social id and provider, so create new one
                $newSocialUser = new User;
                $newSocialUser->email = $user->email;
                $newSocialUser->name = $user->name;
                $newSocialUser->save();

                $socialData = new Social;
                $socialData->social_id = $user->id;
                $socialData->provider= $provider;
                $newSocialUser->social()->save($socialData);

                $socialUser = $newSocialUser;
            }else {
                //Load this existing social user
                $socialUser = $sameSocialId->user;
            }

        }

        auth()->login($socialUser, true);

        flash('Welcome back, ' . $user->name, 'success');
        return redirect()->intended($this->redirectPath());
    }
}
