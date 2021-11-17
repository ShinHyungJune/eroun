<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
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
            "worker" => $this->worker ? UserResource::make($this->worker) : "",
            "contact" => $this->contact,
            "category" => $this->category,
            "time" => $this->time,
            "address" => $this->address,
            "price" => $this->price,
            "style" => $this->style,
            "comment" => $this->comment,
            "required_at" => Carbon::make($this->required_at)->format("Y-m-d H:i"),
            "created_at" => Carbon::make($this->created_at)->format("m.d")
        ];
    }
}
