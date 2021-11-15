<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InformationResource extends JsonResource
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
            "name_company"=>$this->name_company,
            "name_president"=>$this->name_president,
            "number_company"=>$this->number_company,
            "contact"=>$this->contact,
            "charger_privacy"=>$this->charger_privacy,
            "facebook"=>$this->facebook,
            "instagram"=>$this->instagram,
            "kakao"=>$this->kakao,
            "youtube"=>$this->youtube,
        ];
    }
}
