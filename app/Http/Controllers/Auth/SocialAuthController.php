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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function redirectToProvider($provider)
    {
        if (empty(Config::get('services.' . $provider))) {
            flash('No such provider', 'danger');
            return redirect('/');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        $user = $this->findOrCreateUser(
            Socialite::with($provider)->user(), $provider
        );

        return $this->logIn($user);
    }

    /**
     * Find user or create one.
     *
     * @param $provider_user
     * @param $provider
     * @return $user
     */
    private function findOrCreateUser($provider_user, $provider)
    {
        $provider_identity = Social::firstOrNew(['provider' => $provider, 'provider_id' => $provider_user->id]);

        if($provider_identity->user_id) {
            return $this->user->find($provider_identity->user_id);
        }

        $user = $this->user->firstOrNew(['email' => $provider_user->email]);

        if( ! $user->exists) {
            $user->fill(['name' => $provider_user->name,])->save();
            $user->assignRole('user');
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

        flash('You have been signed in.', 'success');
        return redirect()->intended($this->redirectPath());
    }
}
