<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\RequestCategoryResource;
use App\Http\Resources\RequestResource;
use App\Http\Resources\RequestStyleResource;
use App\Models\Category;
use App\Models\Charger;
use App\Models\RequestCategory;
use App\Models\RequestStyle;
use App\Models\SMS;
use App\Models\User;
use App\Models\VerifyNumber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "finished" => "nullable|boolean",
            "mine" => "nullable|boolean"
        ]);

        $finished = $request->finished ? $request->finished : "";
        $mine = $request->mine != null ? $request->mine : 0;

        $requests = new \App\Models\Request();

        if($finished)
            $requests = $requests->whereHas("applications", function($query){
                $query->where("selected", true);
            });

        if($mine)
            $requests = $requests->whereHas("applications", function($query){
                $query->where("user_id", auth()->id());
            })->orWhere("user_id", auth()->id());

        $requests = $requests->orderBy("created_at", "desc")->paginate(20);

        return Inertia::render("Requests/Index", [
            "requests" => RequestResource::collection($requests),
            "finished" => $finished,
            "mine" => $mine
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            "worker_id" => "nullable|integer"
        ]);

        $categories = Category::orderBy("created_at", "asc")->paginate(30);

        $requestStyles = RequestStyle::orderBy("created_at", "asc")->paginate(30);

        $requestCategories = RequestCategory::orderBy("created_at", "asc")->paginate(30);

        $workerId = "";

        if($request->worker_id){
            $worker = User::find($request->worker_id);

            $workerId = $worker ? $worker->id : "";
        }

        return Inertia::render("Requests/Create", [
            "requestStyles" => RequestStyleResource::collection($requestStyles),
            "requestCategories" => RequestCategoryResource::collection($requestCategories),
            "worker_id" => $workerId,
            "categories" => CategoryResource::collection($categories)
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "worker_id" => "nullable|integer",
            "title" => "required|string|max:500",
            "category" => "required|string|max:500",
            "time" => "required|integer|min:0|max:50000",
            "address" => "required|string|max:1000",
            "address_detail" => "nullable|string|max:1000",
            "price" => "required|integer|min:0|max:99999999",
            "style" => "required|string|max:500",
            "comment" => "nullable|string|max:50000",
            "required_at" => "required|string|max:500",
            "category_id" => "required|integer"
        ]);

        $category = Category::find($request->category_id);

        $verifyNumber = null;

        if(!auth()->user()) {
            $request->validate(["contact" => "required|string|max:500"]);

            $verifyNumber = VerifyNumber::where("contact", $request->contact)->first();

            if(!$verifyNumber || !$verifyNumber->verified)
                return redirect()->back()->with("error", "인증되지 않은 번호입니다");

            $verifyNumber->delete();
        }

        if(auth()->user()){
            if(!auth()->user()->contact)
                return redirect("/users/edit")->with("error", "연락처를 등록해주세요!");

            $request["user_id"] = auth()->id();

            $request["contact"] = auth()->user()->contact;
        }

        if($request->worker_id){
            $worker = User::find($request->worker_id);

            if(!$worker || !$worker->worker)
                return redirect()->back()->with("error", "존재하지 않는 전문가입니다");
        }

        $request["address"] = $request["address"]." ".$request["address_detail"];

        $createdRequest = \App\Models\Request::create($request->all());

        if($verifyNumber)
            $verifyNumber->delete();

        $sms = new SMS();

        $workers = $request->worker_id ? User::where("id", $request->worker_id)->cursor() : $category->users()->where("worker", true)->cursor();

        foreach($workers as $worker){
            $sms->send("+82".$worker->contact, "라이브커머스 의뢰가 등록되었습니다. ".config("app.url")."/requests");
        }

        return redirect()->back()->with("success", "성공적으로 처리되었습니다.");
    }

    public function show(Request $request, \App\Models\Request $requestModel)
    {
        $applications = $requestModel->applications()->orderBy("created_at", "desc")->paginate(90);

        return Inertia::render("Requests/Show", [
            "request" => RequestResource::make($requestModel),
            "applications" => ApplicationResource::collection($applications)
        ]);
    }
}
