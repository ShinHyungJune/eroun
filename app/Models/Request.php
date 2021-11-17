<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        "worker_id",
        "contact",
        "category",
        "time",
        "address",
        "price",
        "style",
        "comment",
        "required_at",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worker()
    {
        return $this->belongsTo(User::class,"worker_id");
    }
}
