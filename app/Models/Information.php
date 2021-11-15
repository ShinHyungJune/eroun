<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

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
}
