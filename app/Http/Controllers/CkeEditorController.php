<?php

namespace App\Http\Controllers;

use App\Models\Ckeditor;
use Illuminate\Http\Request;

class CkeEditorController extends Controller
{
    public function upload(Request $request)
    {
        $ckeEditor = Ckeditor::first();

        if(!$ckeEditor)
            $ckeEditor = Ckeditor::create();

        if($request->hasFile("upload")){
            $media = $ckeEditor->addMedia($request->upload)->toMediaCollection("img", "s3");

            return response()->json([
                "url" => $media->getFullUrl()
            ]);
        }
    }
}
