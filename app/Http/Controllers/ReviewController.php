<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewReosurce;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        return Inertia::render("Reviews/Create", [
            "worker_id" => $request->worker_id
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "worker_id" => "required|integer",
            "description" => "required|string|max:50000",
            "score" => "required|integer|min:1|max:5"
        ]);

        $worker = User::find($request->worker_id);

        if(!$worker)
            return redirect()->back()->with("error", "존재하지 않는 전문가입니다.");

        $review = auth()->user()->reviews()->create($request->all());

        return redirect("/workers/".$request->worker_id)->with("success", "성공적으로 처리되었습니다.");
    }

}
