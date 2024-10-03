<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadTxtRequest;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadTxt(UploadTxtRequest $request)
    {
        $file = $request->file('file');

        $content = file_get_contents($file->getRealPath());

        $lines = explode("/n", $content);
    }
}
