<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;
use Carbon\Carbon;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->setScopes(['email', 'guilds', 'identify'])->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $discordUser = Socialite::driver($provider)->user();
        $user = $this->findOrCreateUser($provider, $discordUser);
        auth()->login($user, true);
        $user->last_seen_at = Carbon::now()->format('Y-m-d H:i:s');
        $user->save();
        return redirect()->route('discord.redirect');
    }

    public function findOrCreateUser($provider, $socialiteUser)
    {
        if ($user = $this->findUserBySocialId($provider, $socialiteUser->getId())) {
            $this->changeToken($provider, $user, $socialiteUser);
            return $user;
        }

        if ($user = $this->findUserByEmail($provider, $socialiteUser->getEmail())) {
            $this->changeToken($provider, $user, $socialiteUser);
//            $this->addSocialAccount($provider, $user, $socialiteUser);
            return $user;
        }

        $user = User::create([
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail(),
            'avatar' => $socialiteUser->getAvatar(),
            'password' => bcrypt(Str::random(25)),
        ]);

        $this->addSocialAccount($provider, $user, $socialiteUser);

        return $user;
    }

    public function findUserBySocialId($provider, $id)
    {
        $socialAccount = SocialAccount::where('provider', $provider)->where('provider_id', $id)->first();
        return $socialAccount ? $socialAccount->user : false;
    }

    public function findUserByEmail($provider, $email)
    {
        return User::where('email', $email)->first();
    }

    public function changeToken($provider, $user, $socialiteUser)
    {
        $account = SocialAccount::where('user_id', $user->id)->first();
        if(!$account) {
            $account = $this->addSocialAccount($provider, $user, $socialiteUser);
        }
        $account->token = $socialiteUser->token;
        $account->provider_id = $socialiteUser->getId();
        $user->name = $socialiteUser->getName();
        $user->save();
        return $account->save();
    }

    public function addSocialAccount($provider, $user, $socialiteUser)
    {
        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
        ]);
    }
}
