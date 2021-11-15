<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewReosurce;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "worker_id" => "required|integer",
            "description" => "required|string|max:50000"
        ]);

        $worker = User::find($request->worker_id);

        $review = auth()->user()->reviews()->create($request->all());

        return Inertia::render("/Workers/Show",[
            "review" => ReviewReosurce::make($review)
        ]);
    }
}
