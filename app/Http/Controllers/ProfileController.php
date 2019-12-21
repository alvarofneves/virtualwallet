<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function viewPhoto($fileName){

        \Log::info($fileName);

        $path = public_path('/storage/fotos/').$fileName;

        if (!\File::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = \File::get($path);
        $type = \File::mimeType($path);

        $response = \Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
}
