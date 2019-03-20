<?php

namespace App\Http\Controllers\Admin;

use App\Exceptions\AdminException;
use App\Http\Services\Upload;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    //编辑器上传
    public function editor(Request $request)
    {
        $image = $request->file('iFile');
        //dd($image);
        if ($image->isValid()) {

            $uploadService = new Upload('editor');
            $result = $uploadService->uploadImage($image);

            if ($result) {
                return response()->json(['code' => 1, 'data' => [
                    'file_path' => $result
                ]]);
            }

            throw new AdminException($uploadService->error);

        }

    }

    public function image(Request $request)
    {
        $image = $request->file('iFile');
        //dd($image);
        if ($image->isValid()) {

            $uploadService = new Upload('image');
            $result = $uploadService->uploadImage($image);

            if ($result) {
                return response()->json(['code' => 1, 'data' => [
                    'path' => $result
                ]]);
            }

            throw new AdminException($uploadService->error);

        }

    }
}
