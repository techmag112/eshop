<?php

namespace Domain\Auth\Actions;

use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;

class RegisterNewUserAction
{

    public function __invoke(array $data): void
    {
        ['name' => $name, 'email' => $email, 'password' => $password] = $data;
        $user = User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        event(new Registered($user));

        auth()->login($user);

        // $request->session()->regenerate();
    }

}
