<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Banner extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ["order", "title", "description", "color", "secret"];

    protected $appends = ["mobile", "pc"];

    public function registerMediaCollections():void
    {
        $this->addMediaCollection('mobile')->singleFile();

        $this->addMediaCollection('pc')->singleFile();
    }

    public function getMobileAttribute()
    {
        if($this->hasMedia('mobile')) {
            $media = $this->getMedia('mobile')[0];

            return [
                "name" => $media->file_name,
                "url" => $media->getFullUrl()
            ];
        }

        return null;
    }

    public function getPcAttribute()
    {
        if($this->hasMedia('pc')) {
            $media = $this->getMedia('pc')[0];

            return [
                "name" => $media->file_name,
                "url" => $media->getFullUrl()
            ];
        }

        return null;
    }
}
