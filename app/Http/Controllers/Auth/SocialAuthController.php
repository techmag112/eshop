<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;


class SocialAuthController extends Controller
{
    public function redirect(string $driver = 'github'): RedirectResponse
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback(string $driver = 'github'): RedirectResponse
    {
        $userSocialite = Socialite::driver($driver)->user();

        $user = User::query()->updateOrCreate([
            $driver . '_id' => $userSocialite->id,
        ], [
            'name' => $userSocialite->name,
            'email' => $userSocialite->email,
            'password' => bcrypt(str()->random(20)),
            // 'github_token' => $githubUser->token,
            // 'github_refresh_token' => $githubUser->refreshToken,
        ]);

        auth()->login($user);

        return redirect()->intended(route('home'));
    }


}
