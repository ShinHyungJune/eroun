<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestCategoryResource;
use App\Http\Resources\RequestResource;
use App\Http\Resources\RequestStyleResource;
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
        $requests = auth()->user()->requests()->orderBy("created_at", "desc")->paginate(20);

        return Inertia::render("Requests/Index", [
            "requests" => RequestResource::collection($requests),
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            "worker_id" => "nullable|integer"
        ]);

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
            "worker_id" => $workerId
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            "worker_id" => "nullable|integer",
            "category" => "required|string|max:500",
            "time" => "required|integer|min:0|max:50000",
            "address" => "required|string|max:1000",
            "address_detail" => "nullable|string|max:1000",
            "price" => "required|integer|min:0|max:99999999",
            "style" => "required|string|max:500",
            "comment" => "nullable|string|max:50000",
            "required_at" => "required|string|max:500",
        ]);

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

        \App\Models\Request::create($request->all());

        if($verifyNumber)
            $verifyNumber->delete();

        $chargers = Charger::get();

        $sms = new SMS();

        foreach($chargers as $charger){
            $sms->send("+82".$charger->contact, "새로운 의뢰가 등록되었습니다.\n- ".config("app.name")." -");
        }

        return redirect()->back()->with("success", "성공적으로 처리되었습니다.");
    }
}
