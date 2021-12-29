<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ReviewReosurce;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CommonUserController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "word" => "nullable|string|max:500",
            "orderBy" => "nullable|string|max:500",
            "align" => "nullable|string|max:500",
        ]);

        $users = new User();

        $orderBy = $request->orderBy ? $request->orderBy : "count_request";

        $align = $request->align ? $request->align : "desc";

        $word = $request->word ? $request->word : "";

        $users = $users->where("name", "LIKE", "%".$word."%");

        $users = $users->where("worker", false)->orderBy($orderBy, $align)->paginate(30);

        return Inertia::render("Users/Index", [
            "users" => UserResource::collection($users),
            "orderBy" => $orderBy,
            "word" => $word
        ]);
    }

    public function show($id)
    {
        $user = User::find($id);

        $user->update(["count_view" => $user->count_view + 1]);

        return Inertia::render("Users/Show", [
            "user" => UserResource::make($user),
        ]);
    }
}
