<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Company extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        "title",
        "description",
        "order"
    ];

    public function registerMediaCollections():void
    {
        $this->addMediaCollection('img')->singleFile();
    }

    protected $appends = ["img"];

    public function getImgAttribute()
    {
        if($this->hasMedia('img')) {
            $media = $this->getMedia('img')[0];

            return [
                "name" => $media->file_name,
                "url" => $media->getFullUrl()
            ];
        }

        return null;
    }
}
