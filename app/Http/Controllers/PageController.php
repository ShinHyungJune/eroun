<?php

namespace App\Http\Controllers;

use App\Http\Resources\BannerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\ReviewReosurce;
use App\Http\Resources\UserResource;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Company;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy("order", "asc")->where("secret", false)->paginate(30);

        $categories = Category::orderBy("order", "asc")->paginate(30);

        $populatedWorkers = User::where("worker", true)
            ->orderBy("count_request", "desc")
            ->paginate(4);

        $recentWorkers = User::where("worker", true)
            ->orderBy("updated_at", "desc")
            ->paginate(4);

        $newWorkers = User::where("worker", true)
            ->orderBy("created_at", "desc")
            ->paginate(4);

        $counts = [
            "workers" => User::where("worker", true)->count(),
            "requests" => \App\Models\Request::count(),
        ];

        $events = Event::orderBy("created_at", "desc")->paginate(9);

        $companies = Company::orderBy("order", "desc")->paginate(30);

        return Inertia::render("Index", [
            "banners" => BannerResource::collection($banners),
            "categories" => CategoryResource::collection($categories),
            "populatedWorkers" => UserResource::collection($populatedWorkers),
            "recentWorkers" => UserResource::collection($recentWorkers),
            "newWorkers" => UserResource::collection($newWorkers),
            "counts" => $counts,
            "events" => EventResource::collection($events),
            "companies" => CompanyResource::collection($companies)
        ]);
    }
}
