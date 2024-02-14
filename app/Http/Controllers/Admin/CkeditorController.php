<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ImageService;

class CkeditorController extends Controller
{
    public function upload(Request $request, ImageService $imageService)
    {
        if ($request->hasFile('upload')) {

            /* $originName = $request->file('upload')->getClientOriginalName();

            $fileName = pathinfo($originName, PATHINFO_FILENAME);

            $extension = $request->file('upload')->getClientOriginalExtension();

            $fileName = $fileName . '_' . time() . '.' . $extension; */

            //$request->file('upload')->move(public_path('images/ckeditor'), $fileName);
            if ($request->hasFile('upload')) {
                $fileName = $imageService->handleFileUpload('images/ckeditor', $request->file('upload'), '', 'public');
            }
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');

            //$url = asset('storage/images/ckeditor/' . $fileName);
            $url = '/storage/images/ckeditor/' . $fileName;

            $msg = 'Image uploaded successfully';

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');

            echo $response;
        }
    }
}
