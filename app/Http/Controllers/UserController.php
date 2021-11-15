<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VerifyNumber;
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
                "name" => $social.Carbon::now()->format("Y.m.d.H.i.s"),
                "social_id" => $socialUser->id,
                "social_platform" => $social
            ]);

            Auth::login($user);

            return Inertia::render("Users/Update");
        }

        Auth::login($user);

        return redirect()->intended();
    }

    public function update(Request $request)
    {
        $verifyNumber = VerifyNumber::where("contact", $request->contact)->first();

        if(!$verifyNumber || !$verifyNumber->verified)
            return redirect()->back()->with("fail", "인증되지 않은 번호입니다");

        auth()->user()->update([
            "contact" => $request->contact,
            "name" => $request->name,
            "address" => $request->address,
            "email" => $request->email,
        ]);

        $verifyNumber->delete();

        return redirect()->intended()->with("success", "성공적으로 처리되었습니다.");
    }
}
