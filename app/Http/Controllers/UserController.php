<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
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
                "social_id" => $socialUser->id,
                "social_platform" => $social
            ]);
        }

        Auth::login($user);

        if(!$user->contact)
            return redirect("users/edit");

        return redirect()->intended();
    }

    public function update(Request $request)
    {
        $request["worker"] = $request->boolean("worker");

        $request->validate([
            "worker" => "required|boolean",
            "contact" => "required|string|max:500",
            "name" => "required|string|max:500",
            "address" => "required|string|max:500",
            "email" => "required|string|max:500",
            "category_id" => "nullable|integer",
        ]);

        if($request->worker) {
            $request->validate([
                "img" => "nullable|image|max:20000",
                "career" => "nullable|string|max:500"
            ]);
        }

        $category = Category::find($request->category_id);

        if($category) {
            auth()->user()->categories()->sync([$category->id]);
        }

        if($request->contact != auth()->user()->contact)
            return redirect()->back()->with("error", "인증되지 않은 연락처입니다.");

        auth()->user()->update([
            "worker" => $request->boolean("worker"),
            "name" => $request->name,
            "address" => $request->address,
            "email" => $request->email,
            "career" => $request->career
        ]);

        if($request->img)
            auth()->user()->addMedia($request->img)->toMediaCollection("img", "s3");

        return redirect("/")->with("success", "성공적으로 처리되었습니다.");
    }

    public function loginForm()
    {
        return Inertia::render("Users/Login");
    }

    public function edit(Request $request)
    {
        $categories = Category::paginate(30);

        return Inertia::render("Users/Edit", [
            "categories" => CategoryResource::collection($categories)
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect("/");
    }
}
