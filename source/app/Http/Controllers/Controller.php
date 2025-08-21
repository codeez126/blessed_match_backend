<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    protected function apiResponse($data = [], $message = 'Success', $status = 200, $errors = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $status == 200 ? $message : null,
            'data' => $data ?? [],
            'errors' => $status != 200 ? ['error' => $message] : $errors,
        ], $status);
    }

    public function uploadImage(UploadedFile $image, $path)
    {
        $path = rtrim($path, '/') . '/'; // ensure trailing slash

        $directory = asset($path);
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        $filename = uniqid() . '-' . Str::random(4) . '.' . $image->getClientOriginalExtension();
        $image->move($directory, $filename);

        return $path . $filename;
    }



}
