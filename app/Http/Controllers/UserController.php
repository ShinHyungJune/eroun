<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;

class UserController extends \ShinHyungJune\SocialLogin\Http\UserController
{
    public function socialLogin(Request $request, $social)
    {
        $socialUser = Socialite::driver($social)->user();

        // 일단 네이버
        $user = User::where("social_id", $socialUser->id)->where("social_platform", $social)->first();

        if(!$user) {
            $user = User::create([
                "name" => $social . Carbon::now()->format("Y.m.d.H.i.s"),
                "social_id" => $socialUser->id,
                "social_platform" => $social
            ]);

            Auth::login($user);

            return Inertia::render("Users/Update");
        }

        Auth::login($user);

        return redirect()->intended();
    }

}
