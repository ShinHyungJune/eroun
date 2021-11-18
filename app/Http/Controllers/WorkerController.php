<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Http\Resources\ReviewReosurce;
use App\Http\Resources\UserResource;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WorkerController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "category_ids" => "nullable|array",
            "word" => "nullable|string|max:500",
            "orderBy" => "nullable|string|max:500",
            "align" => "nullable|string|max:500",
        ]);

        $workers = new User();

        $orderBy = $request->orderBy ? $request->orderBy : "count_request";

        $align = $request->align ? $request->align : "desc";

        $categoryIds =  $request->category_ids ? $request->category_ids : [];

        $word = $request->word ? $request->word : "";

        if($categoryIds && $categoryIds != []) {
            $workers = $workers->whereHas("categories", function ($query) use ($categoryIds) {
                $query->whereIn("categories.id", $categoryIds);
            });
        }

        $workers = $workers->where("name", "LIKE", "%".$word."%");

        $categories = Category::orderBy("order", "asc")->paginate(30, ["*"], "categories_page");

        $workers = $workers->where("worker", true)->where("accepted", true)->orderBy($orderBy, $align)->paginate(30);

        return Inertia::render("Workers/Index", [
            "workers" => UserResource::collection($workers),
            "categories" => CategoryResource::collection($categories),
            "orderBy" => $orderBy,
            "category_ids" => $categoryIds,
            "word" => $word
        ]);
    }

    public function show($id)
    {
        $worker = User::find($id);

        if(!$worker || !$worker->worker)
            return Inertia::render("Errors/404");

        $worker->update(["count_view" => $worker->count_view + 1]);

        $reviews = $worker->receivedReviews()->orderBy("created_at", "desc")->paginate(60);

        return Inertia::render("Workers/Show", [
            "worker" => UserResource::make($worker),
            "reviews" => ReviewReosurce::collection($reviews)
        ]);
    }
}
