<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Social;
use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    use RedirectsUsers;

    /**
     * @var User
     */
    private $user;

    /**
     * SocialAuthController constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $provider
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function redirectToProvider($provider)
    {
        if (empty(Config::get('services.' . $provider))) {
            return redirect('/')->with('status', 'No such provider!');
        }

        if ($provider === 'twitter') {
            return Socialite::driver($provider)->redirect();
        }

        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * @param $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        // Twitter returns null for email...
        if ($provider === 'twitter') {
            $user = Socialite::driver($provider)->user();
        } else {
            $user = Socialite::driver($provider)->stateless()->user();
        }

        $user = $this->findOrCreateUser($user, $provider);

        return $this->login($user);
    }

    /**
     * Find user or create one.
     *
     * @param $provider_user
     * @param $provider
     *
     * @return User $user
     */
    private function findOrCreateUser($provider_user, $provider)
    {
        $provider_identity = Social::firstOrNew(['provider' => $provider, 'provider_id' => $provider_user->id]);

        if ($provider_identity->user_id) {
            return $this->user->find($provider_identity->user_id);
        }

        $user = $this->user->firstOrNew(['email' => $provider_user->email]);

        if (!$user->exists) {
            $user->fill(['name' => $this->getName($provider_user),])->save();
        }

        $provider_identity->fill(['user_id' => $user->id,])->save();

        return $user;
    }

    /**
     * Sign in user with flash message.
     *
     * @param $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login($user)
    {
        auth()->login($user, true);

        return redirect()->intended($this->redirectPath())->with('status', 'Welcome back, ' . $user->name, 'success');
    }

    /**
     * Name to be used.
     *
     * @param $provider_user
     *
     * @return mixed
     */
    private function getName($provider_user)
    {
        return ($provider_user->name) ?: $provider_user->nickname;
    }
}
