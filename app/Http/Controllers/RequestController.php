<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestResource;
use App\Models\User;
use App\Models\VerifyNumber;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $requests = auth()->user()->requests()->orderBy("created_at", "desc")->paginate(20);

        return Inertia::render("/Requests/Index", [
            "requests" => RequestResource::collection($requests)
        ]);
    }

    public function create()
    {
        return Inertia::render("/Requests/Create");
    }

    public function store(Request $request)
    {
        $request->validate([
            "worker_id" => "nullable|integer",
            "category" => "required|string|max:500",
            "time" => "required|integer|min:0|max:50000",
            "address" => "required|string|max:1000",
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
                return redirect()->back()->with("fail", "인증되지 않은 번호입니다");
        }

        if(auth()->user()){
            if(!auth()->user()->contact)
                return Inertia::render("/Users/Update");

            $request["user_id"] = auth()->id();

            $request["contact"] = auth()->user()->contact;
        }

        if($request->worker_id){
            $worker = User::find($request->worker_id);

            if(!$worker || !$worker->worker)
                return redirect()->back()->with("fail", "존재하지 않는 전문가입니다");
        }

        \App\Models\Request::create($request->all());

        if($verifyNumber)
            $verifyNumber->delete();

        return redirect()->back();
    }
}
