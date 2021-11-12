<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewReosurce extends JsonResource
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
            "user" => UserResource::make($this->user),
            "worker" => UserResource::make($this->worker),
            "description" => $this->description,
            "score" => rand(0, 5),
            "created_at" => Carbon::make($this->created_at)->format("Y-m-d H:i")
        ];
    }
}
