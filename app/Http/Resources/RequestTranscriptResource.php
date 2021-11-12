<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestTranscriptResource extends JsonResource
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
            "request_date" => $this->request_date,
            "birth_date" => $this->birth_date,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "course" => $this->course,
            "phone" => $this->phone,
            "email" => $this->email,
            "send_transcript_to" => $this->send_transcript_to,
            "requested_number" => $this->requested_number,
            "file" => $this->file,
            "created_at" => Carbon::make($this->created_at)->format("Y-m-d H:i")
        ];
    }
}
