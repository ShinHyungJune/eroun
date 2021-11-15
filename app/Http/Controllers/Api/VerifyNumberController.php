<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\VerifyNumber;
use App\Models\SMS
use Carbon\Carbon;use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class VerifyNumberController extends ApiController
{
    public function store(Request $request)
    {
        $request->validate([
            "contact" => "required|max:255|unique:users",
        ]);

        $number = random_int(1000,9999);

        $verifyNumber = VerifyNumber::updateOrCreate([
            "contact" => $request->contact
        ],[
            "contact" => $request->contact,
            "number" => $number,
            "verified" => false
        ]);

        $sms = new SMS();

        $sms->send($request->contact, "인증번호 [${number}]\n- ".config("app.name")." -");

        // return $this->respondSuccessfully(null, __("response.verifyNumber")["send mail"]);
        return $this->respondSuccessfully(null, "인증번호가 전송되었습니다.");
    }


    public function update(Request $request)
    {
        $request->validate([
            "user_id" => "required|integer",
            "contact" => "required|unique:users|max:255",
            "number" => "required|max:255",
        ]);

        $user = User::find($request->user_id);

        $verifyNumber = VerifyNumber::where('contact', $request->contact)->where('number', $request->number)->first();

        if(!$verifyNumber)
            return $this->respondNotFound("인증번호가 일치하지 않습니다.");
        // return $this->respondNotFound(__("response.verifyNumber")["do not match"]);

        $verifyNumber->update([
            "verified" => true
        ]);

        $user->update("verified_at", Carbon::now());

        $verifyNumber->delete();

        // return $this->respondSuccessfully($verifyNumber, __("response.verifyNumber")["verified"]);
        return $this->respondSuccessfully(null, "성공적으로 인증되었습니다.");
    }
}
