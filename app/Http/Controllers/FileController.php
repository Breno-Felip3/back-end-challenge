<?php

namespace App\Http\Controllers;

use App\Models\word;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function uploadTxt()
    {
        $filePath  = storage_path('app/words.txt');

        if (file_exists($filePath)) {
            $handle = fopen($filePath, "r");

            if($handle){
                while (($line = fgets($handle)) !== false) {
                    $line = trim($line);
                    word::create([
                        'word' => trim($line),
                    ]);
                }
                fclose($handle);
            }
            return response()->json(['message' => 'File saved successfully!'], 200);
        }

        return response()->json(['message' => 'File not found!'], 200);
    }
}
