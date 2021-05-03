<?php

namespace App\Http\Controllers\Auth;

use App\Common\SocialTypes;
use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function redirect(string $type)
    {
        if(! SocialTypes::has($type))
        {
            abort(404);
        }
        return Socialite::driver($type)->redirect();

    }
    public function handler(string $type)
    {
        if(! SocialTypes::has($type))
        {
            abort(404);
        }

        $user = Socialite::driver($type)->user();
        $dbUser = User::where('social_id', $user->id)->where('auth_type', $type)->first();

        if(! $dbUser)
        {
            $dbUser = new User;
            $dbUser->name = $user->name;
            $dbUser->email = $user->email;
            $dbUser->password = bcrypt('social-user-password');
            $dbUser->social_id = $user->id;
            $dbUser->auth_type = $type;

            $dbUser->save();
        }

        auth()->login($dbUser);

        return redirect('/');

    }
}
