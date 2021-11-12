<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            "title" => $this->title,
            "description" => $this->description,
            "count_post" => $this->posts()->count(),
            "bookmark" => auth()->user() && auth()->user()->bookmarks()->where("blog_id", $this->id)->first() ? 1 : 0,
            "subscribe" => auth()->user() && auth()->user()->subscribes()->where("blog_id", $this->id)->first() ? 1 : 0,
            "created_at" => Carbon::make($this->created_at)->format("Y-m-d")
        ];
    }
}
