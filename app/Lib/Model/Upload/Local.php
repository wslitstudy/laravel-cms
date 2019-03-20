<?php

namespace App\Lib\Model\Upload;

use Illuminate\Support\Facades\Storage;

class Local
{
    public function upload($fileName, $filePath)
    {
        $result = Storage::disk('public')->put($fileName, file_get_contents($filePath));

        if ($result) {
            return env('APP_URL') . '/storage/' . $fileName;
        }

        return false;
    }
}