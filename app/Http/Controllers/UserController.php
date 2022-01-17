<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\User;
use App\Models\VerifyNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

        /*
        if(!$user->contact)
            return redirect("users/edit");
        */

        return redirect()->intended();
    }


    public function create()
    {
        $categories = Category::paginate(30);

        return Inertia::render("Users/Create", [
            "categories" => CategoryResource::collection($categories)
        ]);

    }

    public function login(Request $request)
    {
        $data = $request->validate([
            "contact" => "required|string|max:500",
            "password" => "required|string|max:500",
        ]);

        if(auth()->attempt($request->all())) {
            session()->regenerate();

            return redirect("/?show=false");
        }

        return Inertia::render("Users/Login", [
            "errors" => [
                "email" => __("socialLogin.invalid")
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request["worker"] = $request->boolean("worker");

        $request->validate([
            "worker" => "required|boolean",
            "contact" => "required|string|unique:users|max:500",
            "name" => "required|string|max:500",
            "address" => "required|string|max:500",
            "email" => "required|string|max:500",
            "category_id" => "nullable|integer",
            "description" => "nullable|string|max:50000",
            "img" => "nullable|image|max:20000",
            "career" => "nullable|string|max:500",
            "password" => "required|string|max:500|confirmed",

            // 소상공인
            "store" => "nullable|string|max:500",
            "bank" => "nullable|string|max:500",
            "account" => "nullable|string|max:500",
        ]);

        $category = Category::find($request->category_id);

        $request["contact"] = str_replace("-", "", "$request->contact");

        $user = User::create([
            "contact" => $request->contact,
            "worker" => $request->boolean("worker"),
            "name" => $request->name,
            "address" => $request->address,
            "email" => $request->email,
            "description" => $request->description,
            "career" => $request->career,
            "store" => $request->store,
            "bank" => $request->bank,
            "account" => $request->account,
            "password" => Hash::make($request->password)
        ]);

        if($request->img)
            $user->addMedia($request->img)->toMediaCollection("img", "s3");

        if($category)
            $user->categories()->sync([$category->id]);

        return redirect("/login?show=false")->with("success", "성공적으로 가입되었습니다.");
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
            "description" => "nullable|string|max:50000",

            // 소상공인
            "store" => "nullable|string|max:500",
            "bank" => "nullable|string|max:500",
            "account" => "nullable|string|max:500",
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
            "description" => $request->description,
            "career" => $request->career,
            "store" => $request->store,
            "bank" => $request->bank,
            "account" => $request->account,
        ]);

        if($request->img)
            auth()->user()->addMedia($request->img)->toMediaCollection("img", "s3");

        return redirect("/?show=false")->with("success", "성공적으로 처리되었습니다.");
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
