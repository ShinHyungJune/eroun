<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\SMS;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {

    }

    public function store(Request $request)
    {
        $request->validate([
            "request_id" => "required|integer",
            "title" => "required|string|max:500",
            "description" => "required|string|max:500",
        ]);

        if(!auth()->user()->educated)
            return redirect()->back()->with("error", "교육이수를 한 전문가만 신청 가능합니다.");

        $requestData = \App\Models\Request::find($request->request_id);

        $prevApplication = auth()->user()->applications()->where("request_id", $request->request_id)->first();

        if($prevApplication)
            return redirect()->back()->with("error", "중복지원은 불가능합니다.");

        auth()->user()->applications()->create([
            "request_id" => $request->request_id,
            "title" => $request->title,
            "description" => $request->description
        ]);

        $sms = new SMS();

        $sms->send("+82".$requestData->user->contact, auth()->user()->name."님께서 섭외요청서에 지원하였습니다. ".config("app.url")."/requests/".$request->request_id);

        return redirect("/requests")->with("success", "성공적으로 처리되었습니다.");
    }

    public function create(Request $request)
    {
        return Inertia::render("Applications/Create", [
            "request_id" => $request->request_id
        ]);
    }

    public function select(Application $application)
    {
        if($application->request->user_id != auth()->id())
            return redirect()->back()->with("error", "권한이 없습니다.");

        $application->update([
            "selected" => true
        ]);

        return redirect()->back()->with("success", "성공적으로 처리되었습니다.");
    }
}
