<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "img" => $this->img ? $this->img : "",
            "worker" => $this->worker,
            "contact" => $this->contact,
            "email" => $this->email,
            "name" => $this->name,
            "address" => $this->address,
            "career" => $this->career,
            "verified_at" => $this->verified_at ? $this->verified_at : "",
            "count_request" => $this->count_request,
            "count_view" => $this->count_view,
            "score" => $this->receivedReviews()->count() > 0 ? $this->receivedReviews()->avg("score") : "",
            "categories" => CategoryResource::collection($this->categories()->paginate(30)),
            "created_at" => Carbon::make($this->created_at)->format("Y-m-d H:i"),
            "updated_at" => Carbon::make($this->updated_at)->format("Y-m-d H:i")
        ];
    }
}
