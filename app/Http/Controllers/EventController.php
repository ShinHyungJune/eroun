<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            "worker" => "nullable|boolean",
            "word" => "nullable|string|max:500",
            "orderBy" => "nullable|string|max:500",
            "align" => "nullable|string|max:500",
        ]);

        // 전문가용 이벤트를 조회하려고 한다면
        if($request->worker && (!auth()->user() || !auth()->user()->worker))
            return redirect("403");

        $events = new Event();

        $orderBy = $request->orderBy ? $request->orderBy : "count_view";

        $align = $request->align ? $request->align : "desc";

        $worker = $request->worker ? $request->worker : 0;

        $word = $request->word ? $request->word : "";

        $events = $events->where("title", "LIKE", "%".$word."%");

        $events = $events->where("worker", $worker)->orderBy($orderBy, $align)->paginate(9);

        return Inertia::render("Events/Index", [
            "events" => EventResource::collection($events),
            "orderBy" => $orderBy,
            "word" => $word,
            "worker" => $worker
        ]);
    }

    public function show($id)
    {
        $event = Event::find($id);

        if($event->worker && (!auth()->user() || !auth()->user()->worker))
            return Inertia::render("Errors/403");

        $event->update(["count_view" => $event->count_view + 1]);

        return Inertia::render("Events/Show", [
            "event" => EventResource::make($event),
        ]);
    }
}
