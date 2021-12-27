<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ckeditor extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $appends = ["file"];

    public function registerMediaCollections():void
    {
        $this->addMediaCollection('file');
    }
}
