<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

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

        if($request->category_ids)
            $workers = $workers->whereHas("categories", function($query) use ($request){
               $query->whereIn("categories.id", $request->category_ids);
            });

        if($request->word)
            $workers = $workers->where("name", "LIKE", "%".$request->word."%");

        $workers = $workers->where("worker", true)->orderBy($orderBy, $align)->paginate(16);

        return UserResource::collection($workers);
    }
}
