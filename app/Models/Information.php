<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Information extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $appends = ["file"];

    protected $fillable = [
        "name_company",
        "name_president",
        "number_company",
        "contact",
        "charger_privacy",
        "facebook",
        "instagram",
        "kakao",
        "youtube",
    ];

    public function registerMediaCollections():void
    {
        $this->addMediaCollection('file')->singleFile();
    }

    public function getFileAttribute()
    {
        if($this->hasMedia('file')) {
            $media = $this->getMedia('file')[0];

            return [
                "name" => $media->file_name,
                "url" => $media->getFullUrl()
            ];
        }

        return null;
    }
}
